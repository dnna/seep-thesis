<?php
/**
 * Αναλαμβάνει να διεκπαιρεώσει αποχωρήσεις από εργαστηριακά τμήματα.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class WithdrawalProcessor {
        /**
         * @var string Ο κωδικός του τμήματος από το οποίο ο χρήστης αποχωρεί.
         */
	protected $labID;
        
        /**
         * Δημιουργεί ένα αντικείμενο διεκπαιρέωσης αποχωρήσεων.
         * @param string $labID Ο κωδικός του τμήματος από το οποίο ο χρήστης
         * αποχωρεί.
         */
	function __construct($labID) {
		$this->labID = $labID;
	}
        
        /**
         * Εκτελείται η αποχώρηση.
         */
	function process() {
		// Αφού έχουμε εξασφαλίσει πλέον ότι πέρασε όλους τους ελέγχους προχωράμε να προσθέσουμε στη βάση
		if(DataHandler::get()->withdrawFromLab(User::getUser()->getID(), $this->labID)) {
			return true;
		} else {
			throw new Exception('Σφάλμα κατά την εκτέλεση ερωτήματος στη βάση δεδομένων.', 40002);
		}
		throw new Exception('Άγνωστο σφάλμα.', 40003);
		return false; // Κάτι πρέπει να πήγε πολύ στραβά αν φτάσουμε εδώ.
	}
}
?>