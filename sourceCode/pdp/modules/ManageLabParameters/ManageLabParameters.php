<?php

/**
 * Αντιπροσωπεύει τις επιλογές μαθημάτων στο αριστερό menu.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class LessonChoice {

    /**
     * @var string Ο κωδικός του μαθήματος.
     */
    protected $courseID;
    /**
     * @var string Το όνομα του μαθήματος. 
     */
    protected $name;
    /**
     * @var string Το URL στο οποίο οδηγεί στο συγκεκριμένο link.
     */
    protected $url;
    /**
     * @var string Η κλάση χρώματος (από CSS) που θα έχει αυτό το menu.
     */
    protected $colorClass;
    /**
     * @var boolean Δείχνει αν αυτή η επιλογή είναι και η τρέχουσα σελίδα.
     */
    protected $picked;

    /**
     * Δημιουργεί μια επιλογή μαθήματος
     * @param string $courseID Ο κωδικός του μαθήματος.
     * @param string $name Το όνομα του μαθήματος όπως αυτό θα εμφανιστεί
     * στο menu.
     * @param string $url Το URL στο οποίο θα οδηγεί η επιλογή αυτού του
     * εξαμήμνου.
     * @param string $colorClass Η κλάση χρώματος (από CSS) που θα έχει αυτό
     * το menu.
     * @param boolean $picked Δείχνει αν αυτή η επιλογή είναι και η τρέχουσα
     * σελίδα.
     */
    function __construct($courseID, $name, $url, $colorClass = 'choice', $picked = false) {
        $this->courseID = $courseID;
        $this->name = $name;
        $this->url = $url;
        $this->colorClass = $colorClass;
        $this->picked = $picked;
    }

    /**
     * Το όνομα του μαθήματος όπως αυτό θα εμφανιστεί στο menu.
     * @return string Το όνομα του μαθήματος όπως αυτό θα εμφανιστεί στο
     * menu.
     */
    function getName() {
        return $this->name;
    }

    /**
     * Το URL στο οποίο θα οδηγεί η επιλογή αυτού του μαθήματος.
     * @return string Το URL στο οποίο θα οδηγεί η επιλογή αυτού του
     * μαθήματος.
     */
    function getURL() {
        return $this->url;
    }

    /**
     * Η κλάση χρώματος (από CSS) που θα έχει αυτή η επιλογή του menu.
     * @return string Η κλάση χρώματος (από CSS) που θα έχει αυτή η επιλογή
     * του menu.
     */
    function getColorClass() {
        return $this->colorClass;
    }

    /**
     * Δείχνει αν αυτή η επιλογή είναι και η τρέχουσα σελίδα.
     * @return boolean Δείχνει αν αυτή η επιλογή είναι και η τρέχουσα
     * σελίδα.
     */
    function isPicked() {
        return $this->picked;
    }

    /**
     * Επιστρέφει τον κωδικό του μαθήματος αυτής της επιλογής.
     * @return string Επιστρέφει τον κωδικό του μαθήματος αυτής της επιλογής.
     */
    function getcourseID() {
        return $this->courseID;
    }

}

/**
 * Δίνει τη δυνατότητα σε ένα φοιτητή να κάνει δήλωση προτιμήσεων, δηλαδή να
 * ορίσει προτεραιότητες για τα διάφορα εργαστηριακά τμήματα.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class ManageLabParameters implements IModule {

    /**
     * Δημιουργεί το αριστερό menu με τις επιλογές μαθημάτων. Επιστρέφει
     * έναν πίνακα με αντικείμενα τύπου LessonChoice που αντιπροσωπεύουν
     * τις επιλογές του menu.
     * @param int $pickedLesson Το τρέχον μάθημα που δείχνει η σελίδα.
     * @return LessonChoice  Πίνακας με τις επιλογές του menu.
     */
    function getLessonChoices($pickedLesson = null) {
        $availableLessons = Array();
        $k = 0;
        $picked = false;
        if ($pickedLesson == null)
            $picked = true;
        //$availableLessons[$k++] = new LessonChoice(null, 'Εμφάνιση Όλων των Μαθημάτων', '?module='.$_GET['module'], 'choiceHighlighted', $picked);
        $lessonsArray = DataHandler::get()->getTeacherResponsibleCourses(User::getUser()->getID());
        foreach ($lessonsArray as $curLesson) {
            $lessonInfo = DataHandler::get()->getLessonsWithInfo(null, $curLesson, null);
            $lessonInfo = $lessonInfo[0];
            if ($lessonInfo['numLabs'] > 0) {
                $picked = false;
                if ($pickedLesson == $lessonInfo['courseID']) {
                    $picked = true;
                }
                $availableLessons[$k] = new LessonChoice($lessonInfo['courseID'], $lessonInfo['courseName'], '?module=' . $_GET['module'] . '&showLesson=' . $lessonInfo['courseID'], 'choice', $picked);
                $k++;
            }
        }
        return $availableLessons;
    }

    /**
     * Εμφανίζει το ωρολόγιο πρόγραμμα (σε μορφή πίνακα) για το συγκεκριμένο
     * εξάμηνο. Η επιστροφή γίνεται με μορφή string που περιέχει τον HTML
     * κώδικα.
     * @param string $courseID Ο κωδικός του μαθήματος.
     * @param boolean $pageBreak Αν θα πρέπει να αλλάξει σελίδα μετά από το
     * τέλος κάθε πίνακα.
     * @param string $format Ο τρόπος εμφάνισης του μαθήματος (σε πίνακα
     * ωρολογίου προγράμματος ή λίστα τμημάτων - LabList).
     * @var pageBreak Αν θα πρέπει να αλλάξει σελίδα μετά από το τέλος κάθε
     * πίνακα.
     * @var currentPreferences Οι τρέχουσες προτιμήσεις του φοιτητή.
     * @var days Πίνακας με την αντιστοίχηση των ημερών σε νούμερα.
     * @var schedule Πίνακας με πληροφορίες για τα τμήματα. Η μορφή του
     * διαφέρει ανάλογα με τον τρόπο εμφάνισης.
     * @return string Επιστρέφει τον HTML κώδικα για τον πίνακα του
     * ωρολογίου ή τη λίστα των εργαστηριακών τμημάτων.
     */
    function displayLesson($courseID = null, $pageBreak = false, $format = null) {
        $responsibleCourses = DataHandler::get()->getTeacherResponsibleCourses(User::getUser()->getID());
        if (count($responsibleCourses) <= 0) { // Έλεγχος ότι υπάρχει πρόσβαση στο συγκεκριμένο μάθημα.
            throw new Exception('Ο καθηγητής δεν έχει πρόσβαση να ορίσει παραμέτρους για το συγκεκριμένο μάθημα.', 50001);
        }
        if ($courseID == null) {
            header("Location: " . $_SERVER['REQUEST_URI'] . "&showLesson=" . $responsibleCourses[0]. "&format=LabList");
        }
        if (!is_array($courseID)) { // Έλεγχος ότι υπάρχει πρόσβαση στο συγκεκριμένο μάθημα.
            if (!in_array($courseID, $responsibleCourses)) {
                throw new Exception('Ο καθηγητής δεν έχει πρόσβαση να ορίσει παραμέτρους για το συγκεκριμένο μάθημα.', 50001);
            }
        }
        $arrayGenerator = new ArrayScheduleGenerator(null, $courseID, null, true);
        $theoryArrayGenerator = new ArrayScheduleGenerator(null, substr($courseID, 0, strlen($courseID) - 1), null, true);
        TemplateEngine::get()->handle()->assign('pageBreak', $pageBreak);
        //TemplateEngine::get()->handle()->assign('courseID', $courseID);
        TemplateEngine::get()->handle()->assign('days', DataHandler::get()->getDays());
        TemplateEngine::get()->handle()->assign('currentPreferences', DataHandler::get()->getCurrentPreferences(User::getUser()->getID()));
        if ($format != null && $format === 'LabList') {
            TemplateEngine::get()->handle()->assign('schedule', $arrayGenerator->get1dArraySorted(), $theoryArrayGenerator->get1dArraySorted());
            $displayFormat = 'LabList.tpl';
        } else {
            TemplateEngine::get()->handle()->assign('schedule', $arrayGenerator->get3dArray());
            $displayFormat = 'ScheduleTable.tpl';
        }
        TemplateEngine::get()->handle()->assign('teachers', DataHandler::get()->getTeacherDetails());
        return TemplateEngine::get()->handle()->fetch('templates/modules/' . $_GET['module'] . '/' . $displayFormat);
    }

    /**
     * Η βασική σελίδα στην οποία δηλώνει προτιμήσεις ο φοιτητής.
     * @var format Ο τρόπος εμφάνισης του μαθήματος (σε πίνακα ωρολογίου
     * προγράμματος ή λίστα τμημάτων - LabList).
     * @var schedules Πίνακας που περιέχει πίνακες με πληροφορίες για τα
     * μαθήματα κάθε εξαμήνου. Η μορφή τους εξαρτάται από τον τρόπο
     * εμφάνισης.
     * @var lessonChoices Πίνακας με τις επιλογές εξαμήνουν που υπάρχουν στο
     * αριστερό menu.
     * @var availableLessons Πίνακας με τα μαθήματα στα οποία μπορεί να
     * δηλώσει τμήματα ο φοιτητής.
     * @var head Scripts που θα μπουν στην περιοχή <head></head> της
     * σελίδας.
     * @global mixed $_GET Η καθολική μεταβλητή $_GET.
     */
    function changeParameters() {
        global $_GET;
        if(!isset($_GET['format'])) {
            $_GET['format'] = null;
        }
        if (isset($_GET['showLesson'])) { // If the user has picked a specific lesson to show
            $schedules[0] = $this->displayLesson($_GET['showLesson'], false, $_GET['format']);
        } else { // If the user hasn't picked a specific lesson to show then find a suitable default
            if (User::getUser()->getID() !== '-1') {
                $schedules[0] = $this->displayLesson(null, false, $_GET['format']);
            }
        }
        TemplateEngine::get()->handle()->assign('format', $_GET['format']);
        TemplateEngine::get()->handle()->assign('schedules', $schedules);
        TemplateEngine::get()->handle()->assign('lessonChoices', $this->getLessonChoices($_GET['showLesson']));
        TemplateEngine::get()->handle()->assign('courseID', $_GET['showLesson']);
        TemplateEngine::get()->handle()->assign('head', TemplateEngine::get()->handle()->fetch('templates/modules/'.$_GET['module'].'/Head.tpl'));
        TemplateEngine::get()->handle()->display('templates/modules/' . $_GET['module'] . '/' . $_GET['module'] . '.tpl');
    }

    /**
     * Επεξεργάζεται μια δήλωση. Αυτό γίνεται περνώντας την από ελεγχόυς
     * που γίνονται στο αντικείμενο StatementProcessor.
     * @var referer Η σελίδα από την οποία ήρθε ο χρήστης.
     * @global mixed $_POST Η καθολική μεταβλητή $_POST.
     */
    function processChanges() {
        global $_POST;
        include('StatementProcessor.php');
        $processor = new StatementProcessor($_POST);
        $processor->process();
        TemplateEngine::get()->handle()->assign('referer', PageComposer::getReferer());
        TemplateEngine::get()->handle()->display('templates/modules/' . $_GET['module'] . '/SubmissionSuccess.tpl');
    }

    /**
     * Εμφανίζει τους παλαιούς φοιτητές που έχουν γραφτεί σε ένα μάθημα.
     * @param String $courseID Ο κωδικός του μαθήματος
     */
    function displayOldStudents($courseID = null) {
        if($courseID == null) { throw new Exception('Δεν είναι δυνατή η εμφάνιση των εγγεγραμμένων φοιτητών για το συγκεκριμένο τμήμα.', 50004); }
        TemplateEngine::get()->handle()->assign('students', DataHandler::get()->getRegisteredStudents($courseID."_OLDSTUDENT"));
        TemplateEngine::get()->handle()->display('templates/modules/' . $_GET['module'] . '/DisplayRegisteredStudents.tpl');
    }

    /**
     * Εμφανίζει τους εγγεγραμένους φοιτητές για ένα εργαστηριακό τμήμα.
     * @param String $labID Ο κωδικός του εργαστηριακού τμήματος.
     */
    function displayRegisteredStudents($labID = null) {
        if($labID == null) { throw new Exception('Δεν είναι δυνατή η εμφάνιση των εγγεγραμμένων φοιτητών για το συγκεκριμένο τμήμα.', 50004); }
        TemplateEngine::get()->handle()->assign('students', DataHandler::get()->getRegisteredStudents($labID));
        TemplateEngine::get()->handle()->display('templates/modules/' . $_GET['module'] . '/DisplayRegisteredStudents.tpl');
    }

    /**
     * Η κύρια συνάρτηση που θα τρέξει όταν το module φορτωθεί.
     * @global mixed $_GET Η καθολική μεταβλητή $_GET.
     * @global mixed $_POST Η καθολική μεταβλητή $_POST.
     */
    function run() {
        global $_GET, $_POST;
        if (isset($_GET['ProcessStatement']) && isset($_POST['submitted'])) {
            $this->processChanges();
        } else if(isset($_GET['displayRegisteredStudents'])) {
            $this->displayRegisteredStudents($_GET['displayRegisteredStudents']);
        } else if(isset($_GET['displayOldStudents'])) {
            $this->displayOldStudents($_GET['displayOldStudents']);
        } else {
            $this->changeParameters();
        }
    }
}

?>