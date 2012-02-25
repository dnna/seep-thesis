<?php
/**
 * Αντιπροσωπεύει τις επιλογές κληρώσεων στο αριστερό menu.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class LotteryChoice {

    /**
     * @var int Το ID της συγκεκριμένης κλήρωσης.
     */
    protected $lotteryID;
    /**
     * @var boolean Αν η κλήρωση εκτελείται αυτή τη στιγμή.
     */
    protected $inProgress;
    /**
     * @var string Η ημερομηνία της κλήρωσης.
     */
    protected $date;

    /**
     * Δημιουργεί μια επιλογή κλήρωσης.
     * @param int $lotteryID Το ID της συγκεκριμένης κλήρωσης.
     * @param string $date Η ημερομηνία της κλήρωσης.
     * @param boolean $inProgress Αν η κλήρωση εκτελείται αυτή τη στιγμή.
     */
    function __construct($lotteryID, $date, $inProgress = false) {
        if ($inProgress == null) {
            $this->inProgress = false;
        }
        $this->lotteryID = $lotteryID;
        $this->date = $date;
        $this->inProgress = $inProgress;
    }

    /**
     * Επιστρέφει την ημερομήνια της κλήρωσης.
     * @return string Η ημερομηνία της κλήρωσης.
     */
    function getDate() {
        return explode(' ', $this->date);
    }

    /**
     * Επιστρέφει το ID της κλήρωσης.
     * @return int Το ID της κλήρωσης.
     */
    function getLotteryID() {
        return $this->lotteryID;
    }

    /**
     * Επιστρέφει αν η κλήρωση εκτελείται αυτή τη στιγμή.
     * @return boolean true αν εκτελείται αυτή τη στιγμή ή false αν όχι. 
     */
    function isInProgress() {
        return $this->inProgress;
    }

}

/**
 * Εμφανίζει την τρέχουσα κατάσταση κληρώσεων και τα αποτελέσματα. Επίσης δίνει
 * τη δυνατότητα στο χρήστη να αποχωρήσει από μαθήματα στα οποία γράφτηκε.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class ViewLotteryDates implements IModule {

    /**
     * Δημιουργεί το αριστερό menu με τις επιλογές κληρώσεων. Επιστρέφει
     * έναν πίνακα με αντικείμενα τύπου LotteryChoice που αντιπροσωπεύουν
     * τις επιλογές του menu.
     * @param string $context Τι κλήρωσεις θα επιστραφούν (future, past ή
     * all).
     * @return LotteryChoice Οι επιλογές κληρώσεων.
     */
    function getLotteryChoices($context) {
        $lotteries = Array();
        $lotteriesArray = DataHandler::get()->getLotteries($context);
        $k = 0;
        foreach ($lotteriesArray as $curLottery) {
            if(!isset($curLottery['inProgress'])) {
                $curLottery['inProgress'] = false; // Αποφυγή warning
            }
            $lotteries[$k++] = new LotteryChoice($curLottery['lotID'], $curLottery['lotDate'], $curLottery['inProgress']);
        }
        return $lotteries;
    }

    /**
     * Συνθέτει τη σελίδα εμφάνισης αποτελεσμάτων.
     * @var lotteryLog Ο HTML κώδικας με τα αποτελέσματα των κληρώσεων.
     * @var futureLotteryChoices Οι μελλοντικές κληρώσεις που πρόκειται να
     * πραγματοποιηθούν.
     * @var completedLotteryChoices Οι προηγούμενες κλήρωσεις που έχουν
     * ολοκληρωθεί.
     */
    function viewLotteries() {
        TemplateEngine::get()->handle()->assign('futureLotteryChoices', $this->getLotteryChoices('future'));
        TemplateEngine::get()->handle()->assign('completedLotteryChoices', $this->getLotteryChoices('completed'));
        TemplateEngine::get()->handle()->display('templates/modules/'.$_GET['module'].'/ViewLotteryDates.tpl');
    }

    /**
     * Η κύρια συνάρτηση που θα τρέξει όταν το module φορτωθεί.
     * @global mixed $_GET Η καθολική μεταβλητή $_GET.
     */
    function run() {
        $this->viewLotteries();
    }
}
?>