<?php

/**
 * Δομή που περιέχει πληροφορίες ένα μάθημα. Χρησιμοποιείται στην παραγωγή
 * πινάκων και λιστών που έχουν να κάνουν με το ωρολόγιο πρόγραμμα και καθορίζει
 * παραμέτρους όπως το χρώμα του μαθήματος.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class ScheduleEntry {
    /**
     * @var String Το όνομα του μαθήματος
     */
    protected $courseName;
    /**
     * @var String Ο τύπος του μαθήματος (Θεωρία, Εργαστήριο ή Φροντιστήριο)
     */
    protected $courseType;
    /**
     * @var String Ο μοναδικός κωδικός του μαθήματος
     */
    protected $courseID;
    /**
     * @var String Ο μοναδικός κωδικός του καθηγητή που διδάσκει σε αυτό το
     * τμήμα.
     */
    protected $teacherID;
    /**
     * @var String Το όνομα του καθηγητή που διδάκσει σε αυτό το τμήμα.
     */
    protected $teacherName;
    /**
     * @var String Το χρώμα του μαθήματος σε RGB δεκαεξαδική εξαψήφια μορφή
     */
    protected $color;

    /**
     * Αρχικοποιεί την δομή με τις σχετικές παραμέτρους.
     * @param String $courseName Το όνομα του μαθήματος
     * @param String $courseType  Ο τύπος του μαθήματος
     * (Θεωρία, Εργαστήριο ή Φροντιστήριο)
     * @param String $courseID Ο μοναδικός κωδικός του μαθήματος
     */
    public function __construct($courseName, $courseType, $courseID, $teacherID, $teacherName) {
        $this->name = $courseName;
        $this->courseType = $courseType;
        $this->courseID = $courseID;
        $this->teacherID = $teacherID;
        $this->teacherName = $teacherName;
    }

    /**
     * Επιστρέφει το όνομα του μαθήματος. Αν πρόκειται για εργαστηριακό
     * τμήμα τότε επιστρέφει το όνομα του τμήματος και όχι του μαθήματος.
     * @return String Το όνομα του μαθήματος ή του τμήματος. 
     */
    public function getCourseName() {
        return $this->name;
    }

    /**
     * Επιστρέφει τον τύπο του μαθήματος.
     * @return String Ο τύπος του μαθήματος.
     */
    public function getcourseType() {
        return $this->courseType;
    }

    /**
     * Επιστρέφει τον μοναδικό κωδικό του μαθήματος.
     * @return String Ο μοναδικός κωδικός του μαθήματος.
     */
    public function getcourseID() {
        return $this->courseID;
    }
    
    /**
     * Επιστρέφει τον μοναδικό κωδικό του καθηγητή που διδάσκει σε αυτό το
     * εργαστηριακό τμήμα.
     * @return String Ο μοναδικός κωδικός του καθηγητή που διδάσκει σε αυτό το
     * τμήμα. 
     */
    public function getTeacherID() {
        return $this->teacherID;
    }
    
    /**
     * Επιστρέφει το όνομα του καθηγητή που διδάσκει σε αυτό το εργαστηριακό
     * τμήμα.
     * @return String Το όνομα του καθηγητή που διδάσκει σε αυτό το εργαστηριακό
     * τμήμα.
     */
    public function getTeacherName() {
        return $this->teacherName;
    }

    /**
     * Επιστρέφει το χρώμα του εργαστηρίου σε RBG δεκαεξαδική εξαψήφια μορφή
     * (πχ. #FFFFFF). Το χρώμα εξαρτάται αποκλειστικά από τον κωδικό του
     * μαθήματος, δηλαδή όλα τα εργαστηριακά τμήματα για ένα μάθημα θα έχουν το
     * ίδιο χρώμα.
     * @return String Το χρώμα του μαθήματος σε RBG δεκαεξαδική μορφή.
     */
    public function getColor() {
        if (isset($this->color)) {
            return $this->color;
        }
        include_once('libs/ColorCalculator/ColorCalculator.php');
        $hash = md5($this->getcourseID());
        //base_convert($hash, 10, 16);
        $hash = ColorCalculator::figureColor($hash, '#FFFFFF', 1);
        return $hash;
    }

}
?>