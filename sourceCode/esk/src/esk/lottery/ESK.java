package esk.lottery;

import esk.lottery.Statistics.StatisticsCollector;
import esk.lottery.DataHandler.*;
import esk.lottery.RegistrationUpdater.RegistrationPriority;
import esk.lottery.RegistrationUpdater.RegistrationUpdater;
import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Arrays;
import jess.*;

/**
 * Συντονίζει όλη την επικοινωνία της Java με το έμπειρο σύστημα. Ο ρόλος της
 * είναι να φορτώνει το έμπειρο σύστημα, να παίρνει δεδομένα μέσα από τις
 * συναρτήσεις του DataHandlerSQL τα οποία τα εισάγει σαν facts στο σύστημα, να
 * εξάγει τα αποτελέσματα και να δημιουργεί τα κατάλληλα αντικείμενα μετα το
 * πέρας της εκτέλεσης και τέλος να τα στέλει πάλι σε κατάλληλες συναρτήσεις του
 * DataHandlerSQL για να περαστούν σε ότι αποθήκες δεδομένων που χρησιμοποιούνται.
 * @author Dimosthenis Nikoudis
 */
public class ESK extends Rete {
    /**
     * Το configuration που χρησιμοποιείται αυτή τη στιγμή από την εφαρμογή.
     */
    protected Config config;
    
    /**
     * Το path όπου βρίσκονται τα αρχεία CLP του Έμπειρου Συστήματος
     */
    protected String expertSystemFilesPath;

    /**
     * Reference της κλάσης που διαχειρίζεται το low-level access στα δεδομένα.
     */
    protected IDataHandler datahandler;

    /**
     * Το αντικείμενο StatisticsCollector που θα συλλέγει στατιστικά.
     */
    protected StatisticsCollector statisticsCollector = new StatisticsCollector();
    
    /**
     * Το αντικείμενο registrationUpdater που θα ενημερώνει την βάση.
     */
    protected RegistrationUpdater registrationUpdater = new RegistrationUpdater();

    /**
     * Το μοναδικό ID της κλήρωσης.
     */
    protected Integer lotteryID;

    /**
     * Δημιουργεί το σύστημα κληρώσεων για το συγκεκριμένο lotteryID. Αυτό δίνει
     * τη δυνατότητα στο σύστημα να γνωρίζει συγκεκριμένα ποιά κλήρωση θα
     * εκτελεστεί αυτή τη στιγμή και να φορτώνει το κατάλληλο configuration που
     * την αφορά (π.χ. ειδικές προταιρεότητες). Επίσης δημιουργείται ένα σχετικό
     * lock που, για αποφυγή φθοράς των δεδομένων, εμποδίζει την εκτέλεση άλλης
     * κλήρωσης την ίδια στιγμή. Το lock φεύγει στον τερματισμό της εφαρμογής.
     * @param lotteryID Το μοναδικό ID της κλήρωσης που θα εκτελεστεί (Integer).
     */
    public ESK(Integer lotteryID, String configPath, String expertSystemFilesPath) {
        this.lotteryID = lotteryID;
        this.config = Config.get(configPath);
        this.expertSystemFilesPath = expertSystemFilesPath;
        datahandler = config.getDataHandler(this);
        expertSystemLoad();
    }

    /**
     * Δημιουργεί το σύστημα κληρώσεων για το συγκεκριμένο lotteryID. Αυτό δίνει
     * τη δυνατότητα στο σύστημα να γνωρίζει συγκεκριμένα ποιά κλήρωση θα
     * εκτελεστεί αυτή τη στιγμή και να φορτώνει το κατάλληλο configuration που
     * την αφορά (π.χ. ειδικές προταιρεότητες). Επίσης δημιουργείται ένα σχετικό
     * lock που, για αποφυγή φθοράς των δεδομένων, εμποδίζει την εκτέλεση άλλης
     * κλήρωσης την ίδια στιγμή. Το lock φεύγει στον τερματισμό της εφαρμογής.
     * @param lotteryID Το μοναδικό ID της κλήρωσης που θα εκτελεστεί (String).
     */
    public ESK(String lotteryID, String configPath, String expertSystemFilesPath) {
        this(Integer.parseInt(lotteryID), configPath, expertSystemFilesPath);
    }

    /**
     * Φορτώνει τους κανόνες και τα templates του έμπειρου συστήματος. Αυτό
     * γίνεται φορτώνοντας όλα τα αρχεία, που βρίσκονται σε τοποθεσία που
     * ορίζεται στο config.properties, με αλφαβητική σειρά.
     */
    public final void expertSystemLoad() {
        try {
            // Φόρτωμα των templates και των κανόνων
            System.out.print("Loading Expert System Files... ");
            File dir = new File(expertSystemFilesPath);
            File fileList[] = dir.listFiles();
            if(fileList == null || fileList.length <= 0) {
                throw new IOException("The folder declared in the config as expertSystemFiles either doesn't exist or it contains no files.");
            }
            Arrays.sort(fileList);
            int i; for(i = 0; i < fileList.length; i++) {
                String filename = fileList[i].getName(); // Βρίσκουμε την κατάληξη του αρχείου
                String ext = (filename.lastIndexOf(".")==-1)?"":filename.substring(filename.lastIndexOf(".")+1,filename.length());
                if(fileList[i].isFile() && ext.equals("clp")) {
                    this.batch(fileList[i].getPath());
                }
            }
            /*this.addDefglobal(new Defglobal("*statisticsCollector*", new Value(statisticsCollector)));
            this.executeCommand("(add ?*statisticsCollector*)");*/
            registrationUpdater.setStatisticsCollector(statisticsCollector);
            this.addDefglobal(new Defglobal("*regUpdater*", new Value(registrationUpdater)));
            this.executeCommand("(add ?*regUpdater*)");
            System.out.println("Done");
        } catch (JessException exc) {
            System.err.println(exc);
            System.err.println(exc.getCause());
        } catch (IOException exc) {
            System.err.println(exc);
            System.exit(-16);
        }
    }

    /**
     * Φορτώνει στο έμπειρο σύστημα τα facts που αφορούν την τρέχουσα κατάσταση
     * των εργαστηρίων. Αυτά που μπορούν να αφορούν πράγματα όπως ώρα/ημέρα,
     * τυχόν ήδη εγγεγραμένους φοιτητές (π.χ. από προηγούμενη κλήρωση) κ.τ.λ.
     * Οι πληροφορίες αυτές παρέχονται μέσα από συναρτήσεις του DataHandlerSQL.
     */
    public final void expertSystemAddFacts() {
        try {
            System.out.print("Getting lab days/hours from the Database... ");
            System.out.println("Done");
            System.out.print("Getting lab info from the Database... ");
            datahandler.addLabInfoFacts();
            System.out.println("Done");
            System.out.print("Getting registered students from the Database... ");
            datahandler.addRegStudentFacts();
            System.out.println("Done");
        } catch (JessException exc) {
            System.err.println(exc);
            System.err.println(exc.getCause());
        }
    }

    /**
     * Φορτώνει τις προτιμήσεις των φοιτητών στο έμπειρο σύστημα (σαν facts) και
     * αρχίζει την εκτέλεση θέτοντας την τιμή "go" στο template "start" σε 1.
     * Όταν η εκτέλεση τελειώσει τα αποτελέσματα εξάγονται από το σύστημα και
     * δίνονται στον DataHandlerSQL για την περαιτέρω επεξεργασία (εκτός αν το
     * config.properties ορίζει ότι το σύστημα είναι σε simulation mode και
     * δεν θα περαστούν δεδομένα στη βάση).
     */
    public void execute() {
        try {
            if(config.getProperty("simulationMode", "1").equals("0")) {
                datahandler.removeSameLotFails();
            }

            this.reset();
            expertSystemAddFacts();

            int i; for(RegistrationPriority curPriority : datahandler.getRegistrationPriorities()) {
                System.out.println("Running the Expert System for registration priority "+curPriority.getPriority()+"...");
                // Προσθήκη των προτιμήσεων των φοιτητών για τη συγκεκριμένη κατηγορία
                ArrayList<Fact> sP = datahandler.getStudentPreferences(curPriority);
                if(sP != null) {
                    for(i = 0; i < sP.size(); i++) {
                        this.assertFact(sP.get(i));
                    }
                }

                this.setFocus("POST_REGISTRATION_TASKS"); // Καθαρισμός τυχόν conflicts με τα ήδη registered τμήματα πριν μπούμε στη φάση εγγραφών
                this.run();
                this.setFocus("LAB_REGISTRATION_MAIN");
                this.run();
                registrationUpdater.join(); // Περιμένουμε να τελειώσουν όλα τα updates
            }
            System.out.println("Done");

            // Αποθήκευση των αποτελεσμάτων στη βάση
            if(config.getProperty("simulationMode", "1").equals("0")) {
                datahandler.removeOldPreferences();
                datahandler.markExecuted();
                // Αποθήκευση στατιστικών
                datahandler.updateStatisticsPreferenceBreakdown(statisticsCollector.getPreferenceBreakdown());
            } else {
                System.out.println("Simulation mode is active. No database changes.");
            }
        } catch (JessException exc) {
            System.err.println(exc);
            System.err.println(exc.getCause());
        }
    }

    /**
     * Επιστρέφει το μοναδικό ID της κλήρωσης που θα εκτελέσει το σύστημα.
     * @return Το μοναδικό ID της κλήρωσης.
     */
    public Integer getLotteryID() {
        return lotteryID;
    }
    
    /**
     * Επιστρέφει το Config που χρησιμοποιεί αυτή τη στιγμή το σύστημα.
     * @return Το Config που χρησιμοποιεί αυτή τη στιγμή το σύστημα.
     */
    public Config getConfig() {
        return config;
    }
    
    /**
     * Επιστρέφει το DataHandler που χρησιμοποιείται από το συγκεκριμένο σύστημα.
     * @return Το DataHandler που χρησιμοποιείται από το συγκεκριμένο σύστημα.
     */
    public IDataHandler getDataHandler() {
        return datahandler;
    }

    /**
     * Επεξεργάζεται τα command-line arguments για να δημιουργήσει το
     * σύστημα κληρώσεων. Τα arguments που μπορεί να λάβει είναι τα εξής:
     * <ol>
     * <li>-lotid lotteryID: Θέτει το lotteryID.</li>
     * </ol>
     * @param args Τα command-line arguments.
     */
    public static void main(String[] args) {
        Integer lotteryID = 1;
        String configPath = "config.properties";
        String expertSystemFilesPath = "expertSystemFiles";
        String arg; int i = 0;
        while (i < args.length && args[i].startsWith("-")) {
            arg = args[i++];
            // Έλεγχος αν έχει οριστεί lotid
            if (arg.toLowerCase().equals("-lotid".toLowerCase())) {
                if (i < args.length) {
                    lotteryID = Integer.parseInt(args[i++]);
                } else {
                    System.err.println("-lotid requires an id");
                    System.exit(-1);
                }
            } else if(arg.toLowerCase().equals("-configPath".toLowerCase())) {
                if (i < args.length) {
                    configPath = args[i++];
                } else {
                    System.err.println("-configPath requires a path");
                    System.exit(-1);
                }
            } else if(arg.toLowerCase().equals("-expertSystemFilesPath".toLowerCase())) {
                if (i < args.length) {
                    expertSystemFilesPath = args[i++];
                } else {
                    System.err.println("expertSystemFilesPath requires a path");
                    System.exit(-1);
                }
            }
        }
        final ESK es = new ESK(lotteryID, configPath, expertSystemFilesPath);
        // Έλεγχος εγκυρότητας των command line arguments
        if (i == args.length - 1) {
            // Μη έγκυρα arguments
            System.err.println("Parameters: [-lotid lotteryID]");
        } else {
            // Έγκυρα arguments
            es.execute();
        } // End else (command line arguments check)
        System.exit(0);
    } // End main
} // End class