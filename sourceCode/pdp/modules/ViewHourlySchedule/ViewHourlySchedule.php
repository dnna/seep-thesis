<?php
/**
 * Αντιπροσωπεύει τις επιλογές εξαμήνων στο αριστερό menu.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class SemesterChoice {
    /**
     * @var string Το όνομα του εξαμήνου όπως αυτό θα εμφανιστεί στο menu.
     */
    protected $name;
    /**
     * @var string Το URL στο οποίο θα οδηγεί η επιλογή αυτού του εξαμήμνου.
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
     * Δημιουργεί μια επιλογή εξαμήνου.
     * @param string $name Το όνομα του εξαμήνου όπως αυτό θα εμφανιστεί
     * στο menu.
     * @param string $url Το URL στο οποίο θα οδηγεί η επιλογή αυτού του
     * εξαμήμνου.
     * @param string $colorClass Η κλάση χρώματος (από CSS) που θα έχει αυτή
     * η επιλογή του menu.
     * @param boolean $picked Δείχνει αν αυτή η επιλογή είναι και η τρέχουσα
     * σελίδα.
     */
    function __construct($name, $url, $colorClass = 'choice', $picked = false) {
        $this->name = $name;
        $this->url = $url;
        $this->colorClass = $colorClass;
        $this->picked = $picked;
    }

    /**
     * Το όνομα του εξαμήνου όπως αυτό θα εμφανιστεί στο menu.
     * @return string Το όνομα του εξαμήνου όπως αυτό θα εμφανιστεί στο
     * menu.
     */
    function getName() {
        return $this->name;
    }

    /**
     * Το URL στο οποίο θα οδηγεί η επιλογή αυτού του εξαμήμνου.
     * @return string Το URL στο οποίο θα οδηγεί η επιλογή αυτού του
     * εξαμήμνου.
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
}

/**
 * Εμφανίζει το γενικό ωρολόγιο πρόγραμμα.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class ViewHourlySchedule implements IModule {
    /**
     * Δημιουργεί το αριστερό menu με τις επιλογές εξαμήνων. Επιστρέφει έναν
     * πίνακα με αντικείμενα τύπου SemesterChoice που αντιπροσωπεύουν τις
     * επιλογές του menu.
     * @param int $pickedSemester Το τρέχον εξάμηνο που δείχνει η σελίδα.
     * @return SemesterChoice  Πίνακας με τις επιλογές του menu.
     */
    function getSemesterChoices($pickedSemester = null) {
        $availableSemesters = Array();
        $k = 0;
        $picked = false;
        if ($pickedSemester === 'all')
            $picked = true;
        $availableSemesters[$k++] = new SemesterChoice('Εμφάνιση Όλων των Εξαμήνων', '?module=ViewHourlySchedule&showSemester=all', 'choiceHighlighted', $picked);
        for ($i = 2; $i <= 7; $i++) { // Used to start from $i = 1
            $picked = false;
            if ($pickedSemester == $i) {
                $picked = true;
            }
            $availableSemesters[$k] = new SemesterChoice('Εξάμηνο ' . $i, '?module=ViewHourlySchedule&showSemester=' . $i, 'choice', $picked);
            $k++;
        }
        return $availableSemesters;
    }
    
    /**
     * Εμφανίζει το ωρολόγιο πρόγραμμα (σε μορφή πίνακα) για το συγκεκριμένο
     * εξάμηνο. Η επιστροφή γίνεται με μορφή string που περιέχει τον HTML
     * κώδικα.
     * @param int $num Ο αριθμός του εξαμήνου.
     * @param boolean $pageBreak Αν θα πρέπει να αλλάξει σελίδα μετά από το
     * τέλος κάθε πίνακα.
     * @param pageBreak Αν θα πρέπει να αλλάξει σελίδα μετά από το τέλος κάθε
     * πίνακα.
     * @var semesterNum Ο αριθμός του εξαμήνου.
     * @var days Πίνακας με την αντιστοίχηση των ημερών σε νούμερα.
     * @var schedule Τρισδιάστατος πίνακας με πληροφορίες για τα μαθήματα
     * του εξάμηνου.
     * @return string Επιστρέφει τον HTML κώδικα για τον πίνακα του
     * ωρολογίου προγράμματος.
     */
    function displaySemester($num = 1, $pageBreak = false) {
        $arrayGenerator = new ArrayScheduleGenerator(null, null, $num);
        TemplateEngine::get()->handle()->assign('pageBreak', $pageBreak);
        TemplateEngine::get()->handle()->assign('semesterNum', $num);
        TemplateEngine::get()->handle()->assign('days', DataHandler::get()->getDays());
        TemplateEngine::get()->handle()->assign('schedule', $arrayGenerator->get3dArray());
        return TemplateEngine::get()->handle()->fetch('templates/modules/ViewHourlySchedule/ScheduleTable.tpl');
    }
    
    /**
     * Εμφανίζει όλα τα εξάμηνα σε ξεχωριστούς πίνακες το κάθε ένα.
     * @return string Επιστρέφει τον HTML κώδικα για τον πίνακα του ωρολογίου
     * προγράμματος που περιλαμβάνει όλα τα εξάμηνα.
     */
    function displayAllSemesters() {
        $k = 1; // Used to be 0 instead of 1
        $schedules[$k++] = $this->displaySemester(2, false); // Used to be 1 instead of 2
        for ($i = 3; $i <= 7; $i++) { // Used to be 2 instead of 3
            $schedules[$k++] = $this->displaySemester($i, true);
        }
        return $schedules;
    }
    
    /**
     * Η κύρια συνάρτηση που θα τρέξει όταν το module φορτωθεί.
     * @var schedules Πίνακας που περιέχει τρισδιάστατους πίνακες με
     * πληροφορίες για τα μαθήματα κάθε εξαμήνου.
     * @var semesterChoices Πίνακας με τις επιλογές εξαμήνουν που υπάρχουν
     * στο αριστερό menu.
     * @global mixed $_GET Η καθολική μεταβλητή $_GET.
     */
    function run() {
        global $_GET;
        if (isset($_GET['showSemester'])) { // If the user has picked a specific semester to show
            if($_GET['showSemester'] !== 'all' && ($_GET['showSemester'] < 2 || $_GET['showSemester'] > 8)) { // $_GET['showSemester'] < 2 used to be 1
                header('Location: ?module=ViewHourlySchedule&showSemester=2'); // Used to be 1
                die();
            }
            if ($_GET['showSemester'] === 'all') { // Special case if the user has chosen to view all semesters
                $schedules = $this->displayAllSemesters();
            } else {
                $schedules[0] = $this->displaySemester($_GET['showSemester']);
            }
        } else { // If the user hasn't picked a specific semester to show then find a suitable default
            if (User::getUser()->getID() !== '-1') {
                header('Location: ?module=ViewHourlySchedule&showSemester=' . User::getUser()->getTypicalSemester());
            } else {
                header('Location: ?module=ViewHourlySchedule&showSemester=2'); // Used to be 1
            }
            die();
        }
        TemplateEngine::get()->handle()->assign('schedules', $schedules);
        TemplateEngine::get()->handle()->assign('semesterChoices', $this->getSemesterChoices($_GET['showSemester']));
        TemplateEngine::get()->handle()->display('templates/modules/ViewHourlySchedule/ViewHourlySchedule.tpl');
    }

}

?>