package esk.lottery.RegistrationUpdater;

/**
 * Δομή που περιέχει την προσπάθεια εγγραφής ενός σπουδαστή σε ένα τμήμα.
 * @author Dimosthenis Nikoudis
 */
public class Registration {
    /**
     * Ο αριθμός μητρώου του σπουδαστή.
     */
    protected String AM;
    /**
     * Ο κωδικός του εργαστηριακού τμήματος στο οποίο κληρώθηκε ή απέτυχε να
     * κληρωθεί ο σπουδαστής.
     */
    protected String labID;
    /**
     * Ο κωδικός του μαθήματος στο οποίο ανήκει το τμήμα.
     */
    protected String courseID;
    /**
     * Η προτεραιότητα με την οποία είχε δηλωθεί το συγκεκριμένο εργαστήριο.
     */
    private Integer initialPreference;
    /**
     * Επιτυχής ή ανεπιτυχής εγγραφή.
     */
    protected Boolean successful;
    /**
     * Επιπρόσθετες λεπτομέρειες που αφορούν τη συγκεκριμένη εγγραφή (πχ. λόγος
     * αποτυχίας).
     */
    protected String details;

    /**
     *
     * @param AM Ο αριθμός μητρώου του σπουδαστή.
     * @param IDL Ο κωδικός του τμήματος στο οποίο κληρώθηκε ή απέτυχε να
     * κληρωθεί ο σπουδαστής.
     * @param IDS Ο κωδικός του μαθήματος στο οποίο ανήκει το τμήμα.
     * @param successful Αν η εγγραφή ήταν επιτυχής ή ανεπιτυχής.
     */
    public Registration(String AM, String labID, String courseID, Integer initialPreference, Boolean successful) {
        this(AM, labID, courseID, initialPreference, successful, "");
    }

    /**
     * @param AM Ο αριθμός μητρώου του σπουδαστή.
     * @param IDL Ο κωδικός του τμήματος στο οποίο κληρώθηκε ή απέτυχε να
     * κληρωθεί ο σπουδαστής.
     * @param IDS Ο κωδικός του μαθήματος στο οποίο ανήκει το τμήμα.
     * @param successful Αν η εγγραφή ήταν επιτυχής ή ανεπιτυχής.
     */
    public Registration(String AM, String labID, String courseID, Integer initialPreference, String successful) {
        this(AM, labID, courseID, initialPreference, successful, "");
    }

    /**
     * @param AM Ο αριθμός μητρώου του φοιτητή.
     * @param IDL Ο κωδικός του τμήματος στο οποίο κληρώθηκε ή απέτυχε να
     * κληρωθεί ο σπουδαστής.
     * @param IDS Ο κωδικός του μαθήματος στο οποίο ανήκει το τμήμα.
     * @param successful Αν η εγγραφή ήταν επιτυχής ή ανεπιτυχής.
     * @param details Επιπρόσθετες λεπτομέριες που αφορούν τη συγκεκριμένη
     * εγγραφή (πχ. λόγος αποτυχίας).
     */
    public Registration(String AM, String labID, String courseID, Integer initialPreference, Boolean successful, String details) {
        this.AM = AM; this.labID = labID; this.courseID = courseID;
        this.initialPreference = initialPreference;
        this.successful = successful; this.details = details;
    }

    /**
     * @param AM Ο αριθμός μητρώου του φοιτητή.
     * @param IDL Ο κωδικός του τμήματος στο οποίο κληρώθηκε ή απέτυχε να
     * κληρωθεί ο σπουδαστής.
     * @param IDS Ο κωδικός του μαθήματος στο οποίο ανήκει το τμήμα.
     * @param successful Αν η εγγραφή ήταν επιτυχής ή ανεπιτυχής.
     * @param details Επιπρόσθετες λεπτομέριες που αφορούν τη συγκεκριμένη
     * εγγραφή (πχ. λόγος αποτυχίας).
     */
    public Registration(String AM, String labID, String courseID, Integer initialPreference, String successful, String details) {
        this.AM = AM; this.labID = labID; this.courseID = courseID;
        this.initialPreference = initialPreference;
        this.successful = Boolean.parseBoolean(successful); this.details = details;
    }

    /**
     * @return the AM
     */
    public String getAM() {
        return AM;
    }

    /**
     * @return the labID
     */
    public String getLabID() {
        return labID;
    }

    /**
     * @return the courseID
     */
    public String getCourseID() {
        return courseID;
    }

    /**
     * @return the successful
     */
    public Boolean isSuccessful() {
        return successful;
    }
    
    /**
     * @return the successful
     */
    public Boolean getSuccessful() {
        return isSuccessful();
    }

    /**
     * @return the details
     */
    public String getDetails() {
        return details;
    }

    /**
     * @return the initialPreference
     */
    public Integer getInitialPreference() {
        return initialPreference;
    }
}