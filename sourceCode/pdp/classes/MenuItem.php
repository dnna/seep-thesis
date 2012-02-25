<?php
/**
 * Κάθε αντικείμενο αυτής της κλάσης περιέχει τις πληροφορίες που χρειάζεται για
 * να παρασταθεί στο menu. ΔΕΝ περιέχει πληροφορίες για τη θέση, η επιλογή της
 * θέσης γίνεται μέσα από τη μέθοδο generateMenu της κλάσης PageComposer.
 */
class MenuItem {

    /**
     * @var String Ο τίτλος όπως αυτός θα φαίνεται στο menu.
     */
    protected $title;
    /**
     * @var int Η σειρά, σε σχέση με τα υπόλοιπα αντικείμενα, που θα
     * εμφανιστεί στο menu. Το αντικείμενο με τη μέγιστη τιμή βρίσκεται
     * δεξιότερα.
     */
    protected $weight;
    /**
     * @var String Το URL στο οποίο θα οδηγεί η συγκεκριμένη επιλογή στο menu.
     */
    protected $url;

    /**
     * Κατασκευάζει το αντικείμενο σύμφωνα με τις παραμέτρους που δίνονται.
     * @param String $title Ο τίτλος όπως αυτός θα φαίνεται στο menu.
     * @param int $weight Η σειρά, σε σχέση με τα υπόλοιπα αντικείμενα, που
     * θα εμφανιστεί στο menu. Το αντικείμενο με τη μέγιστη τιμή βρίσκεται
     * δεξιότερα.
     * @param String $url Το URL στο οποίο θα οδηγεί η συγκεκριμένη επιλογή στο
     * menu.
     */
    function __construct($title, $weight, $url) {
        $this->title = $title;
        $this->weight = $weight;
        $this->url = $url;
    }

    /**
     * Επιστρέφει τον τίτλο όπως αυτός θα φαίνεται στο menu.
     * @return String Ο τίτλος όπως αυτός θα φαίνεται στο menu.
     */
    function getTitle() {
        return $this->title;
    }

    /**
     * Συνώνυμη της getTitle.
     * @see getTitle()
     */
    function getName() {
        return $this->getTitle();
    }

    /**
     * Επιστρέφει την προτεραιότητα αυτού του αντικειμένου. Αυτή μπορεί να
     * συγκριθεί με άλλα αντικείμενα αυτού του τύπου για να βρεθεί η σειρά
     * με την οποία θα πρέπει να εμφανιστούν. Το αντικείμενο με την μέγιστη
     * τιμή βρίσκεται δεξιότερα.
     * @return int Η σειρά, σε σχέση με τα υπόλοιπα αντικείμενα, που θα
     * εμφανιστεί στο menu
     */
    function getWeight() {
        return $this->weight;
    }

    /**
     * Επιστρέφει το URL στο οποίο θα οδηγεί η συγκεκριμένη επιλογή του menu.
     * @return String Το URL στο οποίο θα οδηγεί αυτή η επιλογή.
     */
    function getURL() {
        return $this->url;
    }

    /**
     * Ελέγχει αν το συγκεκριμένο αντικείμενο είναι η τρέχουσα επιλογή του
     * χρήστη. Δηλαδή αν ο χρήστης βρίσκεται στο URL στο οποίο θα τον
     * οδηγούσε αυτό το menu. Ο υπολογισμός γίνεται ελέγχοντας αν το τρέχων
     * QUERY_STRING περιέχει μέσα του το URL του αντικειμένου.
     * @return bool Επιστρέφει true αν είναι η τρέχουσα επιλογή ή false αν όχι.
     */
    function isCurrentChoice() {
        global $_GET;
        if (isset($_GET['module']) && strpos(parse_url($this->getURL(), PHP_URL_QUERY), $_GET['module']) !== false) {
            return true;
        } else {
            return false;
        }
        /*if (strpos($_SERVER['QUERY_STRING'], parse_url($this->getURL(), PHP_URL_QUERY)) !== false) {
            return true;
        } else {
            return false;
        }*/
    }

    /**
     * Συγκρίνει 2 MenuItem με βάση την προτεραίοτητα τους (weight).
     * @see getWeight()
     * @see PHP_MANUAL#usort
     * @param MenuItem $a Το πρώτο αντικείμενο.
     * @param MenuItem $b Το δεύτερο αντικείμενο.
     * @return int Επιστρέφει 0 αν είναι ίσα, +1 αν το a είναι μεγαλύτερο από το
     * b, -1 αν το b είναι μεγαλύτερο από το a.
     */
    static function cmp($a, $b) {
        if ($a->getWeight() == $b->getWeight()) {
            return 0;
        }
        return ($a->getWeight() > $b->getWeight()) ? +1 : -1;
    }
}

?>