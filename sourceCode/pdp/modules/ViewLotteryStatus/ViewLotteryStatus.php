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
        if($inProgress == null) { $this->inProgress = false; }
        $this->lotteryID = $lotteryID;
        $this->date = $date;
        $this->inProgress = $inProgress;
    }
    
    /**
     * Επιστρέφει την ημερομήνια της κλήρωσης.
     * @return string Η ημερομηνία της κλήρωσης.
     */
    function getDate() {
        return $this->date;
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
class ViewLotteryStatus implements IModule {
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
		foreach($lotteriesArray as $curLottery) {
                        if(!isset($curLottery['inProgress'])) {
                            $curLottery['inProgress'] = false; // Αποφυγή warning
                        }
			$lotteries[$k++] = new LotteryChoice($curLottery['lotID'], $curLottery['lotDate'], $curLottery['inProgress']);
		}
		return $lotteries;
	}
	
        /**
         * @var allocatedLabs Τα τμήματα στα οποία έχει γραφτεί με επιτυχία
         * ο χρήστης.
         * @var failedRegistrations Τα τμήματα στα οποία απέτυχε να γραφτεί
         * ο χρήστης.
         * @return string Ο HTML κώδικας με τα αποτελέσματα των κληρώσεων.
         */
	function displayLotteryLog() {
                $lastLot = $this->getLotteryChoices('last');
                if(!isset($lastLot[0])) {
                    $lastLot[0] = new LotteryChoice(0, 0, 0);
                }
		TemplateEngine::get()->handle()->assign('allocatedLabs', DataHandler::get()->getAllocatedLabs(User::getUser()->getID()));
                TemplateEngine::get()->handle()->assign('failedRegistrationsLabs', DataHandler::get()->getFailedRegistrationsLabs(User::getUser()->getID(), $lastLot[0]->getLotteryID()));
                TemplateEngine::get()->handle()->assign('failedRegistrationsCourses', DataHandler::get()->getFailedRegistrationsCourses(User::getUser()->getID(), $lastLot[0]->getLotteryID()));
		return TemplateEngine::get()->handle()->fetch('templates/modules/ViewLotteryStatus/LotteryResults.tpl');
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
		TemplateEngine::get()->handle()->assign('lotteryLog', $this->displayLotteryLog());
                TemplateEngine::get()->handle()->assign('lastLottery', $this->getLotteryChoices('last'));
		TemplateEngine::get()->handle()->assign('futureLotteryChoices', $this->getLotteryChoices('future'));
		TemplateEngine::get()->handle()->assign('completedLotteryChoices', $this->getLotteryChoices('completed'));
		TemplateEngine::get()->handle()->display('templates/modules/ViewLotteryStatus/ViewLotteryStatus.tpl');
	}
	
        /**
         * Σελίδα επιβεβαίωσης ότι ο χρήστης θέλει να αποχωρήσει από ένα
         * εργαστηριακό τμήμα στο οποίο έχει γραφτεί. Αν επιβεβαιωθεί τότε
         * δημιουργείται ένα αντικείμενο WithdrawalProcessor το οποίο
         * αναλαμβάνει να διεκπαιρεώσει την αποχώρηση.
         * @global mixed $_POST Η καθολική μεταβλητή $_POST.
         * @param string $labID Ο κωδικός του εργαστηρίου από το οποίο θα γίνει
         * αποχώρηση.
         * @var labInfo Πίνακας με πληροφορίες για το εργαστήριο από το οποίο
         * θα γίνει αποχώρηση.
         * @var referer Ο σελίδα από την οποία ήρθε ο χρήστης.
         */
	function confirmWithdraw($labID) {
		global $_POST;
		$labInfo = DataHandler::get()->getAllocatedLabs(User::getUser()->getID(), null, $labID); // Fetch the lab to make sure that the student is eligible to withdraw
		if(!isset($labInfo[0])) { throw new Exception('Το συγκεκριμένο τμήμα δεν υπάρχει ή ο σπουδαστής δεν είναι εγγεγραμμένος εκεί.', 40001); }
		if(isset($_POST['confirmTextbox']) && ($_POST['confirmTextbox'] === 'ΝΑΙ' || $_POST['confirmTextbox'] === 'YES')) {
			include('WithdrawalProcessor.php');
			$withdrawalprocessor = new WithdrawalProcessor($labID);
			$withdrawalprocessor->process();
			TemplateEngine::get()->handle()->display('templates/modules/ViewLotteryStatus/WithdrawalSuccess.tpl');
		} else {
			TemplateEngine::get()->handle()->assignByRef('labInfo', $labInfo[0]);
                        TemplateEngine::get()->handle()->assignByRef('referer', PageComposer::getReferer());
			TemplateEngine::get()->handle()->display('templates/modules/ViewLotteryStatus/WithdrawalConfirmation.tpl');
		}
	}
        
        /**
         * Η κύρια συνάρτηση που θα τρέξει όταν το module φορτωθεί.
         * @global mixed $_GET Η καθολική μεταβλητή $_GET.
         */
	function run() {
		global $_GET;
		if(isset($_GET['withdraw'])) {
			$this->confirmWithdraw($_GET['withdraw']);
		} else {
			$this->viewLotteries();
		}
	}

}
?>