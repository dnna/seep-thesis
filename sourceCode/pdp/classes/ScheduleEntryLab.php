<?php
/**
 * Δομή που περιέχει πληροφορίες ένα εργαστήριο. Χρησιμοποιείται στην παραγωγή
 * πινάκων και λιστών που έχουν να κάνουν με το ωρολόγιο πρόγραμμα και καθορίζει
 * παραμέτρους όπως τον τρέχων και μέγιστο αριθμό φοιτητών του εργαστηρίου.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class ScheduleEntryLab extends ScheduleEntry {
    /**
     * @var String Το όνομα του εργαστηριακού τμήματος
     */
    protected $labName;
    /**
     * @var String Ο μοναδικός κωδικός του τμήματος (αν η εγγραφή αφορά
     * εργαστήριο)
     */
    protected $labID;
    /**
     * @var int Δείχνει τον αριθμό των φοιτητών που έχουν κληρωθεί ή γραφτεί
     * στο εργαστήριο
     */
    protected $numStudents;
    /**
     * @var int Δείχνει τον μέγιστο αριθμό φοιτητών που δέχεται αυτό το
     * εργαστήριο
     */
    protected $maxStudents;
    /**
     * @var bool Δείχνει αν ο φοιτητής έχει κληρωθεί σε αυτό το εργαστήριο
     */
    protected $allocatedToThis;
    /**
     * @var int Ο αριθμός φοιτητών που έχει δηλώσει το εργαστήριο σαν πρώτη
     * προτεραιότητα.
     */
    protected $firstPriorityCount;
    /**
     * @var boolean Δείχνει αν πρόκειται για τμήμα παλαιών φοιτητών.
     */
    protected $oldStudents;

    /**
     * Αρχικοποιεί την δομή με τις σχετικές παραμέτρους.
     * @param String $courseName Το όνομα του μαθήματος
     * @param String $courseType  Ο τύπος του μαθήματος
     * (Θεωρία, Εργαστήριο ή Φροντιστήριο)
     * @param String $courseID Ο μοναδικός κωδικός του μαθήματος
     * @param String $labName Το όνομα του εργαστηριακού τμήματος
     * @param String $labID Ο μοναδικός κωδικός του τμήματος (αν η εγγραφή
     * αφορά εργαστήριο)
     * @param int $allocatedToThis Δείχνει αν ο φοιτητής έχει κληρωθεί σε
     * αυτό το τμήμα. Τιμές: 0 Όχι, 1 Έχει κληρωθεί (στην εσωτερική βάση),
     * 2 Έχει γραφτεί (στην μόνιμη βάση).
     * @param int $numStudents Ο τρέχων αριθμός φοιτητών που έχουν κληρωθεί ή
     * γραφτεί σε αυτό το τμήμα.
     * @param int $maxStudents μέγιστο αριθμό φοιτητών που επιτρέπεται σε αυτό
     * το τμήμα.
     */
    public function __construct($courseName, $courseType, $courseID, $labName, $labID, $teacherID, $teacherName, $oldStudents, $allocatedToThis = 0, $numStudents = 0, $maxStudents = 0, $firstPriorityCount = 0) {
        parent::__construct($courseName, $courseType, $courseID, $teacherID, $teacherName);
        if($labName == "") { // Αν το όνομα είναι κενό τότε βάζουμε το όνομα του μαθήματος και στο τμήμα
            $this->labName = $this->courseName;
        } else {
            $this->labName = $labName;
        }
        $this->labID = $labID;
        $this->oldStudents = $oldStudents;
        $this->allocatedToThis = $allocatedToThis;
        $this->numStudents = $numStudents;
        $this->maxStudents = $maxStudents;
        $this->firstPriorityCount = $firstPriorityCount;
    }
    
    /**
     * Επιστρέφει το όνομα του εργαστηριακού τμήματος.
     * @return String Το όνομα του εργαστηριακού τμήματος.
     */
    public function getLabName() {
        return $this->labName;
    }
    
    /**
     * Επιστρέφει τον μοναδικό κωδικό του εργαστηριακού τμήματος. Αν
     * η εγγραφή δεν αφορά εργαστήριο τότε επιστρέφει null.
     * @return String Ο μοναδικός κωδικός του τμήματος η null αν δεν αφορά
     * εργαστήριο.
     */
    public function getlabID() {
        return $this->labID;
    }
    
    /**
     * Ελέγχει αν ο τρέχων χρήστης (που πρέπει να είναι φοιτητής) έχει κληρωθεί
     * στο συγκεκριμένο εργαστηριακό τμήμα. Αν ο φοιτητής δεν έχει κληρωθεί σε
     * αυτό το τμήμα ή αν η εγγραφή δεν αφορά εργαστήριο επιστρέφει false.
     * @return bool Επιστρέφει true αν ο φοιτητής έχει κληρωθεί σε αυτό το
     * τμήμα ή false αν όχι.
     */
    public function isallocatedToThis() {
        return $this->allocatedToThis;
    }
    
    /**
     * Επιστρέφει τον τρέχων αριθμό φοιτητών που έχουν κληρωθεί ή γραφτεί σε
     * αυτό το τμήμα.
     * @return int Ο τρέχων αριθμός φοιτητών που έχουν κληρωθεί ή γραφτεί.
     */
    public function getNumStudents() {
        return $this->numStudents;
    }
    
    /**
     * Συνώνυμο του getNumStudents().
     * @see getNumStudents()
     */
    public function getCurStudents() {
        return $this->getNumStudents();
    }
    
    /**
     * Επιστρέφει τον μέγιστο αριθμό φοιτητών που επιτρέπεται σε αυτό το τμήμα.
     * @return int Ο μέγιστος αριθμός φοιτητών που επιτρέπεται σε αυτό το τμήμα.
     */
    public function getMaxStudents() {
        return $this->maxStudents;
    }

    /**
     * Επιστρέφει τον αριθμό φοιτητών που έχουν δηλώσει το εργαστήριο σαν πρώτη
     * προτεραιότητα.
     * @return int Ο αριθμός φοιτητών που έχουν δηλώσει το εργαστήριο σαν πρώτη
     * προτεραιότητα.
     */
    public function getFirstPriorityCount() {
        return $this->firstPriorityCount;
    }
    
    /**
     * Επιστρέφει αν το τμήμα είναι για παλαιούς φοιτητές.
     * @return String Επιστρέφει 1 αν το τμήμα είναι για παλαιούς φοιτητές ή 0
     * αν δεν είναι.
     */
    public function isForOldStudents() {
        return $this->oldStudents;
    }
}
?>
