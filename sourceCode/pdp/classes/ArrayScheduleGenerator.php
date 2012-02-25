<?php

/**
 * Αντλεί πληροφορίες από το ωρολόγιο πρόγραμμα, φιλτραρισμένες κατάλληλα, και
 * τις παραθέτει σε μορφή είτε τρισδιάστατου πίνακα, για εύκολη αποτύπωση σε
 * πίνακες τύπου ωρολογίου προγράμματος, είτε σε μορφή δισδιάστατου πίνακα, για
 * εύκολη ταξινόμηση.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class ArrayScheduleGenerator {

    /**
     * @var String Επιστρέφει μόνο τις εγγραφές στις οποίες είναι γραμμένος
     * ο φοιτητής με τον συγκεκριμένο αριθμό μητρώου.
     */
    private $showOnlyForAM;
    /**
     * @var String Επιστρέφει μόνο τις εγγραφές που ανήκουν στο μάθημα με
     * τον συγκεκριμένο κωδικό.
     */
    private $showOnlyForcourseID;
    /**
     * @var int Επιστρέφει μόνο τις εγγραφές των οποίων τα μαθήματα
     * διδάσκονται στο συγκεκριμένο εξάμηνο.
     */
    private $showOnlyForTypicalTaughtSemester;
    
    /**
     * @var int Η ώρα έναρξης των μαθημάτων κάθε ημέρα.
     */
    private $startHour;
    /**
     * @var int Η ώρα λήξης των μαθημάτων κάθε ημέρα.
     */
    private $endHour;
    
    /**
     * @var array Τα ονόματα των ημερών της εβδομάδας.
     */
    private $days;
    /**
     * @var array Τα εργαστήρια στα οποία δεν έχει κληρωθεί ο φοιτητής και άρα
     * μπορεί να βάλει ορίσει προτιμήσεις.
     */
    private $notAllocatedLabs;
    /**
     * @var array Τα εργαστήρια στα οποία έχει κληρωθεί ο φοιτητής και έχει την
     * επιλογή να αποχωρήσει.
     */
    private $allocatedLabs;
    /**
     * @var array Όλες οι θεωρίες.
     */
    private $theoryHours;

    /**
     * Αρχικοποιεί το αντικείμενο με τα φίλτρα που ορίζονται στις
     * παραμέτρους.
     * @param String $showOnlyForAM Επιστρέφει μόνο τις εγγραφές στις οποίες
     * είναι γραμμένος ο φοιτητής με τον συγκεκριμένο αριθμό μητρώου.
     * @param String $showOnlyForcourseID Επιστρέφει μόνο τις εγγραφές που
     * ανήκουν στο μάθημα με τον συγκεκριμένο κωδικό.
     * @param int $showOnlyForTypicalTaughtSemester Επιστρέφει μόνο τις
     * εγγραφές των οποίων τα μαθήματα διδάσκονται στο συγκεκριμένο εξάμηνο.
     * @param boolean $filterTheoriesBasedOnCourseID Δείχνει αν θα πρέπει να
     * φιλτράρονται και οι θεωρίες με βάση το courseID, όπως τα εργαστήρια.
     */
    public function __construct($showOnlyForAM = null, $showOnlyForcourseID = null, $showOnlyForTypicalTaughtSemester = null, $filterTheoriesBasedOnCourseID = true) {
        $this->showOnlyForAM = $showOnlyForAM;
        $this->showOnlyForcourseID = $showOnlyForcourseID;
        $this->showOnlyForTypicalTaughtSemester = $showOnlyForTypicalTaughtSemester;
        
        $this->startHour = 8; // Ώρα έναρξης μαθημάτων
        $this->endHour = 20; // Ώρα λήξης μαθημάτων

        // Δημιουργία πίνακα και ορισμός των στηλών (ημέρες)
        $this->days = DataHandler::get()->getDays();

        if($filterTheoriesBasedOnCourseID == false) {
            $this->theoryHours = DataHandler::get()->getTheories($this->showOnlyForAM, null, $this->showOnlyForTypicalTaughtSemester);
        } else {
            // Μικρό fix για να φαίνεται και η θεωρία όταν γίνεται φιλτράρισμα με βάση κάποιο εργαστήριο
            if(isset($this->showOnlyForcourseID) && strpos($this->showOnlyForcourseID, 'E') !== false) {
                $theoryID = substr($this->showOnlyForcourseID, 0, strlen($this->showOnlyForcourseID) - 1);
            } else {
                $theoryID = $this->showOnlyForcourseID;
            }
            $this->theoryHours = DataHandler::get()->getTheories($this->showOnlyForAM, $theoryID, $this->showOnlyForTypicalTaughtSemester);
        }

        $allLabs = DataHandler::get()->getLabs($this->showOnlyForAM, $this->showOnlyForcourseID, $this->showOnlyForTypicalTaughtSemester);

        // Αν δεν υπάρχει ΑΜ για τον φοιτητή τότε επιστρέφουμε ένα άδειο Array.
        if ($this->showOnlyForAM != null) {
            $allocations = DataHandler::get()->getAllocatedLabs($this->showOnlyForAM, null, null, $showOnlyForcourseID);
            $allLabsWithoutLessonFilter = DataHandler::get()->getLabs($this->showOnlyForAM, null, $this->showOnlyForTypicalTaughtSemester);
            $this->notAllocatedLabs = array_udiff($allLabs, $allocations, array("ArrayScheduleGenerator", "cmp_courseIDs"));
            //$this->allocatedLabs = array_uintersect($allLabs, $allocations, array("ArrayScheduleGenerator", "cmp_combinedIDs"));
            $this->allocatedLabs = array_uintersect($allLabsWithoutLessonFilter, $allocations, array("ArrayScheduleGenerator", "cmp_combinedIDs"));
        } else {
            $allocations = Array();
            $this->notAllocatedLabs = $allLabs;
        }
    }

    /**
     * Επιστρέφει έναν τρισδιάστατο πίνακα με τις διαστάσεις να αναπαριστούν τις
     * ώρες, τις ημέρες και τις εγγραφές. Οι εγγραφές έχουν τύπο ScheduleEntry
     * και περιέχουν πληροφορίες για τα μαθήματα ή τα τμήματα.
     * @return mixed Τρισδιάστατος πίνακας με ώρες, ημέρες και εγγραφές τύπου
     * ScheduleEntry.
     */
    public function get3dArray() {
        // Δημιουργία γραμμών του πίνακα (ώρες)
        for ($curEnd = $this->startHour + 2; $curEnd <= $this->endHour; $curEnd = $curEnd + 2) {
            $schedule[($curEnd - 2) . '-' . $curEnd] = Array();
            foreach ($this->days as $day) {
                $schedule[($curEnd - 2) . '-' . $curEnd][$day[1]] = Array();
                $k = 0;
                // Θεωρίες
                foreach ($this->theoryHours as $th) {
                    if ($th['DAY'] === $day[0] && $th['tfrom'] == ($curEnd - 2) && $th['tto'] == $curEnd) {
                        $schedule[($curEnd - 2) . '-' . $curEnd][$day[1]][$k] = new ScheduleEntry($th['courseName'], $th['courseType'], $th['courseID'], $th['teacherID'], $th['teacherName']);
                        $k++;
                    }
                }
                // Εμφάνιση όλων των πιθανών μαθημάτων μέσα στο πρόγραμμα για διευκόλυνση του φοιτητή (μόνο αν υπάρχουν μελλοντικές κληρώσεις, αλλιώς δεν έχει νόημα)
                if ($this->showOnlyForAM == null || count(DataHandler::get()->getLotteries('future')) > 0) {
                    foreach ($this->notAllocatedLabs as $l) {
                        if ($l['DAY'] === $day[0] && $l['tfrom'] == ($curEnd - 2) && $l['tto'] == $curEnd) {
                            $schedule[($curEnd - 2) . '-' . $curEnd][$day[1]][$k] = new ScheduleEntryLab($l['courseName'], $l['courseType'], $l['courseID'], $l['labName'], $l['labID'], $l['teacherID'], $l['teacherName'], $l['labOldStudents'], 0, $l['numStudents'], $l['labSize'], $l['firstPriorityCount']);
                            $k++;
                        }
                    }
                }
                // Εμφάνιση των εργαστηρίων στα οποία έχει γίνει ήδη εγγραφή
                if ($this->showOnlyForAM != null) {
                    foreach ($this->allocatedLabs as $l) {
                        if ($l['DAY'] === $day[0] && $l['tfrom'] == ($curEnd - 2) && $l['tto'] == $curEnd) {
                            $schedule[($curEnd - 2) . '-' . $curEnd][$day[1]][$k] = new ScheduleEntryLab($l['courseName'], $l['courseType'], $l['courseID'], $l['labName'], $l['labID'], $l['teacherID'], $l['teacherName'], $l['labOldStudents'], 1, $l['numStudents'], $l['labSize'], $l['firstPriorityCount']);
                            $k++;
                        }
                    }
                }
            }
        }
        return $schedule;
    }
    
    /**
     * Επιστρέφει έναν δισδιάστατο πίνακα με τα εξής χαρακτηριστικά:
     * - Η πρώτη διάσταση είναι απλά αριθμιτικοί δείκτες χωρίς κάποια ιδιαίτερη
     * σημασία.
     * - Η δεύτερη διάσταση περιέχει 3 associative κλειδιά:
     * <ol><li>ScheduleEntry: Περιέχει ένα αντικείμενο τύπου ScheduleEntry</li>
     * με πληροφορίες για το μάθημα/εργαστηριακό τμήμα.
     * <li>day: Το όνομα της ημέρας που διδάσκεται το μάθημα.</li>
     * <li>time: Έχει τη μορφή "Ώρα Έναρξης-Ώρα Λήξης" και αφορά αυτά που λέει.
     * </li></ol>
     * @return mixed Δισδιάστατο πίνακα με ώρες, ημέρες και εγγραφές τύπου
     * ScheduleEntry.
     */
    public function get1dArray() {
        $schedule = Array();
        $k = 0;
        // Θεωρίες
        foreach ($this->theoryHours as $th) {
            $schedule[$k]['ScheduleEntry'] = new ScheduleEntry($th['courseName'], $th['courseType'], $th['courseID'], $th['teacherID'], $th['teacherName']);
            $schedule[$k]['time'] = $th['tfrom'] . '-' . $th['tto'];
            $schedule[$k]['day'] = $this->days[$th['DAY']][1];
            $k++;
        }
        // Εμφάνιση όλων των πιθανών μαθημάτων μέσα στο πρόγραμμα για διευκόλυνση του φοιτητή (μόνο αν υπάρχουν μελλοντικές κληρώσεις, αλλιώς δεν έχει νόημα)
        if ($this->showOnlyForAM == null || count(DataHandler::get()->getLotteries('future')) > 0) {
            foreach ($this->notAllocatedLabs as $l) {
                $schedule[$k]['ScheduleEntry'] = new ScheduleEntryLab($l['courseName'], $l['courseType'], $l['courseID'], $l['labName'], $l['labID'], $l['teacherID'], $l['teacherName'], $l['labOldStudents'], 0, $l['numStudents'], $l['labSize'], $l['firstPriorityCount']);
                $schedule[$k]['time'] = $l['tfrom'] . '-' . $l['tto'];
                $schedule[$k]['day'] = $this->days[$l['DAY']][1];
                $k++;
            }
        }
        // Εμφάνιση των εργαστηρίων στα οποία έχει γίνει ήδη εγγραφή
        if ($this->showOnlyForAM != null) {
            foreach ($this->allocatedLabs as $l) {
                $schedule[$k]['ScheduleEntry'] = new ScheduleEntryLab($l['courseName'], $l['courseType'], $l['courseID'], $l['labName'], $l['labID'], $l['teacherID'], $l['teacherName'], $l['labOldStudents'], 1, $l['numStudents'], $l['labSize'], $l['firstPriorityCount']);
                $schedule[$k]['time'] = $l['tfrom'] . '-' . $l['tto'];
                $schedule[$k]['day'] = $this->days[$l['DAY']][1];
                $k++;
            }
        }
        return $schedule;
    }
    
    /**
     * @see get1dArray()
     * @param String $by Η παράμετρος με την οποία θα γίνει ταξινόμηση. Αν δεν
     * οριστεί τότε γίνεται ταξινόμηση με βάση τα courseID των μαθημάτων.
     * @return mixed Δισδιάστατο ταξινομημένο πίνακα με ώρες, ημέρες και
     * εγγραφές τύπου ScheduleEntry.
     */
    public function get1dArraySorted($by = 'courseID') {
        $schedule = $this->get1dArray();
        usort($schedule, Array('ArrayScheduleGenerator', 'cmp_1dArrayBycourseName'));
        return $schedule;
    }
    
    /**
     * Συγκρίνει ονόματα αντικειμένων τύπου ScheduleEntry τα οποία βρίσκονται
     * μέσα σε έναν δισδιάστατο πίνακα και βρίσκει πιο είναι μεγαλύτερο.
     * Θεωρείται ότι τα αντικείμενα βρίσκονται στις θέσεις με δείκτη
     * "ScheduleEntry". Αν τα courseName είναι ίδια και πρόκειται για
     * εργαστηριακά τμήματα τότε συγκρίνονται τα labName ώστε να ταξινομηθούν
     * αλφαβητικά.
     * @param ScheduleEntry $a
     * @param ScheduleEntry $b
     * @return int Επιστρέφει 0 αν είναι ίσα, +1 αν το a είναι μεγαλύτερο από το
     * b, -1 αν το b είναι μεγαλύτερο από το a.
     */
    public static function cmp_1dArrayBycourseName($a, $b) {
        if(strcmp($a['ScheduleEntry']->getcourseID(), $b['ScheduleEntry']->getcourseID()) != 0 || // Ελέγχω τα courseID αντί για τα courseName για καλύτερη απόδοση
                get_class($a['ScheduleEntry']) !== "ScheduleEntryLab" || get_class($b['ScheduleEntry']) !== "ScheduleEntryLab") {
            // Αν το courseID είναι διαφορετικό ή τουλάχιστον ένα από τα δύο μαθήματα δεν είναι εργαστήριο
            if(strcmp($a['ScheduleEntry']->getcourseName(), $b['ScheduleEntry']->getcourseName()) == 0) {
                return 0;
            }
            return(strcmp($a['ScheduleEntry']->getcourseName(), $b['ScheduleEntry']->getcourseName()) > 0) ? 1 : -1;
        } else {
            // Σύγκριση Εργαστήριο με Εργαστήριο ίδιου μαθηματος
            $combinedIDa = $a['ScheduleEntry']->getLabName();
            $combinedIDb = $b['ScheduleEntry']->getLabName();
            if(strcmp($combinedIDa, $combinedIDb) == 0) {
                return 0;
            }
            return(strcmp($combinedIDa, $combinedIDb) > 0) ? 1 : -1;
        }
    }

    /**
     * Συγκρίνει IDs μαθημάτων που βρίσκονται σε έναν δισδιάστατο πίνακα
     * $lessons[$x]['courseID'] και βρίσκει πιο είναι μεγαλύτερο.
     * @param mixed $a
     * @param mixed $b
     * @return int Επιστρέφει 0 αν είναι ίσα, +1 αν το a είναι μεγαλύτερο από το
     * b, -1 αν το b είναι μεγαλύτερο από το a.
     */
    public static function cmp_courseIDs($a, $b) {
        if(strcmp($a['courseID'], $b['courseID']) == 0)
            return 0;
        return(strcmp($a['courseID'], $b['courseID']) > 0) ? 1 : -1;
    }

    /**
     * Συγκρίνει IDs τμημάτων που βρίσκονται σε έναν δισδιάστατο πίνακα
     * $lessons[$x]['labID'] και βρίσκει πιο είναι μεγαλύτερο.
     * @param mixed $a
     * @param mixed $b
     * @return int Επιστρέφει 0 αν είναι ίσα, +1 αν το a είναι μεγαλύτερο από το
     * b, -1 αν το b είναι μεγαλύτερο από το a.
     */
    public static function cmp_combinedIDs($a, $b) {
        if(strcmp($a['combinedID'], $b['combinedID']) == 0)
            return 0;
        return(strcmp($a['combinedID'], $b['combinedID']) > 0) ? 1 : -1;
    }
}

?>