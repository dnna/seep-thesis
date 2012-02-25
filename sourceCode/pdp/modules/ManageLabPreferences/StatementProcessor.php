<?php
/**
 * Ελέγχει μια δήλωση για την εγκυρότητα της. Για να είναι μια δήλωση έγκυρη
 * πρέπει να ισχύουν τα εξής:<ul>
 * <li>Σε κάθε μάθημα οι προτεραιότητες πρέπει να είναι μοναδικές για κάθε
 * τμήμα.</li>
 * <li>Οι σειρές προτεραιότητες πρέπει να αυξάνονται με βήμα 1.</li>
 * <li>Ο χρήστης πρέπει να έχει δικαίωμα να γραφτεί σε αυτά τα τμήματα.</li>
 * <li>Ο χρήστης δεν πρέπει να έχει γραφτεί σε κάποιο εργαστηριακό τμήμα αυτού
 * του μαθήματος</li></ul>
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class StatementProcessor {
        /**
         * @var mixed Πίνακας με τις προτιμήσεις που περιέχει η δήλωση.
         */
	protected $postArray;
        
        /**
         * Δημιουργεί έναν επεξεργαστή δηλώσεων για μια δήλωση που έχει τις
         * παραμέτρους που δίνονται.
         * @param mixed $postArray Πίνακας με τις παραμέτρους της δήλωσης
         * (προτιμήσεις κτλ.).
         */
	function __construct($postArray) {
		$this->postArray = $postArray;
	}
	
	/**
         * Έλεγχος ότι οι προτεραιότητες είναι μοναδικές για κάθε τμήμα.
         * @param int $prios Πίνακας με προτεραιότητες για ένα μάθημα.
         * @return boolean true αν είναι μοναδικές ή false αν δεν είναι.
         */
	function checkPrioDup($prios) {
		foreach($prios as $curIDS) {
			$dup_array = array_unique($curIDS);
			if(count($curIDS) != count($dup_array)) {
				return false;
			}
		}
		return true;
	}
	
        /**
         * Έλεγχος ότι οι σειρές προτεραιοτήτων αυξάνονται με βήμα 1.
         * @param int $prios Πίνακας με προτεραιότητες για ένα μάθημα.
         * @return boolean true αν αυξάνονται με βήμα 1 ή false αν δεν.
         */
	function checkPrioOrder($prios) {
		foreach($prios as $curIDS) {
			$sortedArray = $curIDS;
			sort($sortedArray);
			for($i = 0; $i < count($sortedArray); $i++) {
				if($sortedArray[$i] != $i + 1) {
					return false;
				}
			}
		}
		return true;
	}
	
        /**
         * Έλεγχος ότι ο χρήστης έχει όντως δικαίωμα να γραφτεί σε αυτά τα
         * εργαστήρια
         * @param int $prios Πίνακας με προτεραιότητες για ένα μάθημα.
         * @param string $allowedLessons Πίνακας με τα μαθήματα στα οποία
         * επιτρέπεται να κάνει εγγραφή ο χρήστης.
         * @return boolean true αν επιτρέπεται η εγγραφή η false αν δεν.
         */
	function checkPrioDisallowedLessons($prios, $allowedLessons) {
		foreach($prios as $curIDS => $temp) {
			$allowed = false;
			foreach($allowedLessons as $curAllowedLesson) {
				if((string)$curAllowedLesson === (string)$curIDS) {
					$allowed = true;
					break;
				}
			}
			if(!$allowed) { return false; }
		}
		return true;
	}
	
        /**
         * Έλεγχος οτι ο χρήστης δεν έχει ήδη καταχωρηθεί σε κάποιο τμήμα αυτού
         * του μαθήματος
         * @param int $prios Πίνακας με προτεραιότητες για ένα μάθημα.
         * @param string $allocations Πίνακας με τα τμήματα στα οποία έχει
         * ήδη γραφτεί ο φοιτητής.
         * @return boolean true αν ο φοιτητής δεν έχει ήδη καταχωρηθεί σε κάποιο
         * τμήμα αυτού του μαθήματος ή false αν έχει.
         */
	function checkAlreadyAllocated($prios, $allocations) {
		foreach($prios as $curIDS => $temp) {
			foreach($allocations as $curAllocation) {
				if((string)$curAllocation['courseID'] === (string)$curIDS) {
					return false;
				}
			}
		}
		return true;
	}
        
        /**
         * Έλεγχος ότι υπάρχουν μελλοντικές κλήρωσεις, ώστε να έχει νόημα η
         * δήλωση των μαθημάτων.
         * @return boolean true αν υπάρχουν μελλντικές κληρώσεις ή false αν δεν
         * υπάρχουν.
         */
        function checkFutureLotteries() {
            if(count(DataHandler::get()->getLotteries('future')) > 0) {
                return true;
            } else {
                return false;
            }
        }
	
        /**
         * Εκτελεί τους ελέγχους και επιστρέφει αν η δήλωση είναι έγκυρη ή όχι.
         * @return boolean true αν η δήλωση είναι έγκυρη ή false αν δεν είναι. 
         */
	function process() {
		// Έλεγχος ότι δεν υπάρχουν δύο εργαστηριακά τμήματα στο ίδιο μάθημα με ίδια προτεραιότητα
		// Υλοποίηση με δημιουργία πίνακα $prios[μάθημα][αύξων αριθμός] = προτεραιότητα. Στη συνέχεια κοιτάμε απλά αν είναι μοναδικό για κάθε μάθημα.
		foreach($this->postArray as $key => $value) {
			$parts = explode('_', $key);
			if($parts[0] === 'pref' && $value !== 'none') {
				$courseID = $parts[1];
				if(!isset($prios[$courseID])) $prios[$courseID] = Array();
				array_push($prios[$courseID], $value);
			}
		}
		if(!isset($prios)) $prios[0][0] = -1; // Αν δεν υπάρχει κανένα μάθημα
		
		// Έλεγχος αν η προτεραιότητες είναι μοναδικές για κάθε τμήμα
		if(!$this->checkPrioDup($prios)) { throw new Exception('Σε κάποιο εργαστηριακό μάθημα υπάρχουν ίδιες προτεραιότητες για διαφορετικά τμήματα.', 30001); }
		
		// Έλεγχος ότι οι σειρές προτεραιοτήτων είναι σωστές
		if(isset($prios[0]) && $prios[0][0] != -1) {
			if(!$this->checkPrioOrder($prios)) { throw new Exception('Οι προτεραιότητες σε κάποιο εργαστηριακό μάθημα δεν αυξάνονται με βήμα 1.', 30002); }
		}
		// Έλεγχος ότι ο χρήστης έχει όντως δικαίωμα να γραφτεί σε αυτά τα εργαστήρια
		$allowedLessons = DataHandler::get()->getLessons(User::getUser()->getID(), null, null, 1);
		if(isset($prios[0]) && $prios[0][0] != -1) {
			if(!$this->checkPrioDisallowedLessons($prios, $allowedLessons)) { throw new Exception('Προσπάθεια εγγραφής σε εργαστηριακά τμήματα μη εγγεγραμμένου μαθήματος.', 30003); }
		}
		// Έλεγχος οτι ο χρήστης δεν έχει ήδη καταχωρηθεί σε κάποιο εργαστήριο αυτού του μαθήματος
		$allocations = DataHandler::get()->getAllocatedLabs(User::getUser()->getID());
		if(isset($prios[0]) && $prios[0][0] != -1) {
			if(!$this->checkAlreadyAllocated($prios, $allocations)) { throw new Exception('Για κάποιο από τα δηλωθέντα μαθήματα έχει γίνει ήδη κλήρωση και καταχώρηση σε κάποιο τμήμα.', 30004); }
		}
                // Έλεγχος ότι υπάρχουν μελλοντικές κληρώσεις
                if(!$this->checkFutureLotteries()) { throw new Exception('Δεν μπορεί να γίνει δήλωση γιατί δεν υπάρχουν μελλοντικές κληρώσεις.', 30005); }
		
		// Αφού έχουμε εξασφαλίσει πλέον ότι πέρασε όλους τους ελέγχους προχωράμε να προσθέσουμε στη βάση
		foreach($this->postArray as $key => $value) {
			$parts = explode('_', $key);
			if($parts[0] === 'pref') {
				$updatesArray[$parts[1].'_'.$parts[2]] = $value;
			}
		}
		if(DataHandler::get()->updatePreferences(User::getUser()->getID(), $updatesArray)) {
			return true;
		} else {
			throw new Exception('Σφάλμα κατά την εκτέλεση ερωτήματος στη βάση δεδομένων.', 30006);
		}
		throw new Exception('Άγνωστο σφάλμα.', 30008);
		return false; // Something must have gone really really wrong if we reach this
	}
	
		/**
		 * Εκτελεί τους ελέγχους και επιστρέφει αν ο παλαιός φοιτητής μπορεί
		 * να γραφτεί ή όχι.
		 * @return boolean true αν μπορεί να γραφτεί ή false αν δεν μπορεί. 
		 */
	function processOldStudent() {
		// Έλεγχος ότι ο χρήστης έχει όντως δικαίωμα να γραφτεί στο τμήμα παλαιών φοιτητών
		$allowedLessons = DataHandler::get()->getLessons(User::getUser()->getID(), null, null, 1);
		if(!in_array($this->postArray['courseID'], $allowedLessons)) { throw new Exception('Προσπάθεια εγγραφής μη παλαιού σπουδαστή σε τμήμα παλαιών ή ο σπουδαστής έχει γραφτεί ήδη.', 30007); }
		
		if(DataHandler::get()->registerOldStudent(User::getUser()->getID(), $this->postArray['courseID'])) {
			return true;
		} else {
			throw new Exception('Σφάλμα κατά την εκτέλεση ερωτήματος στη βάση δεδομένων.', 30006);
		}
		throw new Exception('Άγνωστο σφάλμα.', 30008);
		return false; // Something must have gone really really wrong if we reach this
	}
}
?>