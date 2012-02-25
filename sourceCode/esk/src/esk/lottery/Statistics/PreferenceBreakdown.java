package esk.lottery.Statistics;

import esk.lottery.RegistrationUpdater.Registration;

/**
 * Δομή που κρατάει στατιστικά για την επιτυχία ανά προτίμηση.
 * @author Dimosthenis Nikoudis
 */
public class PreferenceBreakdown {
    /**
     * Αριθμός επιτυχημένων εγγραφών.
     */
    private Integer [] successfulRegistrations = new Integer[12];
    /**
     * Αριθμός αποτυχημένων εγγραφών.
     */
    private Integer[] failedRegistrations = new Integer[12];
    /**
     * Συνολικός αριθμός εγγραφών (επιτυχημένων και αποτυχημένων).
     */
    private Integer[] totalRegistrations = new Integer[12];

    public PreferenceBreakdown() {
        int i;
        for(i = 0; i < successfulRegistrations.length; i++) {
            successfulRegistrations[i] = 0;
        }
        for(i = 0; i < failedRegistrations.length; i++) {
            failedRegistrations[i] = 0;
        }
        for(i = 0; i < totalRegistrations.length; i++) {
            totalRegistrations[i] = 0;
        }
    }

    /**
     * Προσθέτει μια νέα εγγραφή στα στατιστικά.
     * @param r Το αντικείμενο της εγγραφής.
     */
    public void addRegistration(Registration r) {
        Integer preference = r.getInitialPreference() - 1;
        if(r.isSuccessful()) {
            successfulRegistrations[preference]++;
        } else {
            failedRegistrations[preference]++;
        }
        totalRegistrations[preference]++;
    }

    /**
     * @return the successfulRegistrations
     */
    public Integer[] getSuccessfulRegistrations() {
        return successfulRegistrations;
    }

    /**
     * @return the failedRegistrations
     */
    public Integer[] getFailedRegistrations() {
        return failedRegistrations;
    }

    /**
     * @return the totalRegistrations
     */
    public Integer[] getTotalRegistrations() {
        return totalRegistrations;
    }
}