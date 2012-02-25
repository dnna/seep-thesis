<?php
/**
 * Επξεργάζεται τη νέα κατάσταση κληρώσεων που έχει ζητήσει ο χρήστης, έτσι ώστε
 * να το περάσει με κατάλληλη μορφή στο DataHandler.
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
         * Εκτελεί την επεξεργασία των παραμέτρων POST πριν τα περάσει στο
         * DataHandler.
         * @return boolean true αν η επεξεργασία εκτελεστεί με επιτυχία ή false
         * αν παρουσιαστεί κάποιο σφάλμα. 
         */
	function process() {
                $updatesArray = Array();
                foreach($this->postArray as $fieldName => $data) {
                    // Χωρίζουμε το field στα επιμέρους στοιχεία του
                    $fields = explode('_', $fieldName);
                    $fieldType = $fields[0]; // Τι είδους δεδομένα περιέχει αυτό το πεδίο; (πχ. νέα κλήρωση)
                    if(isset($fields[1]) && $fields[1] != null) {
                        $lotId = $fields[1];
                    } else {
                        continue;
                    }

                    // Τα προσθέτουμε στον κατάλληλο πίνακα
                    $updatesArray[$lotId][$fieldType] = $data;
                }
                if(DataHandler::get()->updateLotteries($updatesArray)) {
                        return true;
                } else {
                        throw new Exception('Σφάλμα κατά την εκτέλεση ερωτήματος στη βάση δεδομένων.', 60001);
                }
		throw new Exception('Άγνωστο σφάλμα.', 60002);
		return false; // Something must have gone really really wrong if we reach this
	}
}
?>