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
 * Δίνει τη δυνατότητα προσθαφαίρεσης κληρώσεων.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class ManageLotteries implements IModule {

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
    
    function displayLotteries() {
        TemplateEngine::get()->handle()->assign('head', TemplateEngine::get()->handle()->fetch('templates/modules/'.$_GET['module'].'/Head.tpl'));
        TemplateEngine::get()->handle()->assign('lotteries', DataHandler::get()->getLotteries('future'));
        TemplateEngine::get()->handle()->assign('lotteryChoices', $this->getLotteryChoices('future'));
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
     * Η κύρια συνάρτηση που θα τρέξει όταν το module φορτωθεί.
     * @global mixed $_GET Η καθολική μεταβλητή $_GET.
     * @global mixed $_POST Η καθολική μεταβλητή $_POST.
     */
    function run() {
        global $_GET, $_POST;
        if (isset($_GET['ProcessStatement']) && isset($_POST['submitted'])) {
            $this->processChanges();
        } else {
            $this->displayLotteries();
        }
    }
}

?>