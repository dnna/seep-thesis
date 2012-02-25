package esk.lottery.RegistrationUpdater;

import esk.lottery.Config;
import esk.lottery.Statistics.StatisticsCollector;
import java.util.ArrayList;
import java.util.Collection;
import java.util.ConcurrentModificationException;
import java.util.HashMap;

/**
 * Συγκεντρώνει εγγραφές (επιτυχείς και ανεπτυχείς) από το έμπειρο σύστημα και
 * όταν φτάσει σε ένα συγκεκριμένο νούμερο (δηλωμένο σαν σταθερά στο config)
 * ανήγει ένα ξεχωριστό thread και ενημερώνει την αποθήκη δεδομένων.
 * @author Dimosthenis Nikoudis
 */
public class RegistrationUpdater implements Runnable {
    /**
     * Ο πίνακας που κρατάει τις εγγραφές που πρόκειται να περαστούν στη βάση.
     */
    protected ArrayList<Registration> registrations = new ArrayList<Registration>();
    
    /**
     * Πίνακας που κρατάει τα διάφορα update threads.
     */
    protected HashMap registrationUpdaterThreads = new HashMap();
    
    /**
     * Ο αριθμός των εγγραφών που πρέπει να συγκεντρωθεί για να γίνει update
     * στην βάση. Το update θα γίνει σε ξεχωριστό thread.
     */
    protected Integer registrationsBeforeUpdate;
    
    /**
     * Το αντικείμενο StatisticsCollector που θα συλλέγει στατιστικά.
     * Χρειάζεται εδώ για να του στέλνει updates ο RegistrationUpdater.
     */
    protected StatisticsCollector statisticsCollector;
    
    /**
     * Αρχικοποιεί το αντικείμενο RegistrationUpdater.
     * @param registrationsBeforeUpdate Ο αριθμός των εγγραφών που πρέπει να
     * συγκεντρωθεί για να γίνει update στην βάση.
     */
    public RegistrationUpdater(Integer registrationsBeforeUpdate) {
        this.registrationsBeforeUpdate = registrationsBeforeUpdate;
    }
    
    /**
     * Αρχικοποιεί το αντικείμενο RegistrationUpdater. Ορίζει μια default τιμή
     * στην ιδιότητα registrationsBeforeUpdate (200).
     */
    public RegistrationUpdater() {
        this(600);
    }
    
    public void addRegistration(Registration r) {
        // Ενημέρωση των στατιστικών
        if(statisticsCollector != null) {
            statisticsCollector.collectStat(r);
        }
        registrations.add(r);
        if(registrations.size() >= registrationsBeforeUpdate) {
            update();
        }
    }
    
    public void update() {
        Thread thread = new Thread(this);
        registrationUpdaterThreads.put(thread.getId(), thread);
        thread.start();
    }
    
    public void join() {
        update(); // Πριν κάνουμε join εξασφαλίζουμε ότι έχουν γίνει όλα τα updates
        synchronized(this) {
            try {
                Collection<Thread> registrationUpdaterThreadsCollection = registrationUpdaterThreads.values();
                for(Thread thread : registrationUpdaterThreadsCollection) {
                    try {
                        thread.join();
                    } catch (InterruptedException ex) {
                        System.err.println(ex.toString());
                    }
                }
            } catch(ConcurrentModificationException ex) {
                //System.err.println(ex);
                //System.err.println(ex.getCause());
            }
        }
    }
    
    /**
     * Το thread που θα ενημερώσει την αποθήκη δεδομένων. Όταν τελειώσει αυτή η
     * συνάρτηση το αντικείμενο δεν θα περιέχει καμία εγγραφή.
     */
    public void run() {
        // Αποθήκευση των αποτελεσμάτων στη βάση
        if(Config.get().getProperty("simulationMode", "1").equals("0")) {
            ArrayList<Registration> tempReg = new ArrayList<Registration>(registrations);
            registrations = new ArrayList<Registration>();
            Config.get().getDataHandler().updateRegistrations(tempReg);
        } else {
            System.out.println("Simulation mode is active. No database changes.");
        }
        registrationUpdaterThreads.remove(Thread.currentThread().getId()); // Remove the thread after its finished
    }

    /**
     * Δηλώνει ένα αντικείμενο StatisticsCollector ώστε να του στέλονται
     * στατιστικά για κάθε επιτυχημένη/αποτυχημένη εγγραφή.
     * @param statisticsCollector Το αντικείμενο που θα συλλέγει τα στατιστικά.
     */
    public void setStatisticsCollector(StatisticsCollector statisticsCollector) {
        this.statisticsCollector = statisticsCollector;
    }

    /**
     * Επιστρέφει το αντικείμενο StatisticsCollector που έχει δηλωθεί για να
     * συλλέγει στατιστικά.
     * @return Το αντικείμενο που έχει δηλωθεί για να συλλέγει στατιστικά.
     */
    public StatisticsCollector getStatisticsCollector() {
        return this.statisticsCollector;
    }
}