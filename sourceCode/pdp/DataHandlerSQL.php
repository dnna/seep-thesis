<?php

/**
 * Ασχολείται με λειτουργίες ανάκτησης/αποθήκευσης δεδομένων σε χαμηλό επίπεδο.
 * Είναι singleton, δηλαδή μπορεί να υπάρχει μόνο ένα αντικείμενο αυτής της
 * κλάσης σε μια δεδομένη στιγμή, και μπορεί να ανακτηθεί με τη στατικη μέθοδο
 * get.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class DataHandlerSQL extends DataHandler {

    /**
     * @var mixed Οι πληροφορίες σύνδεσης με τη βάση δεδομένων.
     */
    protected $dbinfo;
    /**
     * @var mysqli Handle σύνδεσης με μια βάση δεδομένων.
     */
    protected $db;
    /**
     * @var int Το ID του τρέχοντος εξαμήνου.
     */
    protected $curSemester;
    /**
     * @var int Το ID της πιο πρόσφατης κλήρωσης.
     */
    protected $latestLotID;
    /**
     * @var string Το όνομα της εσωτερικής βάσης δεδομένων.
     */
    protected $internalDbName;

    /**
     * Αρχικοποιεί υπολογίζοντας το τρέχων εξάμηνο, δημιουργώντας σύνδεση με
     * την αποθήκη δεδομένων, αν αυτό χρειάζεται κ.τ.λ. Αν υπάρξει τεχνικό
     * πρόβλημα ρίχνει DataHandlerException με κωδικό 10001.
     * Είναι protected για να μην μπορεί να αρχικοποιηθεί εκτός κλάσης.
     */
    protected function __construct() {
        // Σύνδεση με τη βάση
        $dbinfo['egrafesDbHost'] = "localhost";
        $dbinfo['egrafesDbName'] = "seep_env";
        $dbinfo['egrafesDbUser'] = "seep";
        $dbinfo['egrafesDbPass'] = "zyx";
        $this->db = new mysqli($dbinfo['egrafesDbHost'], $dbinfo['egrafesDbUser'], $dbinfo['egrafesDbPass'], $dbinfo['egrafesDbName']);
        $this->internalDbName = "seep_internal";
        if (!$this->db->connect_errno) {
            $this->db->query("SET NAMES utf8;");
        } else {
            throw new DataHandlerException("Δεν ήταν δυνατή η σύνδεση με το κεντρικό data-source.<BR><BR>Το σφάλμα που επιστράφηκε ήταν:<BR>" . $this->db->connect_error, 10001);
        }
        // Εύρεση τρέχονοτος εξαμήνου
        $this->curSemester = $this->getCurrentSemester();
    }

    /**
     * Επιστρέφει το handle της βάσης δεδομένων.
     * @return mysqli Το handle της βάσης δεδομένων.
     */
    public function handle() {
        return $this->db;
    }

    /**
     * Επιχειρεί να αυθεντικοποιήσει τον χρήστη με το username και password που
     * δίνονται. Αν πετύχει τότε επιστρέφει έναν associative πίνακα με τα
     * διάφορα στοιχεία του χρήστη. Αν δεν πετύχει τότε επιστρέφει false. Σε
     * περίπτωση που υπάρξει τεχνικό πρόβλημα ρίχνει DataHandlerException με
     * κωδικό 10003.
     * @param String $username
     * @param String $password
     * @return mixed Επιστρέφει ένα associative array με πληροφορίες για τον
     * χρήστη αν αυθεντικοποιηθεί, ή boolean false αν αποτύχει.
     */
    public function authenticateUser($username, $password) {
        //$query = preg_replace("/\{userName\}/", $this->db->escape_string($username), $config['egrafesUserPasswordQuery']);
        $userData['userRoles'] = Array();
        // Κοιτάμε τη βάση των διαχειριστών
        $adminResult = $this->db->query("SELECT adminID as ID, adminUsername as username, adminGivenName as GName FROM admin WHERE adminUsername = '" . $this->db->escape_string($username) . "'");
        if ($adminResult) {
            if ($adminResult->num_rows > 0) {
                $data = $adminResult->fetch_assoc();
                //if($data['password'] === passwordEncrypt($password, $config['egrafesEncryptPassword'])) {
                array_push($userData['userRoles'], 'admin'); // Ρόλοι
                $userData['userName'] = $data['username'];
                $userData['userID'] = $data['ID'];
                $data['GName'] = explode(' ', $data['GName']);
                $userData['userLastName'] = $data['GName'][0];
                $userData['userFirstName'] = $data['GName'][1];
                //}
            }
        } else {
            throw new DataHandlerException('Σφάλμα κατά την εκτέλεση ερωτήματος στο data-source αυθεντικοποίησης.<BR><BR>Το σφάλμα που επιστράφηκε ήταν:<BR>' . $this->db->error, 10003);
        }
        // Κοιτάμε τη βάση των καθηγητών
        $teacherResult = $this->db->query("SELECT teacherID as ID, teacherUsername as username, teacherGivenName as GName FROM teacher WHERE teacherUsername = '" . $this->db->escape_string($username) . "'");
        if ($teacherResult) {
            if ($teacherResult->num_rows > 0) {
                $data = $teacherResult->fetch_assoc();
                //if($data['password'] === passwordEncrypt($password, $config['egrafesEncryptPassword'])) {
                array_push($userData['userRoles'], 'teacher'); // Ρόλοι
                $userData['userName'] = $data['username'];
                $userData['userID'] = $data['ID'];
                $data['GName'] = explode(' ', $data['GName']);
                $userData['userLastName'] = $data['GName'][0];
                $userData['userFirstName'] = $data['GName'][1];
                //}
            }
        } else {
            throw new DataHandlerException('Σφάλμα κατά την εκτέλεση ερωτήματος στο data-source αυθεντικοποίησης.<BR><BR>Το σφάλμα που επιστράφηκε ήταν:<BR>' . $this->db->error, 10003);
        }
        // Κοιτάμε τη βάση των φοιτητών
        $studentResult = $this->db->query("SELECT studAM as ID, studUsername as username, studGivenName as GName FROM studentBasic WHERE studUsername = '" . $this->db->escape_string($username) . "'");
        if ($studentResult) {
            if ($studentResult->num_rows > 0) {
                $data = $studentResult->fetch_assoc();
                //if($data['password'] === passwordEncrypt($password, $config['egrafesEncryptPassword'])) {
                array_push($userData['userRoles'], 'student'); // Ρόλοι
                $userData['userName'] = $data['username'];
                $userData['userID'] = $data['ID'];
                $data['GName'] = explode(' ', $data['GName']);
                $userData['userLastName'] = $data['GName'][0];
                $userData['userFirstName'] = $data['GName'][1];
                //}
            }
            $studentResult->close();
        } else {
            throw new DataHandlerException('Σφάλμα κατά την εκτέλεση ερωτήματος στο data-source αυθεντικοποίησης.<BR><BR>Το σφάλμα που επιστράφηκε ήταν:<BR>' . $this->db->error, 10003);
        }
        if (count($userData['userRoles']) > 0) {
            return $userData;
        } else {
            return false;
        }
    }

    /**
     * Επιστρέφει τα ID και τα ονόματα των ημερών της εβδομάδας.
     * @return mixed Numeric array με τα ID και τα ονόματα των ημερών της
     * εβδομάδας.
     */
    public function getDays() {
        if (!isset($this->days)) {
            $days = $this->db->query("SELECT dayID, dayName FROM days");
            $daysArray = Array();
            while ($day = $days->fetch_row()) {
                $daysArray[$day[0]] = $day;
            }
            $this->days = $daysArray;
        } else {
            $daysArray = $this->days;
        }
        return $daysArray;
    }

    /**
     * Υπολογίζει το τυπικό εξάμηνο του φοιτητή με τον δοθέντα αριθμό μητρώου.
     * @param String $AM Ο αριθμός μητρώου του φοιτητή.
     * @return int Το τυπικό εξάμηνο του φοιτητή.
     */
    public function getTypicalSemester($AM) {
        $semesterResult = $this->db->query("SELECT (" . $this->curSemester . " - registrationSemesterID + 1) as typicalSemester FROM studentBasic WHERE studAM = " . $AM);
        if ($semesterResult->num_rows > 0) {
            $semester = $semesterResult->fetch_row();
        } else {
            $semester[0] = 1;
        }
        return $semester[0];
    }

    /**
     * Επιστρέφει ένα δισδιάστατο πίνακα με εργαστηριακά τμήματα και πληροφορίες
     * για αυτά, φιλτραρισμένα με βάση διάφορες παραμέτρους, οι οποίες μπορούν
     * να συνδυαστούν. Οι πληροφορίες που περιέχονται αφορούν τη θέση στο
     * ωρολόγιο πρόγραμμα, τον τύπο, το εξάμηνο στο οποίο διδάσκονται κ.τ.λ.
     * και είναι οι εξής:
     * <ol><li>NAME -> Όνομα του εργαστηριακού τμήματος.</li>
     * <li>DAY -> Το ID της ημέρας στην οποία διδάσκεται.</li>
     * <li>dayName -> Το όνομα της ημέρας στην οποία διδάσκεται.</li>
     * <li>tfrom -> Η ώρα έναρξης του εργαστηρίου.</li>
     * <li>tto -> Η ώρα λήξης του εργαστηρίου.</li>
     * <li>courseType -> Ο τύπος του μαθήματος (συνήθως "Εργαστήριο").</li>
     * <li>labID -> Ο μοναδικός κωδικός του εργαστηρίακού τμήματος.</li>
     * <li>courseID -> Ο μοναδικός κωδικός του μαθήματος στο οποίο ανήκει.</li>
     * <li>courseTaughtSemester -> Το εξάμηνο στο οποίο διδάσκεται.</li>
     * </ol>
     * @param String $AM Επιστροφή μόνο των τμημάτων στα οποία είναι γράμμενος ο
     * φοιτητής με αυτό τον αριθμό μητρώου. Αν είναι null τότε δεν υπάρχει
     * φιλτράρισμα με βάση τον αριθμό μητρώου.
     * @param String $courseID Επιστροφή μόνο των τμημάτων που ανήκουν στο
     * συγκεκριμένο μάθημα. Αν είναι null τότε δεν υπάρχει φιλτράρισμα με βάση
     * τον κωδικό μαθήματος.
     * @param int $courseTaughtSemester Επιστροφή μόνο των τμημάτων που ανήκουν
     * σε μάθημα που διδάσκονται στο συγκεκριμένο εξάμηνο. Αν είναι null τότε
     * δεν υπάρχει φιλτράρισμα με βάση το εξάμηνο.
     * @return mixed Δισδιάστατος πίνακας με εργαστηριακά τμήματα και
     * πληροφορίες που τα αφορούν. Η μια διάσταση είναι απλά ένα αριθμτικό
     * index, ενώ η άλλη είναι associative array με τις διάφορες πληροφορίες. Η
     * θέση με δείκτη numStudents περιέχει τον αριθμό των φοιτητών που έχουν
     * κληρωθεί σε αυτό το εργαστήριο, ή έχουν γραφτεί μόνιμα με κάποιον τρόπο.
     */
    public function getLabs($AM = null, $courseID = null, $courseTaughtSemester = null) {
        $studentLessons = $this->getLessons($AM, $courseID, $courseTaughtSemester, 1);
        $teachers = $this->getTeacherDetails();
        $firstPriorityCount = $this->getFirstPriorityCount();
        $availableLabsQuery = "SELECT DISTINCT l.labName as labName, p.dayID as DAY, d.dayName, p.timeFrom as tfrom, p.timeTo as tto, lt.courseType, l.labID, l.courseID, les.courseTaughtSemester, les.courseName as courseName, l.labSize, tl.teacherID
                                                                        FROM (labs l, program p, labStatus ls, courseTypes lt, lessons les, days d) LEFT JOIN teacherLab tl ON l.labID = tl.labID
									WHERE p.semesterID = ls.semesterID AND p.semesterID = " . $this->curSemester . "
									AND p.dayID = d.dayID
									AND p.labID = l.labID AND l.labID = ls.labID
									AND l.courseID = les.courseID
									AND p.courseTypeID = lt.courseTypeID
									AND p.courseTypeID = 1
									AND ls.labStatusActive = 1
									AND p.courseID = l.courseID
									AND (";
        if ($courseID != null && !is_array($courseID) && in_array($courseID, $studentLessons)) {
            $availableLabsQuery .= "l.courseID = " . $courseID . " OR ";
        } else if ($courseID != null && is_array($courseID) && in_array($courseID, $studentLessons)) {
            foreach ($courseID as $l) {
                $availableLabsQuery .= "l.courseID = " . $l . " OR ";
            }
        } else {
            foreach ($studentLessons as $l) {
                // Εύρεση όλων των μαθημάτων που εμπείπτουν στο συγκεκριμένο ID και Επιστροφή στο πρόγραμμα
                $availableLabsQuery .= "l.courseID = " . $l . " OR ";
            }
        }
        $availableLabsQuery .= " 0)";
        $availableLabs = $this->db->query($availableLabsQuery);
        $availableLabsArray = Array();
        if ($availableLabs) {
            while ($l = $availableLabs->fetch_assoc()) {
                // -- Εύρεση του αριθμού των εγγεγραμένων φοιτητών --
                $l['numStudents'] = $this->getStudentCount($l['labID']);
                // -----------------------------------------------------------------------------------------
                // -- Εύρεση του αριθμού φοιτητών που έχουν δηλώσει το εργαστήριο σαν πρώτη προταιρεότητα --
                if (isset($firstPriorityCount[$l['labID']])) {
                    $l['firstPriorityCount'] = $firstPriorityCount[$l['labID']];
                } else {
                    $l['firstPriorityCount'] = 0;
                }
                // -----------------------------------------------------------------------------------------
                // -- Εύρεση του καθηγητή που διδάσκει σε αυτό το τμήμα --
                if (isset($teachers[$l['teacherID']]['teacherName'])) {
                    $l['teacherName'] = $teachers[$l['teacherID']]['teacherName'];
                } else {
                    $l['teacherName'] = '-';
                }
                // -----------------------------------------------------------------------------------------
                array_push($availableLabsArray, $l);
            }
        }
        return $availableLabsArray;
    }

    /**
     * Επιστρέφει τον αριθμό των φοιτητών που είναι εγγεγραμένοι σε ένα τμήμα.
     * @param String $labID Ο κωδικός του τμήματος για το οποίο θέλουμε τον
     * αριθμό.
     * @return int Ο αριθμός των φοιτητών που είναι εγγεγραμένοι στο τμήμα.
     */
    public function getStudentCount($labID) {
        $query = "SELECT COUNT(studAM) numStudents FROM " . $this->internalDbName . ".curStudentLab WHERE labID = '" . $labID . "';";
        $queryResult = $this->db->query($query);
        $result = $queryResult->fetch_row();
        return $result[0];
    }

    /**
     * Επιστρέφει ένα δισδιάστατο πίνακα με τις θεωρίες και πληροφορίες
     * για αυτές, φιλτραρισμένες με βάση διάφορες παραμέτρους, οι οποίες μπορούν
     * να συνδυαστούν. Οι πληροφορίες που περιέχονται αφορούν τη θέση στο
     * ωρολόγιο πρόγραμμα, τον τύπο, το εξάμηνο στο οποίο διδάσκονται κ.τ.λ.
     * και είναι οι εξής:
     * <ol><li>NAME -> Όνομα του μαθήματος.</li>
     * <li>DAY -> Το ID της ημέρας στην οποία διδάσκεται.</li>
     * <li>dayName -> Το όνομα της ημέρας στην οποία διδάσκεται.</li>
     * <li>tfrom -> Η ώρα έναρξης του εργαστηρίου.</li>
     * <li>tto -> Η ώρα λήξης του εργαστηρίου.</li>
     * <li>courseType -> Ο τύπος του μαθήματος (συνήθως "Θεωρία").</li>
     * <li>courseID -> Ο μοναδικός κωδικός του μαθήματος στο οποίο ανήκει.</li>
     * <li>courseTaughtSemester -> Το εξάμηνο στο οποίο διδάσκεται.</li>
     * </ol>
     * @param String $AM Επιστροφή μόνο των θεωριών στα οποία είναι γράμμενος ο
     * φοιτητής με αυτό τον αριθμό μητρώου. Αν είναι null τότε δεν υπάρχει
     * φιλτράρισμα με βάση τον αριθμό μητρώου.
     * @param String $courseID Επιστροφή μόνο των θεωριών που ανήκουν στο
     * συγκεκριμένο μάθημα. Αν είναι null τότε δεν υπάρχει φιλτράρισμα με βάση
     * τον κωδικό μαθήματος.
     * @param int $courseTaughtSemester Επιστροφή μόνο των θεωριών που
     * διδάσκονται στο συγκεκριμένο εξάμηνο. Αν είναι null τότε δεν υπάρχει
     * φιλτράρισμα με βάση το εξάμηνο.
     * @return mixed Δισδιάστατος πίνακας με θεωρίες και φροντιστήρια και
     * πληροφορίες που τα αφορούν. Η μια διάσταση είναι απλά ένα αριθμτικό
     * index, ενώ η άλλη είναι associative array με τις διάφορες πληροφορίες.
     */
    public function getTheories($AM = null, $courseID = null, $courseTaughtSemester = null) {
        $studentLessons = array_merge($this->getLessons($AM, $courseID, $courseTaughtSemester, 0));
        $teachers = $this->getTeacherDetails();
        $availableTheoriesQuery = "SELECT DISTINCT p.dayID as DAY, d.dayName, p.timeFrom as tfrom, p.timeTo as tto, lt.courseType, l.courseID, l.courseName as courseName, l.courseTaughtSemester, lrt.teacherID
                                                                        FROM (program p, lessons l, lessonStatus ls, courseTypes lt, days d) LEFT JOIN lessonResponsibleTeachers lrt ON lrt.courseID = l.courseID
									WHERE p.semesterID = ls.semesterID AND p.semesterID = " . $this->curSemester . "
									AND p.dayID = d.dayID
									AND p.courseID = l.courseID AND l.courseID = ls.courseID
									AND p.courseTypeID = lt.courseTypeID
									AND (p.courseTypeID = 0 OR p.courseTypeID = 2)
									AND ls.lessonStatusActive = 1
									AND (";
        if ($courseID != null && !is_array($courseID) && in_array($courseID, $studentLessons)) {
            $availableTheoriesQuery .= "l.courseID = " . $courseID . " OR ";
        } else if ($courseID != null && is_array($courseID) && in_array($courseID, $studentLessons)) {
            foreach ($courseID as $l) {
                $availableTheoriesQuery .= "l.courseID = " . $l . " OR ";
            }
        } else {
            foreach ($studentLessons as $l) {
                // Εύρεση όλων των μαθημάτων που εμπείπτουν στο συγκεκριμένο ID και Επιστροφή στο πρόγραμμα
                $availableTheoriesQuery .= "l.courseID = " . $l . " OR ";
            }
        }
        $availableTheoriesQuery .= " 0)";
        $availableTheories = $this->db->query($availableTheoriesQuery);
        $availableTheoriesArray = Array();
        if ($availableTheories) {
            while ($t = $availableTheories->fetch_assoc()) {
                // -- Εύρεση του καθηγητή που διδάσκει σε αυτό το τμήμα --
                if (isset($teachers[$t['teacherID']]['teacherName'])) {
                    $t['teacherName'] = $teachers[$t['teacherID']]['teacherName'];
                } else {
                    $t['teacherName'] = '-';
                }
                // -----------------------------------------------------------------------------------------
                array_push($availableTheoriesArray, $t);
            }
        }
        return $availableTheoriesArray;
    }

    /**
     * Επιστρέφει έναν πίνακα με IDs μαθημάτων και τα ονόματα τους.
     * @param String $AM Επιστροφή μόνο των μαθημάτων στα οποία είναι γράμμενος ο
     * φοιτητής με αυτό τον αριθμό μητρώου. Αν είναι null τότε δεν υπάρχει
     * φιλτράρισμα με βάση τον αριθμό μητρώου.
     * @param String $courseID Επιστροφή μόνο των μαθημάτων που ανήκουν στο
     * συγκεκριμένο μάθημα. Αν είναι null τότε δεν υπάρχει φιλτράρισμα με βάση
     * τον κωδικό μαθήματος.
     * @param int $courseTaughtSemester Επιστροφή μόνο των μαθημάτων που
     * διδάσκονται στο συγκεκριμένο εξάμηνο. Αν είναι null τότε δεν υπάρχει
     * φιλτράρισμα με βάση το εξάμηνο.
     * @param int $regType Ο τύπος του μαθήματος που θέλουμε να ανακτήσουμε
     * (πχ. Θεωρία, Εργαστήριο). Δεν ισχύει αν το $AM δεν έχει οριστεί.
     * @return mixed Δισδιάστατος πίνακας με IDs μαθημάτων και ονόματα.
     * Η μια διάσταση είναι απλά ένα αριθμτικό index, ενώ η άλλη είναι
     * associative array με τα IDs και τα ονόματα. Στον δείτκη numLabs υπάρχει
     * ο αριθμός των εργαστηριακών τμημάτων που περιέχει το μάθημα.
     */
    public function getLessonsWithInfo($AM = null, $courseID = null, $courseTaughtSemester = null, $regType = 0) {
        $studentLessons = $this->getLessons($AM, $courseID, $courseTaughtSemester, $regType);
        $lessonsInfoQuery = "SELECT DISTINCT l.courseID, l.courseName, COUNT(labs.labID) as numLabs FROM (lessons l, lessonStatus ls) LEFT JOIN labs labs ON labs.courseID=l.courseID
									WHERE l.courseID = ls.courseID
									AND ls.semesterID = " . $this->curSemester . "
									AND (";
        if ($courseID != null && in_array($courseID, $studentLessons)) {
            $lessonsInfoQuery .= "l.courseID = " . $courseID . " OR ";
        } else {
            foreach ($studentLessons as $l) {
                // Εύρεση όλων των μαθημάτων που εμπείπτουν στο συγκεκριμένο ID και Επιστροφή στο πρόγραμμα
                $lessonsInfoQuery .= "l.courseID = " . $l . " OR ";
            }
        }
        $lessonsInfoQuery .= " 0) GROUP BY l.courseID";
        $lessonsInfo = $this->db->query($lessonsInfoQuery);
        $lessonsInfoArray = Array();
        while ($t = $lessonsInfo->fetch_assoc()) {
            array_push($lessonsInfoArray, $t);
        }
        return $lessonsInfoArray;
    }

    /**
     * Επιστρέφει έναν πίνακα με IDs μαθημάτων.
     * @param String $AM Επιστροφή μόνο των μαθημάτων στα οποία είναι γράμμενος ο
     * φοιτητής με αυτό τον αριθμό μητρώου. Αν είναι null τότε δεν υπάρχει
     * φιλτράρισμα με βάση τον αριθμό μητρώου.
     * @param String $courseID Επιστροφή μόνο των μαθημάτων που ανήκουν στο
     * συγκεκριμένο μάθημα. Αν είναι null τότε δεν υπάρχει φιλτράρισμα με βάση
     * τον κωδικό μαθήματος.
     * @param int $courseTaughtSemester Επιστροφή μόνο των μαθημάτων που
     * διδάσκονται στο συγκεκριμένο εξάμηνο. Αν είναι null τότε δεν υπάρχει
     * φιλτράρισμα με βάση το εξάμηνο.
     * @param int $regType Ο τύπος του μαθήματος που θέλουμε να ανακτήσουμε
     * (πχ. Θεωρία, Εργαστήριο). Δεν ισχύει αν το $AM δεν έχει οριστεί.
     * @return array Μονοδιάστατος πίνακας με αριθμιτικούς δείκτες, που περιέχει
     * ένα ID μαθήματος σε κάθε θέση.
     */
    public function getLessons($AM = null, $courseID = null, $courseTaughtSemester = null, $regType = 0) {
        //$courseTaughtSemester = @iconv('ISO-8859-7', 'UTF-8', $courseTaughtSemester);
        $query = "SELECT sl.courseID FROM studentLesson sl, lessons l, lessonStatus ls WHERE sl.courseID = l.courseID AND sl.courseID = ls.courseID AND sl.semesterID = ls.semesterID AND ls.lessonStatusActive = 1 AND sl.semesterID = " . $this->curSemester;
        if ($AM != null) {
            $query .= " AND sl.studAM = " . $this->db->escape_string($AM) . " AND sl.regType = " . $this->db->escape_string($regType);
        }
        if ($courseID != null && !is_array($courseID)) {
            $query .= " AND sl.courseID = " . $this->db->escape_string($courseID);
        } else if ($courseID != null && is_array($courseID)) {
            foreach ($courseID as $l) {
                $query .= " AND sl.courseID = " . $this->db->escape_string($l);
            }
        }
        if ($courseTaughtSemester != null) {
            $query .= " AND l.courseTaughtSemester = " . $this->db->escape_string($courseTaughtSemester);
        }
        $studentLessons = $this->db->query($query);
        $lessonsArray = Array();
        if ($studentLessons) {
            while ($l = $studentLessons->fetch_row()) {
                array_push($lessonsArray, $l[0]);
            }
        }
        return $lessonsArray;
    }

    /**
     * Επιστρέφει έναν πίνακα με τις προτιμήσεις του δοθέντα φοιτητή.
     * @param String $AM Ο αριθμός μητρώου του φοιτητή.
     * @return mixed Επιστρέφει ένα μονοδιάστατο associative array, με τα
     * ονόματα των δεικτών να είναι κωδικοί εργαστηριακών τμημάτων και τα
     * περιεχόμενα να είναι οι αντίστοιχες προτιμήσεις για αυτά τα τμήματα.
     */
    public function getCurrentPreferences($AM) {
        $curPrefResult = $this->db->query("SELECT labID, Preference FROM " . $this->internalDbName . ".studentPreferences WHERE studAM = '" . $this->db->escape_string($AM) . "'");
        $curPrefArray = Array();
        while ($curPref = $curPrefResult->fetch_assoc()) {
            $curPrefArray[$curPref['labID']] = $curPref['Preference'];
        }
        return $curPrefArray;
    }

    /**
     * Επιστρέφει για κάθε εργαστήριο τον αριθμό των φοιτητών που το έχουν
     * δηλώσει σαν πρώτη προτεραιότητα.
     * @return Επιστρέφει ένα associative array όπου τα index συμβολίζουν
     * κωδικούς εργαστηρίων και τα περιεχόμενα των αριθμό των φοιτητών που το
     * έχουν δηλώσει σαν πρώτη προτεραιότητα.
     */
    public function getFirstPriorityCount() {
        $query = "SELECT labID, COUNT(studAM) FROM " . $this->internalDbName . ".studentPreferences WHERE Preference = 1 GROUP BY labID;";
        $result = $this->db->query($query);
        $firstPriorityCount = Array();
        while ($r = $result->fetch_row()) {
            $firstPriorityCount[$r[0]] = $r[1];
        }
        return $firstPriorityCount;
    }

    /**
     * Ενηερώνει την αποθήκη δεδομένων με τις αλλαγές που δίνονται από έναν
     * πίνακα αλλαγών. Αν υπάρξει σφάλμα στην ενημέρωση των προτιμήσεων τότε
     * ρίχνει DataHandlerException με κωδικό 10004.
     * @param String $AM Ο αριθμός μητρώου του φοιτητή για τον οποίο γίνεται η
     * ενημέρωση.
     * @param array $updatesArray Ο πίνακας ενημερώσεων. Είναι μονοδιάστατο
     * associative array με δείκτες τους κωδικούς των εργαστηριακών τμημάτων και
     * περιεχόμενα τις προτιμήσεις για τα αντίστοιχα τμήματα.
     */
    public function updatePreferences($AM, $updatesArray) {
        if ($updatesArray == null) {
            return true;
        } // Δεν μας έδωσαν κανένα update να κάνουμε, απλά επιστρέφουμε true.
        $query = '';
        foreach ($updatesArray as $labID => $pref) {
            if ($pref !== 'none') {
                $query = 'REPLACE INTO ".$this->internalDbName.".studentPreferences (labID, studAM, Preference) VALUES ("' . $labID . '", "' . $AM . '", ' . $pref . ');';
                if (!$this->db->query($query)) {
                    throw new DataHandlerException('Σφάλμα κατά την ενημέρωση των προτιμήσεων.<BR><BR>Το σφάλμα που επιστράφηκε ήταν:<BR>' . $this->db->error, 10004);
                }
            } else {
                $query = 'DELETE FROM ".$this->internalDbName.".studentPreferences WHERE labID = "' . $labID . '" AND studAM = "' . $AM . '";';
                if (!$this->db->query($query)) {
                    throw new DataHandlerException('Σφάλμα κατά την ενημέρωση των προτιμήσεων.<BR><BR>Το σφάλμα που επιστράφηκε ήταν:<BR>' . $this->db->error, 10004);
                }
            }
        }
        return true;
    }

    /**
     * Υπολογίζει και επιστρέφει το τρέχων εξάμηνο. Μετά την πρώτη κλήση της
     * μεθόδου η τιμή αποθηκεύεται και στις μεταγενέστερες κλήσεις απλά
     * επιστρέφεται, χωρίς καμία επικοινωνία με την αποθήκη δεδομένων.
     * @return int Το τρέχων εξάμηνο.
     */
    public function getCurrentSemester() {
        if ($this->curSemester == null) {
            $sq = $this->db->query("SELECT MAX(semesterID) as curSemester FROM semesters");
            $s = $sq->fetch_row();
            return $s[0];
        } else {
            return $this->curSemester;
        }
    }

    /**
     * Επιστρέφει τα ID και τις ημερομηνίες των κληρώσεων που είναι μέσα
     * στα πλαίσια της παραμέτρου. Επίσης επιστρέφει αν κάποια/ες από αυτές
     * είναι αυτή τη στιγμή σε εξέλιξη (δηλαδή τρέχει το σύστημα κληρώσεων για
     * αυτές).
     * @param String $context Δηλώνει ποιές κληρώσεις θέλουμε να εμφανίσουμε.
     * Μπορεί να έχει τις τιμές all, past (ή συνώνυμα το completed) ή future.
     * Επίσης μπορεί να χρησιμοποιηθεί η τιμή last που επιστρέφει μόνο την
     * πιο πρόσφατη ολοκληρωμένη κλήρωση.
     * @return mixed Επιστρέφει δισδιάστατο πίνακα που περιέχει τα ID, τις
     * ημερομηνίες των κληρώσεων και το αν αυτές είναι αυτή τη στιγμή σε
     * εξέλιξη.
     */
    public function getLotteries($context = 'all') {
        if ($context === 'future') {
            $query = "SELECT lotID, lotDate, lotExecuted FROM " . $this->internalDbName . ".lotteries WHERE lotDate > NOW()"; // Future
        } else if ($context === 'completed' || $context === 'past') {
            $query = "SELECT lotID, lotDate, lotExecuted FROM " . $this->internalDbName . ".lotteries WHERE lotDate < NOW()"; // Completed/Past
        } else if ($context === 'last') {
            $query = "SELECT lotID, lotDate, lotExecuted FROM " . $this->internalDbName . ".lotteries WHERE lotDate < NOW() ORDER BY lotDate DESC LIMIT 1"; // Completed/Past
        } else {
            $query = "SELECT lotID, lotDate, lotExecuted FROM " . $this->internalDbName . ".lotteries"; // All
        }
        // Εύρεση αν υπάρχει κάποια κλήρωση σε εξέλιξη
        $inProgressQuery = "SELECT lotID FROM " . $this->internalDbName . ".concurrencyLock";
        $inProgressResult = $this->db->query($inProgressQuery);
        $lotteriesResult = $this->db->query($query);
        $lotteriesArray = Array();
        $k = 0;
        while ($curLottery = $lotteriesResult->fetch_assoc()) {
            while ($inProgress = $inProgressResult->fetch_row()) {
                if ($inProgress[0] === $curLottery['lotID']) {
                    $curLottery['inProgress'] = true;
                }
            }
            $lotteriesArray[$k++] = $curLottery;
        }
        return $lotteriesArray;
    }

    /**
     * Ελέγχει αν υπάρχει κλήρωση σε εξέλιξη. Αν υπάρχει τότε επιστρέφει true,
     * αλλά δεν δίνει πληροφορία για το ποιά κλήρωση είναι αυτή.
     * @return boolean Επιστρέφει true αν υπάρχει κλήρωση σε εξέλιξη ή false
     * αν δεν υπάρχει.
     */
    public function lotteryInProgress() {
        $query = "SELECT COUNT(lockTime) FROM " . $this->internalDbName . ".concurrencyLock";
        $result = $this->db->query($query);
        $count = $result->fetch_row();
        if ((int) $count[0] > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Επιστρέφει το ID της πιο πρόσφατης κλήρωσης. Όταν ανακτηθεί μια φορά
     * κρατιέται σε cache για την ελαχιστοποίηση των queries.
     * @return int Το ID της πιο πρόσφατης κλήρωσης.
     */
    public function getLatestLotID() {
        if ($this->latestLotID != null) {
            return $this->latestLotID;
        } else {
            $lotID = $this->getLotteries("last");
            return $lotID[0]['lotID'];
        }
    }

    /**
     * Επιστρέφει τα τμήματα στα οποία κληρώθηκαν φοιτητές. Πρέπει να
     * σημειωθεί ότι τα δεδομένα που επιστρέφονται από αυτή τη μέθοδο
     * λειτουργούν μόνο κατά την περίοδο των κληρώσεων, μετά το τέλος της οι
     * κληρωμένοι φοιτητές μετακινούνται στην κεντρική βάση για πιο μόνιμη
     * αποθήκευση. Αν η μέθοδος αυτή κληθεί σε άλλη περίοδο επιστρέφει έναν
     * άδειο πίνακα.
     * @param String $AM Επιστρέφει τα κληρωθέντα τμήματα μόνο για τον
     * φοιτητή με τον συγκεκριμένο αριθμό μητρώου. Αν είναι null τότε δεν
     * γίνεται φιλτράρισμα με βάση τον φοιτητή.
     * @param int $lotteryID Επιστρέφει τα κληρωθέντα τμήματα μόνο για την
     * συγκεκριμένη κλήρωση. Αν είναι null τότε δεν γίνεται φιλτράρισμα με βάση
     * την κλήρωση.
     * @param String $labID Επιστρέφει τους κληρωθέντες φοιτητές για το
     * συγκεκριμένο τμήμα. Αν είναι null τότε δεν γίνεται φιλτράρισμα με
     * βάση το τμήμα.
     * @param String $courseID Επιστρέφει τα κληρωθέντα τμήματα μόνο για το
     * συγκεκριμένο μάθημα. Αν είναι null τότε δεν γίνεται φιλτράρισμα με βάση
     * το μάθημα.
     * @return mixed Επιστρέφει έναν δισδιάστατο πίνακα όπου η μια διάσταση
     * είναι ένας αριθμιτικός δείκτης και η άλλη είναι associative array με
     * τον αριθμό μητρώου του φοιτητή (studAM), την ημερομηνία κλήρωσης
     * (lotDate), τον κωδικό του τμήματος (labID), την ώρα έναρξης και λήξης
     * (ttime) και το όνομα της ημέρας που διδάσκεται αυτό το εργαστήριο
     * (dayName).
     */
    public function getAllocatedLabs($AM = null, $lotteryID = null, $labID = null, $courseID = null) {
        if ($AM == null) {
            throw new DataHandlerException('Προσπάθεια ανάκτησης των κληρωμένων εργαστηρίων για φοιτητή αλλά ο ΑΜ είναι null.', 10006);
        }
        $query = "SELECT DISTINCT l.labName as labName, p.dayID as DAY, d.dayName, CONCAT_WS('-', p.timeFrom, p.timeTo) as ttime, lt.courseType, l.labID, l.courseID, les.courseTaughtSemester, les.courseName as courseName, l.labSize, lot.lotDate
                                                                        FROM (labs l, program p, labStatus ls, courseTypes lt, lessons les, days d, " . $this->internalDbName . ".lotteries lot) INNER JOIN " . $this->internalDbName . ".curStudentLab csl ON csl.labID = l.labID AND csl.lotID = lot.lotID
									WHERE p.semesterID = ls.semesterID AND p.semesterID = " . $this->curSemester . "
									AND p.dayID = d.dayID
									AND p.labID = l.labID AND l.labID = ls.labID
									AND l.courseID = les.courseID
									AND p.courseTypeID = lt.courseTypeID
									AND p.courseTypeID = 1
									AND ls.labStatusActive = 1
									AND p.courseID = l.courseID
                                                                        AND (csl.studAM = '" . $AM . "')";
        if ($lotteryID != null) {
            $query .= " AND lot.lotID = " . $lotteryID . " ";
        }
        if ($labID != null) {
            $query .= " AND l.labID = " . $labID . " ";
        }
        if ($courseID != null) {
            $query .= " AND l.courseID = " . $courseID . " ";
        }
        $lotteriesResult = $this->db->query($query);
        $allotedLabs = Array();
        $k = 0;
        if ($lotteriesResult) {
            while ($curLab = $lotteriesResult->fetch_assoc()) {
                // -- Εύρεση του αριθμού των εγγεγραμένων φοιτητών --
                $curLab['numStudents'] = $this->getStudentCount($curLab['labID']);
                // -----------------------------------------------------------------------------------------
                $allotedLabs[$k++] = $curLab;
            }
        }
        return $allotedLabs;
    }

    /**
     * Επιστρέφει τα τμήματα στα οποία δεν κατάφεραν να κληρωθούν φοιτητές.
     * Πρέπει να σημειωθεί ότι τα δεδομένα που επιστρέφονται από αυτή τη μέθοδο
     * λειτουργούν μόνο κατά την περίοδο των κληρώσεων, μετά το τέλος της οι
     * κληρωμένοι φοιτητές μετακινούνται στην κεντρική βάση για πιο μόνιμη
     * αποθήκευση. Αν η μέθοδος αυτή κληθεί σε άλλη περίοδο επιστρέφει έναν
     * άδειο πίνακα.
     * @param String $AM Επιστρέφει τα μη κληρωθέντα τμήματα μόνο για τον
     * φοιτητή με τον συγκεκριμένο αριθμό μητρώου. Αν είναι null τότε δεν
     * γίνεται φιλτράρισμα με βάση τον φοιτητή.
     * @param int $lotteryID Επιστρέφει τα μη κληρωθέντα τμήματα μόνο για την
     * συγκεκριμένη κλήρωση. Αν είναι null τότε δεν γίνεται φιλτράρισμα με βάση
     * την κλήρωση.
     * @param String $labID Επιστρέφει τους μη κληρωθέντες φοιτητές για το
     * συγκεκριμένο τμήμα. Αν είναι null τότε δεν γίνεται φιλτράρισμα με
     * βάση το τμήμα.
     * @return mixed Επιστρέφει έναν δισδιάστατο πίνακα όπου η μια διάσταση
     * είναι ένας αριθμιτικός δείκτης και η άλλη είναι associative array με
     * τον αριθμό μητρώου του φοιτητή (studAM), την ημερομηνία κλήρωσης
     * (lotDate), τον κωδικό του τμήματος (labID), την ώρα έναρξης και λήξης
     * (ttime) και το όνομα της ημέρας που διδάσκεται αυτό το εργαστήριο
     * (dayName).
     */
    public function getFailedRegistrationsLabs($AM = null, $lotteryID = null, $labID = null) {
        $query = "SELECT DISTINCT l.labName as labName, p.dayID as DAY, d.dayName, CONCAT_WS('-', p.timeFrom, p.timeTo) as ttime, l.labID, l.courseID, lot.lotDate, fsl.failReason, les.courseName as courseName
                                                                        FROM (labs l, program p, labStatus ls, days d, lessons les, " . $this->internalDbName . ".lotteries lot) LEFT JOIN " . $this->internalDbName . ".failedStudentLab fsl ON fsl.labID = l.labID
									WHERE p.semesterID = ls.semesterID AND p.semesterID = " . $this->curSemester . "
									AND p.dayID = d.dayID
									AND p.labID = l.labID AND l.labID = ls.labID
									AND ls.labStatusActive = 1
									AND p.courseID = l.courseID
                                                                        AND les.courseID = l.courseID
                                                                        AND fsl.lotID = lot.lotID ";
        if ($AM != null) {
            $query .= " AND fsl.studAM = '" . $AM . "' ";
        }
        if ($lotteryID != null) {
            $query .= " AND lot.lotID = " . $lotteryID . " ";
        }
        if ($labID != null) {
            $query .= " AND l.labID = " . $labID . " ";
        }
        $query .= "ORDER BY l.labID";
        $lotteriesResult = $this->db->query($query);
        $failedLabs = Array();
        $k = 0;
        if ($lotteriesResult) {
            while ($curLab = $lotteriesResult->fetch_assoc()) {
                $failedLabs[$k++] = $curLab;
            }
        }
        return $failedLabs;
    }

    /**
     * Επιστρέφει τα μαθήματα στα οποία ο φοιτητής δεν κατάφερα να γραφτεί σε
     * κανένα τμήμα.
     * Πρέπει να σημειωθεί ότι τα δεδομένα που επιστρέφονται από αυτή τη μέθοδο
     * λειτουργούν μόνο κατά την περίοδο των κληρώσεων, μετά το τέλος της οι
     * κληρωμένοι φοιτητές μετακινούνται στην κεντρική βάση για πιο μόνιμη
     * αποθήκευση. Αν η μέθοδος αυτή κληθεί σε άλλη περίοδο επιστρέφει έναν
     * άδειο πίνακα.
     * @param String $AM Επιστρέφει τα μη κληρωθέντα μαθήματα μόνο για τον
     * φοιτητή με τον συγκεκριμένο αριθμό μητρώου. Αν είναι null τότε δεν
     * γίνεται φιλτράρισμα με βάση τον φοιτητή.
     * @param int $lotteryID Επιστρέφει τα μη κληρωθέντα μαθήματα μόνο για την
     * συγκεκριμένη κλήρωση. Αν είναι null τότε δεν γίνεται φιλτράρισμα με βάση
     * την κλήρωση.
     * @param String $courseID Επιστρέφει τους μη κληρωθέντες φοιτητές για το
     * συγκεκριμένο μάθημα. Αν είναι null τότε δεν γίνεται φιλτράρισμα με
     * βάση το μάθημα.
     * @return mixed Επιστρέφει έναν δισδιάστατο πίνακα όπου η μια διάσταση
     * είναι ένας αριθμιτικός δείκτης και η άλλη είναι associative array με
     * τον αριθμό μητρώου του φοιτητή (studAM), την ημερομηνία κλήρωσης
     * (lotDate), τον κωδικό του μαθήματος (courseID) και το όνομα του
     * μαθήματος (courseName).
     */
    public function getFailedRegistrationsCourses($AM = null, $lotteryID = null, $courseID = null) {
        $query = "SELECT DISTINCT l.courseName as courseName, l.courseID, lot.lotDate, fsc.failReason
                                                                        FROM (lessons l, " . $this->internalDbName . ".lotteries lot) LEFT JOIN " . $this->internalDbName . ".failedStudentCourse fsc ON fsc.courseID  = l.courseID
									WHERE fsc.lotID = lot.lotID ";
        if ($AM != null) {
            $query .= " AND fsc.studAM = '" . $AM . "' ";
        }
        if (isset($lotteryID) && $lotteryID != null) {
            $query .= " AND lot.lotID = " . $lotteryID . " ";
        }
        if (isset($labID) && $labID != null) {
            $query .= " AND l.courseID = " . $courseID . " ";
        }
        $query .= "ORDER BY l.courseID";
        $lotteriesResult = $this->db->query($query);
        $failedCourses = Array();
        $k = 0;
        while ($curLab = $lotteriesResult->fetch_assoc()) {
            $failedCourses[$k++] = $curLab;
        }
        return $failedCourses;
    }

    /**
     * Επιστρέφει τα μαθήματα για τα οποία είναι υπεύθυνος ένας καθηγητής.
     * @param String $teacherID Το ID του καθηγητή για τον οποίο θα επιστραφούν
     * τα μαθήματα για τα οποία είναι υπεύθυνος.
     * @return mixed Επιστρέφει μονοδιάστατο πίνακα όπου κάθε θέση είναι ένα
     * courseID μαθήματος.
     */
    public function getTeacherResponsibleCourses($teacherID) {
        $query = "SELECT courseID as courseID FROM lessonResponsibleTeachers WHERE teacherID = '" . $teacherID . "' AND semesterID = " . $this->curSemester . ";";
        $coursesResult = $this->db->query($query);
        $courses = Array();
        while ($course = $coursesResult->fetch_row()) {
            array_push($courses, $course[0]);
        }
        if (count($courses) <= 0) {
            throw new Exception('Ο συγκεκριμένος καθηγητής δεν είναι υπεύθυνος για κανένα μάθημα.', 50003);
        }
        return $courses;
    }

    /**
     * Επιστρέφει πληροφορίες για έναν/περισσότερους καθηγητές
     * @param String $teacherID Το ID του καθηγητή για το οποίο θα επιστραφούν
     * πληροφορίες. Αν δεν ορίζεται τότε επιστρέφει για όλους.
     * @return mixed Δισδιάστατο associative array όπου το index της πρώτης
     * διάστασης είναι τα ID των καθηγητών και η δεύτερη περιέχει τις διάφορες
     * πληροφορίες.
     */
    public function getTeacherDetails($teacherID = null) {
        $query = "SELECT teacherID, teacherGivenName as teacherName FROM teacher";
        if ($teacherID != null) {
            $query .= " WHERE teacherID = " . $this->db->escape_string($teacherID);
        }
        $teacherResult = $this->db->query($query);
        $teachers = Array();
        while ($teacherData = $teacherResult->fetch_assoc()) {
            $teachers[$teacherData['teacherID']] = $teacherData;
        }
        return $teachers;
    }

    /**
     * Αλλάζει τις παραμέτρους ενός εργαστηριακού τμήματος.
     * @param mixed updatesArray Δισδιάστατος πίνακας όπου η μια διάσταση έχει
     * labID και η άλλη τα διάφορα πεδία που θα ενημερωθούν.
     * @return boolean Επιστρέφει true αν η ενημέρωση έγινε με επιτυχία ή false
     * αν υπήρξε κάποιο σφάλμα.
     */
    public function updateLabParameters($updatesArray) {
        foreach ($updatesArray as $labID => $updates) {
            $query = "UPDATE labs SET labName = '" . $updates['labName'] . "', labSize = " . $updates['labSize'] . " WHERE labID = '" . $labID . "';";
            $this->db->query($query);
            if (!$this->db->query($query)) {
                throw new DataHandlerException('Σφάλμα κατά την ενημέρωση των παραμέτρων των εργαστηρίων.<BR><BR>Το σφάλμα που επιστράφηκε ήταν:<BR>' . $this->db->error, 10007);
            }
            if ($updates['teacher'] !== 'none') {
                $query = 'REPLACE INTO teacherLab (labID, teacherID) VALUES ("' . $labID . '", "' . $updates['teacher'] . '");';
                if (!$this->db->query($query)) {
                    throw new DataHandlerException('Σφάλμα κατά την αλλαγή καθηγητή σε κάποιο εργαστηριακό τμήμα.<BR><BR>Το σφάλμα που επιστράφηκε ήταν:<BR>' . $this->db->error, 10008);
                }
            } else {
                $query = 'DELETE FROM teacherLab WHERE labID = "' . $labID . '";';
                if (!$this->db->query($query)) {
                    throw new DataHandlerException('Σφάλμα κατά την αλλαγή καθηγητή σε κάποιο εργαστηριακό τμήμα.<BR><BR>Το σφάλμα που επιστράφηκε ήταν:<BR>' . $this->db->error, 10008);
                }
            }
        }
        return true;
    }

    /**
     * Διαγράφει τον φοιτητή από το συγκεκριμένο κληρωμένο εργαστήριο. Αν
     * υπάρξει τεχνικό πρόβλημα ρίχνει DataHandlerException με κωδικό 10005.
     * @param String $AM Ο αριθμός μητρώου του φοιτητή.
     * @param String $labID Ο κωδικός του εργαστηρίου.
     */
    public function withdrawFromLab($AM, $labID) {
        $query = "DELETE FROM " . $this->internalDbName . ".curStudentLab WHERE labID = " . $labID . " AND studAM = " . $AM;
        if (!$this->db->query($query)) {
            throw new DataHandlerException('Σφάλμα κατά την αποχώρηση από το εργαστήριο.', 10005);
        }
        return true;
    }

    /**
     * Επιστρέφει έναν πίνακα με τους παλαιούς φοιτητές που έχουν γραφτεί σε ένα
     * μάθημα.
     * @param String $labID Ο κωδικός του μαθήματος.
     * @return mixed Επιστρέφει πίνακα με τα στοιχεία των παλαιών φοιτητών.
     */
    public function getOldStudents($courseID) {
        $query = "SELECT sb.studGivenName FROM studentBasic sb INNER JOIN studentLesson sl ON sl.studAM = sb.studAM WHERE sl.regType = 4 AND courseID = '" . $courseID . "' AND semesterID = " . $this->curSemester . ";";
        $queryResult = $this->db->query($query);
        $students = Array();
        while ($data = $queryResult->fetch_row()) {
            $studentName = $data[0];
            array_push($students, $studentName);
        }
        return $students;
    }

    /**
     * Επιστρέφει έναν πίνακα με τους εγγεγραμένους φοιτητές σε ένα εργαστηριακό
     * τμήμα.
     * @param String $labID Ο κωδικός του εργαστηρίου.
     * @return mixed Επιστρέφει πίνακα με τα στοιχεία των εγγεγραμένων φοιτητών.
     */
    public function getRegisteredStudents($labID) {
        $query = "SELECT sb.studGivenName FROM studentBasic sb INNER JOIN " . $this->internalDbName . ".curStudentLab csl ON csl.studAM = sb.studAM WHERE csl.labID = '" . $this->db->escape_string($labID) . "';";
        $queryResult = $this->db->query($query);
        $students = Array();
        while ($data = $queryResult->fetch_row()) {
            $studentName = $data[0];
            array_push($students, $studentName);
        }
        return $students;
    }

    /**
     * Επιστρέφει τις προτεραιότητες εγγραφής φοιτητών.
     * @return mixed Επιστρέφει πίνακα με τις προτεραιότητες εγγραφής φοιτητών.
     */
    public function getRegistrationPriorities() {
        $query = "SELECT rpId, rpPrio, rpName, rpDatasource, rpParameters, rpEnabled FROM " . $this->internalDbName . ".registrationPriorities ORDER BY rpPrio;";
        $queryResult = $this->db->query($query);
        $rp = Array();
        while ($data = $queryResult->fetch_assoc()) {
            array_push($rp, $data);
        }
        return $rp;
    }

    /**
     * Ενηερώνει την αποθήκη δεδομένων με τις αλλαγές που δίνονται από έναν
     * πίνακα αλλαγών. Αν υπάρξει σφάλμα στην ενημέρωση των προτεραιοτήτων τότε
     * ρίχνει DataHandlerException με κωδικό 10009.
     * @param array $updatesArray Δισδιάστατος πίνακας όπου η μια διάσταση έχει
     * prId και η άλλη τα διάφορα πεδία που θα ενημερωθούν.
     * @return boolean Επιστρέφει true αν η ενημέρωση έγινε με επιτυχία ή false
     * αν υπήρξε κάποιο σφάλμα.
     */
    public function updateRegistrationPriorities($updatesArray) {
        foreach ($updatesArray as $rpId => $updates) {
            if (isset($updates['enabled']) && $updates['enabled'] === "yes") {
                $updates['enabled'] = 1;
            } else {
                $updates['enabled'] = 0;
            }
            $query = "UPDATE " . $this->internalDbName . ".registrationPriorities SET rpName = '" . $this->db->escape_string($updates['name']) . "', rpParameters = '" . $this->db->escape_string($updates['parameters']) . "', rpEnabled = " . $this->db->escape_string($updates['enabled']) . " WHERE rpId = " . $rpId . ";";
            if (!$this->db->query($query)) {
                throw new DataHandlerException('Σφάλμα κατά την ενημέρωση των προτεραιοτήτων εγγραφής.<BR><BR>Το σφάλμα που επιστράφηκε ήταν:<BR>' . $this->db->error, 10009);
            }
        }
        return true;
    }

    /**
     * Ενημερώνει την αποθήκη δεδομένων για τις αλλαγές στην κατάσταση των
     * κληρώσεων και δημιουργεί τα κατάλληλα scheduled tasks ή cron jobs. Οι
     * αλλαγές δίνονται από έναν πίνακα αλλαγών. Αν υπάρξει σφάλμα στην
     * ενημέρωση της κατάστασης κληρώσεων τότε ρίχνει DataHandlerException με
     * κωδικό 10010.
     * @param array $updatesArray Δισδιάστατος πίνακας όπου η μια διάσταση έχει
     * prId και η άλλη τα διάφορα πεδία που θα ενημερωθούν. Σε περίπτωση
     * προσθήκης το rpId αγνοείται.
     * @return boolean Επιστρέφει true αν η ενημέρωση έγινε με επιτυχία ή false
     * αν υπήρξε κάποιο σφάλμα.
     */
    public function updateLotteries($updatesArray) {
        foreach ($updatesArray as $lotId => $updatesArray) {
            if (isset($updatesArray['insert'])) { // Προσθήκη
                $query = "INSERT INTO " . $this->internalDbName . ".lotteries (lotDate) VALUES (STR_TO_DATE('" . $updatesArray['insert'] . "', '%m-%d-%Y %H:%i'));";
                // Προσθήκη του cron job
            } else if (isset($updatesArray['delete']) && $updatesArray['delete'] === "yes") { // Διαγραφή
                $query = "DELETE FROM " . $this->internalDbName . ".lotteries WHERE lotID = " . $lotId . ";";
                // Διαγραφή του cron job
            }
            if ($query != null) {
                if (!$this->db->query($query)) {
                    throw new DataHandlerException('Σφάλμα κατά την ενημέρωση της κατάστασης κληρώσεων.<BR><BR>Το σφάλμα που επιστράφηκε ήταν:<BR>' . $this->db->error, 10010);
                }
            }
        }
        return true;
    }

    /**
     * Γράφει έναν παλαιό φοιτητή στο τμήμα παλαιών.
     * @param String $studAM Ο αριθμός μητρώου του φοιτητή.
     * @param String $courseID Το μάθημα στο θέλει να εγγραφεί ως παλαιός
     * φοιτητής.
     * @return boolean Επιστρέφει true αν η ενημέρωση έγινε με επιτυχία ή false
     * αν υπήρξε κάποιο σφάλμα.
     */
    public function updateOldStudentRegStatus($studAM, $courseID) {
        $query = "UPDATE studentLesson SET regType = 4 WHERE regType = 3 AND studAM = '" . $studAM . "' AND courseID = '" . $courseID . "' AND semesterID = " . $this->curSemester . ";";
        if (!$this->db->query($query)) {
            throw new DataHandlerException('Σφάλμα κατά την ενημέρωση των προτιμήσεων.<BR><BR>Το σφάλμα που επιστράφηκε ήταν:<BR>' . $this->db->error, 10004);
        }
        return true;
    }

    /**
     * Συλλέγει διάφορα στατιστικά γύρω από το σύστημα.
     * @return mixed Επιστρέφει associative array με index τα όνοματα των
     * στατιστικών.
     */
    public function getStatistics() {

        function getSingleResult($query, $db) {
            $queryResult = $db->query($query);
            while ($data = $queryResult->fetch_row()) {
                $result = $data[0];
            }
            return $result;
        }

        function getRowCount($query, $db) {
            $queryResult = $db->query($query);
            return $queryResult->num_rows;
        }

        // Συνολικός αριθμός φοιτητών.
        $stats['studentCount'] = getSingleResult("SELECT COUNT(*) FROM studentBasic;", $this->db);
        // Συνολικός αριθμός φοιτητών που είναι εγγεγραμένοι σε τουλάχιστον ένα εργαστηριακό μάθημα.
        $stats['registeredToAtLeastOneLesson'] = getRowCount("SELECT studAM, COUNT(*) FROM studentlesson WHERE regType = 1 GROUP BY studAM HAVING COUNT(*) > 0;", $this->db);
        // Συνολικός αριθμός φοιτητών που είναι παλαιοί σε τουλάχιστον ένα εργαστηριακό μάθημα.
        $stats['oldInAtLeastOneLesson'] = getRowCount("SELECT studAM, COUNT(*) FROM studentlesson WHERE regType = 3 OR regType = 4 GROUP BY studAM HAVING COUNT(*) > 0;", $this->db);
        // Συνολικός αριθμός καθηγητών
        $stats['teacherCount'] = getSingleResult("SELECT COUNT(*) FROM teacher;", $this->db);
        // Συνολικός αριθμός τμημάτων.
        $stats['labCount'] = getSingleResult("SELECT COUNT(*) FROM labs;", $this->db);

        // Πίνακας με αριθμούς επιτυχών/ανεπιτυχών εγγραφών ανά προτεραιότητα
        function getPreferenceBreakdownTable($lotID, $db) {
            $query = "SELECT Preference, successfulRegistrations, failedRegistrations, totalRegistrations FROM " . $this->internalDbName . ".statisticspreferencebreakdown WHERE lotID = " . $lotID . ";";
            $queryResult = $db->query($query);
            while ($data = $queryResult->fetch_assoc()) {
                $preference = $data['Preference'];
                $result[$data['Preference']] = $data;
                unset($result[$data['Preference']]['Preference']); // Η προτεραιότητα είναι ήδη το index οπότε δεν υπάρχει λόγος να υπάρχει δύο φορές.
            }
            return $result;
        }

        $stats['preferenceBreakdown'] = getPreferenceBreakdownTable($this->getLatestLotID(), $this->db);

        // Πίνακας με αριθμούς επιτυχών/ανεπιτυχών εγγραφών ανά μάθημα
        function getCourseBreakdownTable($lotID, $db) {
            $breakdown = Array();
            // Ordering με βάση τις Ανεπιτυχείς Εγγραφές
            $failedQuery = "SELECT courseID, COUNT(studAM) as failedCount FROM " . $this->internalDbName . ".failedstudentcourse WHERE lotID = " . $lotID . " GROUP BY courseID ORDER BY failedCount DESC;";
            $queryResult = $db->query($failedQuery);
            while ($data = $queryResult->fetch_row()) {
                $courseID = $data[0];
                $breakdown[$courseID]['failedRegistrations'] = $data[1];
            }
            $successfulQuery = "SELECT p.courseID as courseID, COUNT(csl.studAM) as successCount FROM program p INNER JOIN " . $this->internalDbName . ".curstudentlab csl ON p.labID = csl.labID WHERE csl.lotID = " . $lotID . " GROUP BY courseID ORDER BY successCount DESC;";
            $queryResult = $db->query($successfulQuery);
            while ($data = $queryResult->fetch_row()) {
                $courseID = $data[0];
                $breakdown[$courseID]['successfulRegistrations'] = $data[1];
            }
            return $breakdown;
        }

        $stats['courseBreakdown'] = getCourseBreakdownTable($this->getLatestLotID(), $this->db);
        foreach ($stats['courseBreakdown'] as $courseID => $curCourse) {
            // Προσθήκη του ονόματος του μαθήματος και του successfulCount ή failedCount αν δεν υπάρχουν. Επίσης υπολογίζει το totalCount.
            if (!isset($stats['courseBreakdown'][$courseID]['successfulRegistrations'])) {
                $stats['courseBreakdown'][$courseID]['successfulRegistrations'] = 0;
            }
            if (!isset($stats['courseBreakdown'][$courseID]['failedRegistrations'])) {
                $stats['courseBreakdown'][$courseID]['failedRegistrations'] = 0;
            }
            $stats['courseBreakdown'][$courseID]['totalRegistrations'] = $stats['courseBreakdown'][$courseID]['successfulRegistrations'] + $stats['courseBreakdown'][$courseID]['failedRegistrations'];
            $temp = $this->getLessonsWithInfo(null, $courseID);
            $stats['courseBreakdown'][$courseID]['courseName'] = $temp[0]['courseName'];
        }
        return $stats;
    }

}

?>