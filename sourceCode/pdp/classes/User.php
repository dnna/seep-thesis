<?php

/**
 * Διαχειρίζεται όλες τις πληροφορίες που έχουν να κάνουν με τον χρήστη.
 * Περιέχει πληροφορίες όπως το ID, τους ρόλους κ.τ.λ. Επίσης ασχολείται με όλες
 * τις λειτουργίες που έχουν να κάνουν με αυθεντικοποίηση, πρόσβαση κ.τ.λ.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class User {
    protected $ID;
    protected $Roles;
    protected $userName;
    protected $FirstName;
    protected $LastName;
    protected $typicalSemester;
    protected $roleTranslationTable = Array(
    "student"   =>  "Σπουδαστής",
    "teacher"   =>  "Καθηγητής",
    "admin"     =>  "Διαχειριστής",
    );

    /**
     * Δημιουργεί ένα αντικείμενο User. Αν δεν οριστούν παράμετροι τότε
     * δημιουργεί έναν ανώνυμο χρήστη (δηλαδή με ID -1, ρόλο anonymous και όλα
     * τα υπόλοιπα πεδία με το κενό String).
     * @param String $ID Το μοναδικό ID του χρήστη.
     * @param mixed $Roles
     * @param String $userName
     * @param String $FirstName
     * @param String $LastName 
     */
    public function __construct($ID = -1, $Roles = Array('anonymous'), $userName = '', $FirstName = '', $LastName = '') {
        $this->ID = $ID;
        $this->Roles = $Roles;
        $this->userName = $userName;
        $this->FirstName = $FirstName;
        $this->LastName = $LastName;
    }

    /**
     * Επιστρέφει τον τρέχων συνδεδμένο χρήστη ή false αν ο χρήστης δεν έχει
     * αυθεντικοποιηθεί.
     * @return User Ο τρέχων συνδεδεμένος χρήστης. Ή boolean false αν ο χρήστης
     * δεν είναι αυθεντικοποιημένος.
     */
    public static function getUser() {
        if (!isset($_SESSION['user'])) {
            $_SESSION['user'] = new User(); // Create anonymous user
        }
        return $_SESSION['user'];
    }

    /**
     * Επιστρέφει το πραγματικό όνομα του χρήστη.
     * @return String Το πραγματικό όνομα του χρήστη.
     */
    function getFirstName() {
        return $this->FirstName;
    }

    /**
     * Επιστρέφει το πραγματικό επίθετο του χρήστη.
     * @return String Το πραγματικό επίθετο του χρήστη.
     */
    function getLastName() {
        return $this->LastName;
    }

    /**
     * Επιστρέφει το username του χρήστη.
     * @return String Το username του χρήστη.
     */
    function getuserName() {
        return $this->userName;
    }

    /**
     * Επιστρέφει έναν πίνακα με τους ρόλους του χρήστη.
     * @return mixed Πίνακας με τους ρόλους του χρήστη.
     */
    function getRoles() {
        return $this->Roles;
    }
    
    /**
     * Επιστρέφει έναν πίνακα με τους ρόλους του χρήστη μεταφρασμένους.
     * @return mixed Πίνακας με τους ρόλους του χρήστη μεταφρασμένους.
     */
    function getTranslatedRoles() {
        $translatedRoles = Array();
        foreach($this->getRoles() as $curRole) {
            array_push($translatedRoles, $this->roleTranslationTable[$curRole]);
        }
        return $translatedRoles;
    }
    
    /**
     * Επιστρέφει τους ρόλους που έχει ο χρήστης με μορφή ενός string. Οι ρόλοι
     * σε αυτό το string είναι χωρισμένοι με κόμμα (,).
     * @return String Το string με τους ρόλους του χρήστη.
     */
    function getRolesString() {
        $rolesString = "";
        foreach($this->getRoles() as $curRole) {
            $rolesString .= $curRole.', ';
        }
        $rolesString = substr($rolesString, 0, strlen($rolesString) - 2); // Αφαίρεση του τελευταίου κόμμα
        return $rolesString;
    }
    
    /**
     * Επιστρέφει τους ρόλους που έχει ο χρήστης, μεταφρασμένους, με μορφή ενός
     * string. Οι ρόλοι σε αυτό το string είναι χωρισμένοι με κόμμα (,).
     * @return String Το string με τους ρόλους του χρήστη μεταφρασμένους.
     */
    function getTranslatedRolesString() {
        $rolesString = "";
        foreach($this->getTranslatedRoles() as $curRole) {
            $rolesString .= $curRole.', ';
        }
        $rolesString = substr($rolesString, 0, strlen($rolesString) - 2); // Αφαίρεση του τελευταίου κόμμα
        return $rolesString;
    }

    /**
     * Έλεγχει αν ο χρήστης έχει τον δοθέντα ρόλο.
     * @param String $role Ο ρόλος τον οποίο ελέγχουμε.
     * @return bool Επιστρέφει true αν έχει τον ρόλο ή false αν δεν τον έχει.
     */
    function hasRole($role) {
        return in_array($role, $this->getRoles());
    }

    /**
     * Επιστρέφει το μοναδικό ID του χρήστη.
     * @return String Το μοναδικό ID του χρήστη.
     */
    function getID() {
        return (String)$this->ID;
    }
    
    /**
     * Επιστρέφει το τυπικό εξάμηνο του χρήστη, αν αυτός είναι φοιτητής. Αν ο
     * χρήστης δεν είναι φοιτητής (δεν έχει τον ρόλο φοιτητής) τότε επιστρέφει
     * false.
     * @return int Το τυπικό εξάμηνο του φοιτητή ή false αν δεν είναι φοιτητής.
     */
    function getTypicalSemester() {
        if(!$this->hasRole('student')) { return false; }
        if(!isset($this->typicalSemester)) {
            $this->typicalSemester = DataHandler::get()->getTypicalSemester($this->ID);
        }
        return $this->typicalSemester;
    }

    /**
     * Ελέγχει αν ο χρήστης έχει πρόσβαση σε κάποιο module. Αυτό γίνεται
     * ελέγχοντας το αρχείο ModuleDescr.php του αντίστοιχου module και
     * συγκρίνοντας του ρόλους του χρήστη μέχρι να βρέθει κάποιος κοινός με
     * έναν από αυτούς του module. Αν στο module υπάρχει σαν ρόλος το anonymous
     * τότε αυτό σημαίνει αυτόματα ότι όλοι έχουν πρόσβαση, ακόμα και αυτοί
     * που δεν έχουν αυθεντικοποιηθεί. Αν στο module υπάρχει σαν ρόλος το
     * authenticated αυτό σημαίνει αυτόματα ότι όλοι οι αυθεντικοποιημένοι
     * χρήστες έχουν πρόσβαση, ανεξαρτήτως ρόλου.
     * @param String $curModule Το module για το οποίο θα γίνει ο έλεγχος.
     * @return bool Επιστρέφει true αν έχει πρόσβαση ή false αν δεν έχει.
     */
    public function hasAccess($curModule) {
        if($curModule == null || $curModule === '') { return false; }
        if(!file_exists('modules/' . $curModule . '/ModuleDescr.php')) {
            throw new ModuleLoadException('Το συγκεκριμένο module δεν υπάρχει.', 404);
        }
        @include('modules/' . $curModule . '/ModuleDescr.php'); // Load module info
        
        if($mDescr['Roles'] != null) { // Αποφυγή warning όταν το module δεν έχει ρόλους για κάποιο λόγο (πχ. αν δεν υπάρχουν μελλοντικές κλήρωσεις).
            foreach ($mDescr['Roles'] as $curRole) { // Loop through the module's allowed roles to see if the user is allowed
                if ($curRole === 'anonymous' || ($curRole === 'authenticated' && User::getUser()->getID() !== '-1') || $this->hasRole($curRole)) {
                    return true;
                }
            }
        }
        return false;
    }
}
?>