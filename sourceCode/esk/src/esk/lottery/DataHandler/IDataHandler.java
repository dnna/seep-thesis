package esk.lottery.DataHandler;

import esk.lottery.RegistrationUpdater.Registration;
import esk.lottery.RegistrationUpdater.RegistrationPriority;
import esk.lottery.Statistics.PreferenceBreakdown;
import java.util.ArrayList;
import jess.*;

/**
 * Διεκπαιρεώνει low-level λειτουργίες που αφορούν την πρόσβαση δεδομένων.
 * Είναι singleton, δηλαδή μπορεί να υπάρχει μόνο ένα αντικείμενο από αυτή την
 * κλάση στο πρόγραμμα, και ο τρόπος για δημιουργηθεί το αντικείμενο ή να
 * ανακτηθεί το reference του είναι με τις στατικές μεθόδους get.
 * @author Dimosthenis Nikoudis
 */
public interface IDataHandler {
    /**
     * Προσπαθεί να δημιουργήσει το lock και επιστρέφει το αν πέτυχε ή όχι. Το
     * lock είναι η μέθοδος συγχρονισμού που χρησιμοποιείται για να εξασφαλιστεί
     * ότι δεν θα τρέχουν περισσότερα από 1 συστήματα κληρώσεων την ίδια στιγμή.
     * Να σημειωθεί ότι ένα lock είναι έγκυρο για μέχρι 24 ώρες.
     * @return true αν πετύχει η δημιουργία του lock ή false αν αποτύχει.
     */
    abstract public Boolean establishLock();

    /**
     * Προσπαθεί να αφαιρέσει το lock και επιστρέφει το αν πέτυχε ή όχι. Το
     * lock είναι η μέθοδος συγχρονισμού που χρησιμοποιείται για να εξασφαλιστεί
     * ότι δεν θα τρέχουν περισσότερα από 1 συστήματα κληρώσεων την ίδια στιγμή.
     * @return true αν πετύχει η αφαίρεση του lock ή false αν αποτύχει.
     */
    abstract public Boolean removeLock();

    /**
     * Αφαιρεί τυχόν αποτυχημένες εγγραφές που ανήκουν στην ίδια κλήρωση με
     * αυτή που θα τρέξει. Ο λόγος που υπάρχει αυτή η συνάρτηση είναι για την
     * καταπολέμηση διαφόρων bugs που εμφανίζονται κατά το debugging.
     */
    abstract public void removeSameLotFails();

    /**
     * Επιστρέφει το αν η εφαρμογή έχει καταφέρει να εγκαθιδρύσει το δικό της
     * lock. Το lock είναι η μέθοδος συγχρονισμού που χρησιμοποιείται για να
     * εξασφαλιστεί ότι δεν θα τρέχουν περισσότερα από 1 συστήματα κληρώσεων την
     * ίδια στιγμή.
     * @return true αν έχει εγκαθιδρύσει το δικό της lock ή false αν όχι.
     */
    abstract public Boolean hasEstablishedLock();

    /**
     * Επιστρέφει τις διαθέσιμες ειδικές προτεραιότητες.
     * @return ένα ArrayList με τις διαθέσιμες ειδικές προτεραιότητες.
     */
    abstract public ArrayList<RegistrationPriority> getRegistrationPriorities();

    /**
     * Επιστρέφει ένα ArrayList με facts που περιέχουν τις προτιμήσεις των
     * φοιτητών μιας συγκεκριμένης κατηγορίας. Κατηγορίες είναι ομάδες φοιτητών
     * που έχουν ομαδοποιηθεί με βάση κάποιο συγκεκριμένο κριτήριο π.χ. λόγω
     * ειδικών προτεραιοτήτων.
     * @param cat Η κατηγορία φοιτητών που ζητάμε.
     * @return Οι προτιμήσεις των φοιτητών αυτής της κατηγορίας.
     * @throws JessException
     */
    abstract public ArrayList<Fact> getStudentPreferences(RegistrationPriority curPriority) throws JessException;

    /**
     * Επιστρέφει ένα Deffacts που περιέχει όλους τους ήδη εγγεγραμμένους
     * φοιτητές.
     * @return Το deffacts με όλους τους ήδη εγγεγραμμένους φοιτητές.
     * @throws JessException
     */
    abstract public void addRegStudentFacts() throws JessException;

    /**
     * Επιστρέφει ένα Deffacts που περιέχει τις πληροφορίες για τα εργαστηριακά
     * τμήματα που χρειάζονται για να γίνουν οι κληρώσεις. Τέτοιες πληροφορίες
     * είναι ο αριθμός εγγεγραμένων φοιτητών, η ώρα/ημέρα του εργαστηρίου, σε
     * ποιό μάθημα ανήκει, αν είναι εργαστήριο για παλαιούς φοιτητές κ.τ.λ.
     * @return Το deffacts με τις πληροφορίες για τα εργαστηριακά τμήματα.
     * @throws JessException
     */
    abstract public void addLabInfoFacts() throws JessException;

    /**
     * Ενημέρωνει την αποθήκη δεδομένων με όλους τους νεο-κληρωθέντες φοιτητές,
     * αλλά και αυτούς που δεν κατάφεραν να εγγραφούν λόγω του ότι όλα τα
     * τμήματα γέμισαν.
     * @param rs ArrayList που έχει εγγραφές (επιτυχημένες ή μη).
     */
    abstract public void updateRegistrations(ArrayList<Registration> registrations);

    /**
     * Αφαιρεί τις παλιές προτιμήσεις των φοιτητών από την αποθήκη δεδομένων.
     */
    abstract public void removeOldPreferences();

    /**
     * Μαρκάρει την τρέχουσα κλήρωση ότι έχει εκτελεστεί.
     */
    abstract public void markExecuted();

    /**
     * Προσθέτει τα στατιστικά που έχουν να κάνουν με τις επιτυχίες/αποτυχίες
     * ανά αριθμό προτεραιότητας στην αποθήκη δεδομένων.
     */
    abstract public void updateStatisticsPreferenceBreakdown(PreferenceBreakdown pb);
}