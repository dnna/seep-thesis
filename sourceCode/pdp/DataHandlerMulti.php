<?php

/**
 * Ασχολείται με λειτουργίες ανάκτησης/αποθήκευσης δεδομένων σε χαμηλό επίπεδο.
 * Είναι singleton, δηλαδή μπορεί να υπάρχει μόνο ένα αντικείμενο αυτής της
 * κλάσης σε μια δεδομένη στιγμή, και μπορεί να ανακτηθεί με τη στατικη μέθοδο
 * get.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class DataHandlerMulti extends DataHandler {

    /**
     * @var mixed Οι πληροφορίες σύνδεσης με τη βάση δεδομένων.
     */
    protected $dbinfo;
    /**
     * @var mysqli Handle σύνδεσης με μια βάση δεδομένων.
     */
    protected $db;
    /**
     * @var int ήο ID της πιο πρόσφατης κλήρωσης.
     */
    protected $latestLotID;
    /**
     * @var string ήο όνομα της εσωτερικής βάσης δεδομένων.
     */
    protected $internalDbName;
    /**
     * @var mysqli Η βάση δεδομένων του eclass
     */
    protected $eclassdb;

    /**
     * Αρχικοποιεί υπολογίζοντας το τρέχων εξάμηνο, δημιουργώντας σύνδεση με
     * την αποθήκη δεδομένων, αν αυτό χρειάζεται κ.τ.λ. Αν υπάρξει τεχνικό
     * πρόβλημα ρίχνει DataHandlerException με κωδικό 10001.
     * Είναι protected για να μην μπορεί να αρχικοποιηθεί εκτός κλάσης.
     */
    protected function __construct() {
        // Σύνδεση με τη βάση
        include('config.php');
        $this->internalDbName = $config['internalDbName'];
        $this->db = new mysqli($config['internalDbHost'], $config['internalDbUser'], $config['internalDbPass']);
        if (!$this->db->connect_errno) {
            $this->db->query("SET NAMES utf8;");
        } else {
            throw new DataHandlerException("Δεν ήταν δυνατή η σύνδεση με κάποιο data-source.<BR><BR>Τοο σφάλμα που επιστράφηκε ήταν:<BR>" . $this->db->connect_error, 10001);
        }
        // Σύνδεση με το database του eclass για την ανάκτηση των στοιχείων αλλά
        // και των ρόλων του χρήστη.
        $this->eclassdb = new mysqli("1.2.3.4", "xyz", "zyx", 'claroline');
        if (!$this->eclassdb->connect_errno) {
            $this->eclassdb->set_charset('latin1');
        } else {
            throw new DataHandlerException("Δεν ήταν δυνατή η σύνδεση με κάποιο data-source.<BR><BR>Τοο σφάλμα που επιστράφηκε ήταν:<BR>" . $this->db->connect_error, 10001);
        }
    }

    /**
     * Επιστρέφει το handle της βάσης δεδομένων.
     * @return mysqli ήο handle της βάσης δεδομένων.
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
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://eclass.cs.teiath.gr/dnna_auth_proxy.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, Array('username' => $username, 'password' => $password));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
        if ($result === "LoginSuccess") {
            // Εύρεση του ονόματος
            $eclassresult = $this->eclassdb->query('SELECT user_id as eclassuid, nom, prenom FROM claroline.cl_user WHERE username = "' . $username . '";');
            if ($eclassresult && $eclassresult->num_rows > 0) {
                $data = $eclassresult->fetch_assoc();
                $userData['userName'] = $username;
                $userData['userID'] = $data['eclassuid'];
                $userData['userLastName'] = iconv("ISO-8859-7", "UTF-8", $data['prenom']);
                $userData['userFirstName'] = iconv("ISO-8859-7", "UTF-8", $data['nom']);
                $userData['eclassAuth'] = true;
                // Find if the user is a teacher or a student
                $eclassUserStatus = $this->eclassdb->query("SELECT role FROM claroline.cl_cours_user WHERE user_id = " . $userData['userID'] . " AND (statut = 1 OR tutor = 1);");
                if ($eclassUserStatus->num_rows > 0) {
                    array_push($userData['userRoles'], 'teacher'); // Ρόλος καθηγητή
                } else {
                    array_push($userData['userRoles'], 'student'); // Ρόλος σπουδαστή
                }
                // Find if the user is an admin
                $eclassAdminStatus = $this->eclassdb->query("SELECT idUser FROM claroline.cl_admin WHERE idUser = " . $userData['userID'] . ";");
                if ($eclassAdminStatus->num_rows > 0) {
                    array_push($userData['userRoles'], 'admin'); // Ρόλος διαχειριστή
                }
            } else {
                throw new DataHandlerException('Έγινε αυθεντικοποίηση μέσω eclass αλλά δεν μπόρεσαν να ανακτηθούν τα στοιχεία του χρήστη.', 10003);
            }
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
        $daysArray = Array(
            0 => Array('0', 'Δευτέρα'),
            1 => Array('1', 'Τρίτη'),
            2 => Array('2', 'Τετάρτη'),
            3 => Array('3', 'Πέμπτη'),
            4 => Array('4', 'Παρασκευή')
        );
        return $daysArray;
    }

    /**
     * Επιστρέφει το ID της ημέρας με το όνομα που δίνεται ως είσοδος.
     * @param string $dayName ήο όνομα της ημέρας της οποίας θέλουμε το ID.
     */
    protected function getDayID($dayName) {
        if (!isset($this->dayIDs[$dayName])) {
            $days = $this->getDays();
            foreach ($days as $dayID => $day) {
                if ($day[1] === $dayName) {
                    $this->dayIDs[$dayName] = $dayID;
                    return $this->dayIDs[$dayName]; // Found
                }
            }
            $this->dayIDs[$dayName] = -1; // Not Found
        }
        return $this->dayIDs[$dayName];
    }

    /**
     * ήπολογίζει το τυπικό εξάμηνο του φοιτητή με τον δοθέντα αριθμό μητρώου.
     * @param String $AM Ο αριθμός μητρώου του φοιτητή.
     * @return int ήο τυπικό εξάμηνο του φοιτητή.
     */
    public function getTypicalSemester($userID) {
        $usernameResult = $this->eclassdb->query('SELECT username FROM claroline.cl_user WHERE user_id = "' . $userID . '";');
        if ($usernameResult->num_rows > 0) {
            $username = $usernameResult->fetch_row();
            $regDetails = substr($username[0], 2, 5);
            $regYear = substr($regDetails, 0, 2);
            $regSemester = substr($regDetails, 2, 1);
            if (is_numeric($regYear) && is_numeric($regSemester)) { // Make sure we got something valid
                $yearDiff = date("y") - $regYear;
                if ($yearDiff < 0) { // If AM is before 2000
                    $yearDiff = 100 + $yearDiff; // Make the difference positive
                }
                if ($yearDiff > 0) { // This isn't the student's first semester
                    $semester = $yearDiff * 2 + $regSemester - 1;
                } else { // This is the student's first semester
                    $semester = 1;
                }
            } else {
                $semester = 1;
            }
        } else {
            $semester = 1;
        }
        return $semester;
    }

    /**
     * Ελέγχει ένα εργαστηριακό μάθημα στη βάση του eclass με στόχο να
     * εξσαφαλίσει ότι έχει την απαραίτητη δομή για ανακτηθούν πληροφορίες για
     * τα εργαστήρια του.
     * @param string $courseID ήο εργαστηριακό μάθημα που θα ελεγχθεί.
     * @param Array $requiredColumns Πίνακας με τα πεδία των οποίων η ύπαρξη θα
     * ελεγχθεί.
     */
    protected function eclassRequiredColumnsExist($courseID, $requiredColumns) {
        // Make sure day and hour info exists, otherwise the query will error out
        $tableInfoQuery = "SHOW COLUMNS FROM c_" . $courseID . ".group_team;";
        $columns = $this->eclassdb->query($tableInfoQuery);
        $colExists = Array();
        while ($col = $columns->fetch_assoc()) {
            foreach ($requiredColumns as $curCol) {
                if ($col['Field'] === $curCol) {
                    $colExists[$curCol] = true;
                }
            }
        }
        // Now that we have got a picture about the fields lets check if they
        // were all found and return the appropriate result.
        foreach ($requiredColumns as $curCol) {
            if (!isset($colExists[$curCol])) {
                return false; // Not found
            }
        }
        return true; // They were all found
    }

    /**
     * Επιστρέφει ένα δισδιάστατο πίνακα με εργαστηριακά τμήματα και πληροφορίες
     * για αυτά, φιλτραρισμένα με βάση διάφορες παραμέτρους, οι οποίες μπορούν
     * να συνδυαστούν. Οι πληροφορίες που περιέχονται αφορούν τη θέση στο
     * ωρολόγιο πρόγραμμα, τον τύπο, το εξάμηνο στο οποίο διδάσκονται κ.τ.λ.
     * και είναι οι εξής:
     * <ol><li>NAME -> Όνομα του εργαστηριακού τμήματος.</li>
     * <li>DAY -> ήο ID της ημέρας στην οποία διδάσκεται.</li>
     * <li>dayName -> ήο όνομα της ημέρας στην οποία διδάσκεται.</li>
     * <li>tfrom -> Η ώρα έναρξης του εργαστηρίου.</li>
     * <li>tto -> Η ώρα λήξης του εργαστηρίου.</li>
     * <li>courseType -> Ο τύπος του μαθήματος (συνήθως "Εργαστήριο").</li>
     * <li>labID -> Ο μοναδικός κωδικός του εργαστηρίακού τμήματος.</li>
     * <li>courseID -> Ο μοναδικός κωδικός του μαθήματος στο οποίο ανήκει.</li>
     * <li>courseTaughtSemester -> ήο εξάμηνο στο οποίο διδάσκεται.</li>
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
        $studentLessons = $this->getLessonsWithInfo($AM, $courseID, $courseTaughtSemester, 1);
        $teachers = $this->getTeacherDetails();
        $firstPriorityCount = $this->getFirstPriorityCount();

        // Form the query
        $availableLabsQuery = "";
        $availableLabsArray = Array();
        $firstLoop = true;
        foreach ($studentLessons as $curLesson) {
            // If the student is an old student then go no further
            if ($curLesson['oldStudent']) {
                continue;
            }
            if ($this->eclassRequiredColumnsExist($curLesson['courseID'], Array('day', 'hour'))) {
                // Add UNION to all loops except the first
                if (!$firstLoop) {
                    $availableLabsQuery .= " UNION";
                } else {
                    $firstLoop = false;
                }
                // End UNION stuff
                $availableLabsQuery .= " SELECT id as labID, name as labName, '" . $curLesson['courseID'] . "' as courseID, '" . $curLesson['courseName'] . "' as courseName, '" . $curLesson['courseType'] . "' as courseType, day as dayName, hour, place as room, maxStudent as labSize, tutor as teacherID
                    FROM c_" . $curLesson['courseID'] . ".group_team WHERE maxStudent IS NOT NULL AND day != '-' AND hour != '-'";
            }
        }

        // Query is formed, lets execute it
        if ($availableLabsQuery == null) {
            return Array(); // Avoid warning about empty query
        }
        $availableLabs = $this->eclassdb->query($availableLabsQuery);
        $availableLabsArray = Array();
        if ($availableLabs) {
            while ($l = $availableLabs->fetch_assoc()) {
                $l['combinedID'] = $l['courseID'] . '_' . $l['labID'];
                // -- Μετατροπή του ονόματος και του δωματίου σε UTF-8
                $l['labName'] = iconv("ISO-8859-7", "UTF-8", $l['labName']);
                $l['room'] = iconv("ISO-8859-7", "UTF-8", $l['room']);
                // -----------------------------------------------------------------------------------------
                // -- Μετατροπή της ημέρας σε αριθμό
                $l['dayName'] = iconv("ISO-8859-7", "UTF-8", $l['dayName']);
                $l['DAY'] = (string) $this->getDayID($l['dayName']);
                // -----------------------------------------------------------------------------------------
                // -- Διαχωρισμός της ώρας διδασκαλίας σε ώρα αρχής και ώρα τέλους
                if (strpos($l['hour'], '-') !== false) { // Αν η ώρα είναι σε μορφή xx-yy
                    $time = explode('-', $l['hour']);
                    $l['tfrom'] = $time[0];
                    $l['tto'] = $time[1];
                } else { // Αλλιώς αν έχει εισαχθεί μόνο η ώρα αρχής
                    $l['tfrom'] = (int) $l['hour'];
                    $l['tto'] = (int) ($l['hour']) + 2;
                }
                unset($l['hour']);
                // -----------------------------------------------------------------------------------------
                // -- Εύρεση του αριθμού των εγγεγραμένων φοιτητών --
                $l['numStudents'] = $this->getStudentCount($l['courseID'], $l['labID']);
                // -----------------------------------------------------------------------------------------
                // -- Εύρεση του αριθμού φοιτητών που έχουν δηλώσει το εργαστήριο σαν πρώτη προταιρεότητα --
                if (isset($firstPriorityCount[$l['courseID'] . '_' . $l['labID']])) {
                    $l['firstPriorityCount'] = $firstPriorityCount[$l['courseID'] . '_' . $l['labID']];
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
                // -- Εύρεση του αν πρόκειται για τμήμα παλαιών σπουδαστών
                //var_dump(strpos($curLesson['courseName'], 'Χ.Π.'));
                if (strpos($l['labName'], 'ΠΑΛΑΙΟΙ') !== false || strpos($l['labName'], 'ΠΑΛΑΙΟΥΣ') !== false ||
                        strpos($l['labName'], 'Παλαιοί') !== false || strpos($l['labName'], 'Παλαιούς') !== false ||
                        strpos($l['labName'], 'παλαιοί') !== false || strpos($l['labName'], 'παλαιούς') !== false ||
                        strpos($l['labName'], 'Χ.Π.') !== false || strpos($l['labName'], 'Χ.Π') !== false) {
                    $l['labOldStudents'] = true;
                } else {
                    $l['labOldStudents'] = false;
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
    protected function getStudentCount($courseID, $labID) {
        $query = "SELECT COUNT(studAM) numStudents FROM " . $this->internalDbName . ".curStudentLab WHERE labID = '" . $courseID . '_' . $labID . "';";
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
     * <li>DAY -> ήο ID της ημέρας στην οποία διδάσκεται.</li>
     * <li>dayName -> ήο όνομα της ημέρας στην οποία διδάσκεται.</li>
     * <li>tfrom -> Η ώρα έναρξης του εργαστηρίου.</li>
     * <li>tto -> Η ώρα λήξης του εργαστηρίου.</li>
     * <li>courseType -> Ο τύπος του μαθήματος (συνήθως "Θεωρία").</li>
     * <li>courseID -> Ο μοναδικός κωδικός του μαθήματος στο οποίο ανήκει.</li>
     * <li>courseTaughtSemester -> ήο εξάμηνο στο οποίο διδάσκεται.</li>
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
        $studentLessons = $this->getLessonsWithInfo($AM, $courseID, $courseTaughtSemester, 0);
        $teachers = $this->getTeacherDetails();

        // Form the query
        // Λείπει το dayName από το παρακάτω query
        $availableTheoriesQuery = "SELECT courseID, dayID as DAY, timeFrom as tfrom, timeTo as tto, 'Θεωρία' as courseType FROM " . $this->internalDbName . ".theorySchedule WHERE (0";
        $availableTheoriesArray = Array();
        $firstLoop = true;
        $courseNames = Array();
        foreach ($studentLessons as $curLesson) {
            if ($curLesson['courseID'][strlen($curLesson['courseID']) - 1] === 'E') {
                $curLesson['courseID'] = substr($curLesson['courseID'], 0, strlen($curLesson['courseID']) - 1);
            }
            $courseNames[$curLesson['courseID']] = $curLesson['courseName'];
            $availableTheoriesQuery .= " OR courseID = '" . $curLesson['courseID'] . "'";
        }

        // Query is formed, lets execute it
        if ($availableTheoriesQuery == null) {
            return Array(); // Avoid warning about empty query
        } else {
            $availableTheoriesQuery .= ")";
        }
        $availableTheories = $this->db->query($availableTheoriesQuery);
        $availableTheoriesArray = Array();
        if ($availableTheories) {
            while ($th = $availableTheories->fetch_assoc()) {
                // -- Μετατροπή του ονόματος και του δωματίου σε UTF-8
                $th['courseName'] = $courseNames[$th['courseID']];
                // -----------------------------------------------------------------------------------------
                // -- Καθηγητής θεωρίας κενός --
                $th['teacherID'] = '-1';
                $th['teacherName'] = '-';
                // -----------------------------------------------------------------------------------------
                array_push($availableTheoriesArray, $th);
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
        $lessonsInfoQuery = "SELECT c.code as courseID, c.intitule as courseName FROM claroline.cl_cours c WHERE (";
        if ($courseID != null && in_array($courseID, $studentLessons)) {
            $lessonsInfoQuery .= "c.code = '" . $courseID . "' OR ";
        } else {
            foreach ($studentLessons as $l) {
                // Εύρεση όλων των μαθημάτων που εμπείπτουν στο συγκεκριμένο ID και Επιστροφή στο πρόγραμμα
                $lessonsInfoQuery .= "c.code = '" . $l . "' OR ";
            }
        }
        $lessonsInfoQuery .= " 0) GROUP BY c.code";
        $lessonsInfo = $this->eclassdb->query($lessonsInfoQuery);
        $lessonsInfoArray = Array();
        while ($t = $lessonsInfo->fetch_assoc()) {
            $t['courseName'] = iconv('ISO-8859-7', 'UTF-8', $t['courseName']); // Μετατροπή του ονόματος σε UTF-8
            $ergPos = strpos($t['courseName'], ' (Εργαστήριο)');
            if ($ergPos !== false) { // Αφαίρεση του όρου "Εργαστήριο" από το όνομα
                $t['courseName'] = substr($t['courseName'], 0, $ergPos);
                $t['courseType'] = 'Εργαστήριο';
            } else {
                $t['courseType'] = 'Θεωρία';
            }
            // Εύρεση του αριθμού εργαστηρίων που περιέχει το μάθημα
            $numLabsQuery = "SELECT COUNT(*) FROM c_" . $t['courseID'] . ".group_team;";
            $numLabs = $this->eclassdb->query($numLabsQuery);
            $num = $numLabs->fetch_row();
            $t['numLabs'] = (int) $num[0];
            // Τέλος εύρεσης αριθμού εργαστηρίων που περιέχει το μάθημα
            // Εύρεση του αν ο σπουδαστής έχει γραφτεί ως παλαιός στο συγκεκριμένο μάθημα
            if (isset($AM) && DataHandler::get()->isOldStudentRegistered(User::getUser()->getID(), $t['courseID'])) {
                $t['oldStudent'] = true;
            } else {
                $t['oldStudent'] = false;
            }
            // Τέλος εύρεσης του αν έχει γραφτεί ως παλαιός στο συγκεκριμένο μάθημα
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
        $query = "SELECT DISTINCT cu.code_cours as courseID FROM claroline.cl_cours_user cu, claroline.cl_cours c WHERE cu.code_cours = c.code";

        if ($regType == 0) { // Θεωρία
            $regType = "THEORY";
        } else if ($regType == 1) { // Εργαστήριο
            $regType = "LAB";
        } else if ($regType == 3) { // Εργαστήριο (Παλαιός Φοιτητής)
            // ΔΕΝ ήΠΑΡΧΕΙ ΛΕΙήΟήΡΓΙΚΟήΗήΑ ΓΙΑ ΠΑΛΑΙΟήΣ ΦΟΙήΗήΕΣ ΑήήΗ ήΗ ΣήΙΓΜΗ
        } else if ($regType == 4) { // Εργαστήριο (Εγγεγραμένος Παλαιός Φοιτητής)
            // ΔΕΝ ήΠΑΡΧΕΙ ΛΕΙήΟήΡΓΙΚΟήΗήΑ ΓΙΑ ΠΑΛΑΙΟήΣ ΦΟΙήΗήΕΣ ΑήήΗ ήΗ ΣήΙΓΜΗ
        }
        if ($AM != null) {
            $query .= " AND cu.user_id = " . $this->eclassdb->escape_string($AM) . " AND c.cours_type = '" . $this->db->escape_string($regType) . "'";
        }
        if ($courseID != null && !is_array($courseID)) {
            $query .= " AND cu.code_cours = '" . $this->eclassdb->escape_string($courseID) . "'";
        } else if ($courseID != null && is_array($courseID)) {
            foreach ($courseID as $l) {
                $query .= " AND cu.code_cours = '" . $this->eclassdb->escape_string($l) . "'";
            }
        }
        if ($courseTaughtSemester != null) {
            $query .= " AND c.faculte = '" . $this->eclassdb->escape_string($courseTaughtSemester) . "'"; // String cause taughtSemester may be OLD.
        }
        $studentLessons = $this->eclassdb->query($query);
        $lessonsArray = Array();
        while ($l = $studentLessons->fetch_row()) {
            array_push($lessonsArray, $l[0]);
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
                $query = 'REPLACE INTO ' . $this->internalDbName . '.studentPreferences (labID, studAM, Preference) VALUES ("' . $labID . '", "' . $AM . '", ' . $pref . ');';
                if (!$this->db->query($query)) {
                    throw new DataHandlerException('Σφάλμα κατά την ενημέρωση των προτιμήσεων.<BR><BR>ήο σφάλμα που επιστράφηκε ήταν:<BR>' . $this->db->error, 10004);
                }
            } else {
                $query = 'DELETE FROM ' . $this->internalDbName . '.studentPreferences WHERE labID = "' . $labID . '" AND studAM = "' . $AM . '";';
                if (!$this->db->query($query)) {
                    throw new DataHandlerException('Σφάλμα κατά την ενημέρωση των προτιμήσεων.<BR><BR>ήο σφάλμα που επιστράφηκε ήταν:<BR>' . $this->db->error, 10004);
                }
            }
        }
        return true;
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
     * @param int $lotID Μας επιτρέπει να φιλτράρουμε τα αποτελέσματα ώστε να
     * επιστρέφουν πληροφορίες μόνο για τη συγκεκριμένη κλήρωση με αυτό το
     * lotID. Χρήσιμο όταν θέλουμε να ανακτήσουμε πληροφορίες (πχ. ημ/νία) για
     * μια συγκεκριμένη κλήρωση όπου το lotID είναι γνωστό.
     * @return mixed Επιστρέφει δισδιάστατο πίνακα που περιέχει τα ID, τις
     * ημερομηνίες των κληρώσεων και το αν αυτές είναι αυτή τη στιγμή σε
     * εξέλιξη.
     */
    public function getLotteries($context = 'all', $lotID = null) {
        if ($context === 'future') {
            $query = "SELECT lotID, lotDate, lotExecuted FROM " . $this->internalDbName . ".lotteries WHERE lotDate > NOW()"; // Future
        } else if ($context === 'completed' || $context === 'past') {
            $query = "SELECT lotID, lotDate, lotExecuted FROM " . $this->internalDbName . ".lotteries WHERE lotDate < NOW()"; // Completed/Past
        } else if ($context === 'last') {
            $query = "SELECT lotID, lotDate, lotExecuted FROM " . $this->internalDbName . ".lotteries WHERE lotDate < NOW() ORDER BY lotDate DESC LIMIT 1"; // Completed/Past
        } else {
            $query = "SELECT lotID, lotDate, lotExecuted FROM " . $this->internalDbName . ".lotteries WHERE 1 = 1"; // All
        }
        // Πρόσθετο φίλτρο όταν ψάχνουμε ένα συγκεκριμένο $lotID
        if($lotID != null && $context !== 'last') {
            $query .= " AND lotID = ".$lotID;
        } else if($lotID != null && $context === 'last') {
            throw new DataHandlerException("Δεν είναι δυνατή η εύρεση της τελευταίας κλήρωσης όταν έχει οριστεί φίλτρο για το lotID.", 10011);
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
     * @return int ήο ID της πιο πρόσφατης κλήρωσης.
     */
    public function getLatestLotID() {
        if ($this->latestLotID != null) {
            return $this->latestLotID;
        } else {
            $lotID = $this->getLotteries("last");
            if (!isset($lotID[0])) {
                $lotID[0] = Array('lotID' => -1); // Fix undefined offset warning
            }
            return $lotID[0]['lotID'];
        }
    }

    /**
     * Επιστρέφει τα τμήματα στα οποία κληρώθηκαν φοιτητές.
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
        // -- Ειδικό block για τα εργαστήρια χωρίς παρακολούθηση
        if (strpos($labID, "OLDSTUDENT") !== false) { // Αν έχει επιλεχθεί τμήμα παλαιών σπουδαστών τότε απλά επιστρέφουμε αυτό το όνομα
            $curLab['combinedID'] = $labID;
            $split = explode('_', $labID);
            $curLab['courseID'] = $split[0];
            $curLab['labID'] = $split[1];
            $curLab['lotDate'] = -1;
            $curLab['courseType'] = 'Εργαστήριο';
            $curLab['labName'] = "Χωρίς Παρακολούθηση";
            $curLab['DAY'] = -1;
            $curLab['dayName'] = "-";
            $curLab['ttime'] = "-";
            $curLab['numStudents'] = 0;
            $curLab['labSize'] = "1000";

            $courseInfoQuery = "SELECT intitule, faculte FROM claroline.cl_cours WHERE code = '" . $curLab['courseID'] . "';";
            $courseInfoResult = $this->eclassdb->query($courseInfoQuery);
            $courseInfoData = $courseInfoResult->fetch_assoc();
            $curLab['courseName'] = iconv("ISO-8859-7", "UTF-8", $courseInfoData['intitule']);
            $curLab['courseTaughtSemester'] = $courseInfoData['faculte'];
            // -----------------------------------------------------------------------------------------
            return Array(0 => $curLab);
        }
        /// -----------------------------------------------------------------------------------------
        $query = "SELECT csl.labID as combinedID, SUBSTRING_INDEX(csl.labID, '_', 1) as courseID, lot.lotDate FROM " . $this->internalDbName . ".curstudentlab csl, " . $this->internalDbName . ".lotteries lot WHERE csl.lotID = lot.lotID AND studAM = '" . $AM . "'";
        if ($lotteryID != null) {
            $query .= " AND lot.lotID = " . $lotteryID . " ";
        }
        if ($labID != null) {
            $query .= " AND csl.labID = '" . $labID . "' ";
        }
        if ($courseID != null) {
            $query .= " AND SUBSTRING_INDEX(csl.labID, '_', 1) = '" . $courseID . "' ";
        }

        $lotteriesResult = $this->db->query($query);
        $allotedLabs = Array();
        $k = 0;
        if ($lotteriesResult) {
            while ($curLab = $lotteriesResult->fetch_assoc()) {
                $curLab['labID'] = substr($curLab['combinedID'], strpos($curLab['combinedID'], '_') + 1);
                $curLab['courseType'] = 'Εργαστήριο';
                // -- Εύρεση των υπόλοιπων στοιχείων του εργαστηρίου
                $labInfoQuery = "SELECT name as labName, day, hour, maxStudent FROM c_" . $curLab['courseID'] . ".group_team WHERE id = " . $curLab['labID'];
                $labInfoResult = $this->eclassdb->query($labInfoQuery);
                $labInfoData = $labInfoResult->fetch_assoc();
                $curLab['labName'] = iconv("ISO-8859-7", "UTF-8", $labInfoData['labName']);
                $curLab['dayName'] = iconv("ISO-8859-7", "UTF-8", $labInfoData['day']);
                $curLab['ttime'] = $labInfoData['hour'];
                $curLab['labSize'] = $labInfoData['maxStudent'];

                $courseInfoQuery = "SELECT intitule, faculte FROM claroline.cl_cours WHERE code = '" . $curLab['courseID'] . "';";
                $courseInfoResult = $this->eclassdb->query($courseInfoQuery);
                $courseInfoData = $courseInfoResult->fetch_assoc();
                $curLab['courseName'] = iconv("ISO-8859-7", "UTF-8", $courseInfoData['intitule']);
                $curLab['courseTaughtSemester'] = $courseInfoData['faculte'];
                // -----------------------------------------------------------------------------------------
                // -- Μετατροπή της ημέρας σε αριθμό
                $curLab['DAY'] = (string) $this->getDayID($curLab['dayName']);
                // -----------------------------------------------------------------------------------------
                // -- Εύρεση του αριθμού των εγγεγραμένων φοιτητών --
                $curLab['numStudents'] = $this->getStudentCount($curLab['courseID'], $curLab['labID']);
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
        if ($AM == null) {
            throw new DataHandlerException('Προσπάθεια ανάκτησης των μη-επιτυχημένων εργαστηρίων για φοιτητή αλλά ο ΑΜ είναι null.', 10006);
        }
        $query = "SELECT fsl.labID as combinedID, SUBSTRING_INDEX(fsl.labID, '_', 1) as courseID, fsl.failReason, lot.lotDate FROM " . $this->internalDbName . ".failedstudentlab fsl, " . $this->internalDbName . ".lotteries lot WHERE fsl.lotID = lot.lotID AND studAM = '" . $AM . "'";
        if ($lotteryID != null) {
            $query .= " AND lot.lotID = " . $lotteryID . " ";
        }
        if ($labID != null) {
            $query .= " AND fsl.labID = '" . $labID . "' ";
        }

        $lotteriesResult = $this->db->query($query);
        $failedLabs = Array();
        $k = 0;
        if ($lotteriesResult) {
            while ($curLab = $lotteriesResult->fetch_assoc()) {
                $curLab['labID'] = substr($curLab['combinedID'], strpos($curLab['combinedID'], '_') + 1);
                $curLab['courseType'] = 'Εργαστήριο';
                // -- Εύρεση των υπόλοιπων στοιχείων του εργαστηρίου
                $labInfoQuery = "SELECT name as labName, day, hour, maxStudent FROM c_" . $curLab['courseID'] . ".group_team WHERE id = " . $curLab['labID'];
                $labInfoResult = $this->eclassdb->query($labInfoQuery);
                $labInfoData = $labInfoResult->fetch_assoc();
                $curLab['labName'] = iconv("ISO-8859-7", "UTF-8", $labInfoData['labName']);
                $curLab['dayName'] = iconv("ISO-8859-7", "UTF-8", $labInfoData['day']);
                $curLab['ttime'] = $labInfoData['hour'];
                $curLab['labSize'] = $labInfoData['maxStudent'];

                $courseInfoQuery = "SELECT intitule, faculte FROM claroline.cl_cours WHERE code = '" . $curLab['courseID'] . "';";
                $courseInfoResult = $this->eclassdb->query($courseInfoQuery);
                $courseInfoData = $courseInfoResult->fetch_assoc();
                $curLab['courseName'] = iconv("ISO-8859-7", "UTF-8", $courseInfoData['intitule']);
                $curLab['courseTaughtSemester'] = $courseInfoData['faculte'];
                // -----------------------------------------------------------------------------------------
                // -- Μετατροπή της ημέρας σε αριθμό
                $curLab['DAY'] = (string) $this->getDayID($curLab['dayName']);
                // -----------------------------------------------------------------------------------------
                // -- Εύρεση του αριθμού των εγγεγραμένων φοιτητών --
                $curLab['numStudents'] = $this->getStudentCount($curLab['courseID'], $curLab['labID']);
                // -----------------------------------------------------------------------------------------
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
        $query = "SELECT DISTINCT fsc.courseID, lot.lotDate, fsc.failReason FROM " . $this->internalDbName . ".failedStudentCourse fsc, " . $this->internalDbName . ".lotteries lot WHERE fsc.lotID = lot.lotID ";
        if ($AM != null) {
            $query .= " AND fsc.studAM = '" . $AM . "' ";
        }
        if (isset($lotteryID) && $lotteryID != null) {
            $query .= " AND lot.lotID = " . $lotteryID . " ";
        }
        if (isset($labID) && $labID != null) {
            $query .= " AND fsc.courseID = " . $courseID . " ";
        }
        $query .= "ORDER BY fsc.courseID";
        $lotteriesResult = $this->db->query($query);
        $failedCourses = Array();
        $k = 0;
        while ($curLab = $lotteriesResult->fetch_assoc()) {
            // -- Εύρεση του ονόματος του μαθήματος
            $courseInfoQuery = "SELECT intitule FROM claroline.cl_cours WHERE code = '" . $curLab['courseID'] . "';";
            $courseInfoResult = $this->eclassdb->query($courseInfoQuery);
            $courseInfoData = $courseInfoResult->fetch_assoc();
            $curLab['courseName'] = iconv("ISO-8859-7", "UTF-8", $courseInfoData['intitule']);
            // -----------------------------------------------------------------------------------------
            $failedCourses[$k++] = $curLab;
        }
        return $failedCourses;
    }

    /**
     * Επιστρέφει τα μαθήματα για τα οποία είναι υπεύθυνος ένας καθηγητής.
     * @param String $teacherID ήο ID του καθηγητή για τον οποίο θα επιστραφούν
     * τα μαθήματα για τα οποία είναι υπεύθυνος.
     * @return mixed Επιστρέφει μονοδιάστατο πίνακα όπου κάθε θέση είναι ένα
     * courseID μαθήματος.
     */
    public function getTeacherResponsibleCourses($teacherID) {
        $query = "SELECT cu.code_cours as courseID FROM claroline.cl_cours_user cu, cl_cours c WHERE cu.code_cours = c.code AND cu.user_id = " . $teacherID . " AND cu.statut = 1 AND cu.tutor = 1 AND c.cours_type = 'LAB';";
        $coursesResult = $this->eclassdb->query($query);
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
     * @param String $teacherID ήο ID του καθηγητή για το οποίο θα επιστραφούν
     * πληροφορίες. Αν δεν ορίζεται τότε επιστρέφει για όλους.
     * @return mixed Δισδιάστατο associative array όπου το index της πρώτης
     * διάστασης είναι τα ID των καθηγητών και η δεύτερη περιέχει τις διάφορες
     * πληροφορίες.
     */
    public function getTeacherDetails($teacherID = null) {
        $query = "SELECT cu.user_id as teacherID, CONCAT(u.nom, ' ', u.prenom) as teacherName FROM claroline.cl_cours_user cu, claroline.cl_user u WHERE cu.user_id = u.user_id AND cu.statut = 1 AND cu.tutor = 1;";
        if ($teacherID != null) {
            $query .= " WHERE cu.user_id = " . $this->eclassdb->escape_string($teacherID);
        }
        $teacherResult = $this->eclassdb->query($query);
        $teachers = Array();
        while ($teacherData = $teacherResult->fetch_assoc()) {
            $teacherData['teacherName'] = iconv("ISO-8859-7", "UTF-8", $teacherData['teacherName']);
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
        throw new DataHandlerException('Αυτή η λειτουργία δεν έχει υλοποιηθεί.', 00000);
        return true;
    }

    /**
     * Διαγράφει τον φοιτητή από το συγκεκριμένο κληρωμένο εργαστήριο. Αν
     * υπάρξει τεχνικό πρόβλημα ρίχνει DataHandlerException με κωδικό 10005.
     * @param String $AM Ο αριθμός μητρώου του φοιτητή.
     * @param String $labID Ο κωδικός του εργαστηρίου.
     */
    public function withdrawFromLab($AM, $labID) {
        $query = "DELETE FROM " . $this->internalDbName . ".curStudentLab WHERE labID = '" . $labID . "' AND studAM = '" . $AM . "'";
        if (!$this->db->query($query)) {
            throw new DataHandlerException('Σφάλμα κατά την αποχώρηση από το εργαστήριο.', 10005);
        }
        return true;
    }

    /**
     * Επιστρέφει έναν πίνακα με τους εγγεγραμένους φοιτητές σε ένα εργαστηριακό
     * τμήμα.
     * @param String $labID Ο κωδικός του εργαστηρίου.
     * @return mixed Επιστρέφει πίνακα με τα στοιχεία των εγγεγραμένων φοιτητών.
     */
    public function getRegisteredStudents($labID) {
        $query = "SELECT studAM FROM " . $this->internalDbName . ".curStudentLab csl WHERE csl.labID = '" . $this->db->escape_string($labID) . "';";
        $queryResult = $this->db->query($query);
        $students = Array();
        while ($data = $queryResult->fetch_row()) {
            // Find the student's name
            $studNameQuery = "SELECT username, nom, prenom FROM claroline.cl_user WHERE user_id = " . $data[0];
            $studNameResult = $this->eclassdb->query($studNameQuery);
            $studNameArray = $studNameResult->fetch_assoc();
            $studentInfo['name'] = iconv("ISO-8859-7", "UTF-8", $studNameArray['prenom'] . ' ' . $studNameArray['nom']);
            $studentInfo['username'] = $studNameArray['username'];
            array_push($students, $studentInfo);
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
                throw new DataHandlerException('Σφάλμα κατά την ενημέρωση των προτεραιοτήτων εγγραφής.<BR><BR>ήο σφάλμα που επιστράφηκε ήταν:<BR>' . $this->db->error, 10009);
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
            if (isset($query) && $query != null) {
                if (!$this->db->query($query)) {
                    throw new DataHandlerException('Σφάλμα κατά την ενημέρωση της κατάστασης κληρώσεων.<BR><BR>ήο σφάλμα που επιστράφηκε ήταν:<BR>' . $this->db->error, 10010);
                }
            }
        }
        return true;
    }

    /**
     * Ελέγχει αν ο σπουδαστής έχει γραφτεί ως παλαιός σπουδαστής στο μάθημα που
     * δίνεται ως παράμετρος.
     * @param string $AM Ο αριθμός μητρώου του σπουδαστή.
     * @param string $courseID Ο κωδικός του μαθήματος που θα γίνει ο έλεγχος.
     * @return boolean Επιστρεφει true αν ο σπουδαστής είναι εγγεγραμένος ως
     * παλαιός, ή false αν δεν είναι.
     */
    public function isOldStudentRegistered($AM, $courseID) {
        $oldStudentQuery = "SELECT labID FROM " . $this->internalDbName . ".curstudentlab WHERE studAM = '" . $AM . "' AND labID = '" . $courseID . "_OLDSTUDENT';";
        $oldStudentResult = $this->db->query($oldStudentQuery);
        if ($oldStudentResult->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Γράφει έναν παλαιό φοιτητή στο τμήμα παλαιών.
     * @param String $studAM Ο αριθμός μητρώου του φοιτητή.
     * @param String $courseID ήο μάθημα στο θέλει να εγγραφεί ως παλαιός
     * φοιτητής.
     * @return boolean Επιστρέφει true αν η ενημέρωση έγινε με επιτυχία ή false
     * αν υπήρξε κάποιο σφάλμα.
     */
    public function registerOldStudent($studAM, $courseID) {
        // Διαγραφουμε όλες τις προτιμήσεις του σπουδαστή για να μην χρειάζεται να ελεγθεί από το σύστημα κληρώσεων
        $deleteOtherPrefsQuery = "DELETE FROM " . $this->internalDbName . ".studentpreferences WHERE studAM = '" . $studAM . "' AND SUBSTRING_INDEX(labID, '_', 1) = '" . $courseID . "';";
        if (!$this->db->query($deleteOtherPrefsQuery)) {
            throw new DataHandlerException('Σφάλμα κατά την ενημέρωση των προτιμήσεων.<BR><BR>Το σφάλμα που επιστράφηκε ήταν:<BR>' . $this->db->error, 10004);
        }
        $registerOldStudentQuery = "INSERT INTO " . $this->internalDbName . ".curstudentlab VALUES ('" . $studAM . "', -2, '" . $courseID . "_OLDSTUDENT');";
        if (!$this->db->query($registerOldStudentQuery)) {
            throw new DataHandlerException('Σφάλμα κατά την ενημέρωση των προτιμήσεων.<BR><BR>Το σφάλμα που επιστράφηκε ήταν:<BR>' . $this->db->error, 10004);
        }
        return true;
    }

    /**
     * Δημιουργεί και επιστρεφει έναν πίνακα που περιέχει στατιστικά στοιχεία
     * σχετικά με τα αποτελέσματα μιας κλήρωσης. Τα στατιστικά είναι χωρισμένα
     * ανα προτιμήση πχ. επιτυχείς και ανεπιτυχεις εγγραφές για την προτιμήση 1,
     * την 2 κτλ.
     * @param int $lotID Η κλήρωση για την οποία θα συλλεχθούν τα στατιστικά.
     * @return mixed Επιστρέφει τον πίνακα με τα στατιστικα ανα προτίμηση.
     */
    public function getPreferenceBreakdownTable($lotID) {
        $query = "SELECT Preference, successfulRegistrations, failedRegistrations, totalRegistrations FROM " . $this->internalDbName . ".statisticspreferencebreakdown WHERE lotID = " . $lotID . ";";
        $queryResult = $this->db->query($query);
        while ($data = $queryResult->fetch_assoc()) {
            $preference = $data['Preference'];
            $result[$data['Preference']] = $data;
            unset($result[$data['Preference']]['Preference']); // Η προτεραιότητα είναι ήδη το index οπότε δεν υπάρχει λόγος να υπάρχει δύο φορές.
        }
        if (!isset($result)) {
            $result = null; // Avoid undefined variable warning
        }
        return $result;
    }

    /**
     * Δημιουργεί και επιστρεφει έναν πίνακα που περιέχει στατιστικά στοιχεία
     * σχετικά με τους σπουδαστές που δεν γραφτηκαν σε κανένα εργαστηριακό
     * τμήμα σε τουλάχιστον ένα μάθημα.
     * @param int $lotID Η κλήρωση για την οποία θα συλλεχθούν τα στατιστικά.
     * @return mixed Επιστρέφει τον πίνακα με τους σπουδαστές που δεν γραφτηκαν.
     */
    public function getFailedCourseBreakdownTable($lotID) {
        $breakdown = Array();
        // Ordering με βάση τις Ανεπιτυχείς Εγγραφές
        $failedQuery = "SELECT courseID, COUNT(studAM) as failedCount FROM " . $this->internalDbName . ".failedstudentcourse WHERE lotID = " . $lotID . " GROUP BY courseID ORDER BY failedCount DESC;";
        $queryResult = $this->db->query($failedQuery);
        while ($data = $queryResult->fetch_row()) {
            $courseID = $data[0];
            $breakdown[$courseID]['failedRegistrations'] = $data[1];
        }
        foreach ($breakdown as $courseID => &$curCourse) {
            if (!isset($curCourse['failedRegistrations'])) {
                $curCourse['failedRegistrations'] = 0;
            }
            $temp = $this->getLessonsWithInfo(null, $courseID);
            $curCourse['courseName'] = $temp[0]['courseName'];
        }
        return $breakdown;
    }

    /**
     * Επιστρέφει τα στοιχεία των σπουδαστών που δεν γράφτηκαν σε κανένα
     * εργαστηριακό τμήμα ενός μαθήματος.
     * @param int $lotID Η κλήρωση στην οποία οι σπουδαστες δεν γράφτηκαν.
     * @param Array $courseID Επιστρέφει έναν πίνακα με τους σπουδαστές που δεν
     * γράφτηκαν.
     */
    public function getFailedCourseStudent($lotID, $courseID) {
        $failedCourseStudentQuery = "SELECT studAM FROM " . $this->internalDbName . ".failedstudentcourse WHERE lotID = " . $lotID . " AND courseID = '".$this->db->escape_string($courseID)."';";
        $queryResult = $this->db->query($failedCourseStudentQuery);
        $students = Array();
        while ($data = $queryResult->fetch_row()) {
            // Find the student's name
            $studNameQuery = "SELECT nom, prenom, username FROM claroline.cl_user WHERE user_id = " . $data[0];
            $studNameResult = $this->eclassdb->query($studNameQuery);
            $studNameArray = $studNameResult->fetch_assoc();
            $studentInfo['name'] = iconv("ISO-8859-7", "UTF-8", $studNameArray['prenom'] . ' ' . $studNameArray['nom']);
            $studentInfo['username'] = $studNameArray['username'];
            array_push($students, $studentInfo);
        }
        return $students;
    }

    /**
     * Δημιουργεί και επιστρεφει έναν πίνακα που περιέχει στατιστικά στοιχεία
     * σχετικά με τα αποτελέσματα μιας κλήρωσης. Τα στατιστικά είναι χωρισμένα
     * ανα εργαστηριακο τμήμα πχ. ΤΝ1, ΤΝ2 κτλ.
     * @param int $lotID Η κλήρωση για την οποία θα συλλεχθούν τα στατιστικά.
     * @param string $courseID Η κλήρωση για το οποίο θα συλλεχθούν τα
     * στατιστικά.
     * @return mixed Επιστρέφει τον πίνακα με τα στατιστικα ανα εργαστηριακό
     * τμήμα.
     */
    public function getLabBreakdownTable($lotID, $courseID) {
        $breakdown = Array();
        // Fails
        $failedQuery = "SELECT labID, COUNT(studAM) as failedRegistrations FROM " . $this->internalDbName . ".failedstudentlab WHERE lotID = " . $lotID . " AND SUBSTRING_INDEX(labID, '_', 1) = '" . $this->db->escape_string($courseID) . "' GROUP BY labID;";
        $queryResult = $this->db->query($failedQuery);
        while ($data = $queryResult->fetch_assoc()) {
            $labID = $data['labID'];
            $breakdown[$labID]['failedRegistrations'] = $data['failedRegistrations'];
        }
        // Successes
        $successfulQuery = "SELECT labID, COUNT(studAM) as successfulRegistrations FROM " . $this->internalDbName . ".curstudentlab WHERE lotID = " . $lotID . " AND SUBSTRING_INDEX(labID, '_', 1) = '" . $courseID . "' GROUP BY labID;";
        $queryResult = $this->db->query($successfulQuery);
        while ($data = $queryResult->fetch_assoc()) {
            $labID = $data['labID'];
            $breakdown[$labID]['successfulRegistrations'] = $data['successfulRegistrations'];
        }
        $labsInfo = $this->getLabs(null, $courseID, null);
        foreach ($breakdown as $labID => &$curLab) {
            if (!isset($curLab['failedRegistrations'])) {
                $curLab['failedRegistrations'] = 0;
            }
            // Απλή σειριακή αναζήτηση για να βρούμε το εργαστηριακο τμήμα στο οποίο βρισκόμαστε αυτή τη στιγμή
            foreach ($labsInfo as $curLabInfo) {
                $curLabCombinedID = $curLabInfo['courseID'] . '_' . $curLabInfo['labID'];
                if ($curLabCombinedID === $labID) {
                    $curLab['labName'] = $curLabInfo['labName'];
                    break;
                }
            }
        }
        return $breakdown;
    }

    /**
     * Δημιουργεί και επιστρεφει έναν πίνακα που περιέχει στατιστικά στοιχεία
     * σχετικά με τα αποτελέσματα μιας κλήρωσης. Τα στατιστικά είναι χωρισμένα
     * ανα εργαστηριακο μάθημα πχ. Τεχνητή Νοημοσυνη, Μεταγλωττιστές κτλ.
     * @param int $lotID Η κλήρωση για την οποία θα συλλεχθούν τα στατιστικά.
     * @return mixed Επιστρέφει τον πίνακα με τα στατιστικα ανα εργαστηριακό
     * μάθημα.
     */
    public function getCourseBreakdownTable($lotID) {
        $courses = $this->getLessonsWithInfo();
        $breakdown = Array();
        foreach($courses as $courseID => $curCourse) {
            $breakdown[$courseID]['courseName'] = $curCourse['courseName'];
            $breakdown[$courseID]['courseID'] = $curCourse['courseID'];
            // Χρήση της getLabBreakdownTable για να πάρουμε στατιστικά για κάθε εργαστήριο του μαθήματος και στη συνέχεια απλή άθροιση
            $labBreakdown = $this->getLabBreakdownTable($lotID, $curCourse['courseID']);
            $breakdown[$courseID]['failedRegistrations'] = 0;
            $breakdown[$courseID]['successfulRegistrations'] = 0;
            foreach($labBreakdown as $curLab) {
                // Bug fix to avoid warning if its null
                if(!isset($curLab['failedRegistrations'])) {
                    $curLab['failedRegistrations'] = 0;
                }
                if(!isset($curLab['successfulRegistrations'])) {
                    $curLab['successfulRegistrations'] = 0;
                }
                $breakdown[$courseID]['failedRegistrations'] = $breakdown[$courseID]['failedRegistrations'] + $curLab['failedRegistrations'];
                $breakdown[$courseID]['successfulRegistrations'] = $breakdown[$courseID]['successfulRegistrations'] + $curLab['successfulRegistrations'];
            }
            if($breakdown[$courseID]['failedRegistrations'] == 0 && $breakdown[$courseID]['successfulRegistrations'] == 0) {
                unset($breakdown[$courseID]);
            }
        }
        return $breakdown;
    }

}

?>
