package esk.lottery.Statistics;

import esk.lottery.RegistrationUpdater.Registration;
import java.util.ArrayList;

/**
 * Αυτή η κλάση συλλέγει στατιστικά που της δίνει το Έμπειρο Σύστημα καθώς
 * εκτελείται. Είναι υπεύθυνη για να τα δομήσει και να ομαδοποιήσει τυχόν
 * παρόμοια δεδομένα.
 * @author Dimosthenis Nikoudis
 */
public class StatisticsCollector {
    ArrayList<Registration> addedRegistrations = new ArrayList<Registration>();
    
    private PreferenceBreakdown preferenceBreakdown = new PreferenceBreakdown();

    public void collectStat(Registration r) {
        Boolean alreadyAdded = false;
        for(Registration curReg : addedRegistrations) {
            if(r.getAM().equals(curReg.getAM()) && r.getLabID().equals(curReg.getLabID()) && r.getInitialPreference() == curReg.getInitialPreference()) {
                alreadyAdded = true; // Η εγγραφή υπάρχει ήδη
            }
        }
        if(!alreadyAdded && !r.getLabID().equals("0")) {
            preferenceBreakdown.addRegistration(r);
            addedRegistrations.add(r);
        }
    }

    /**
     * @return the preferenceBreakdown
     */
    public PreferenceBreakdown getPreferenceBreakdown() {
        return preferenceBreakdown;
    }
}