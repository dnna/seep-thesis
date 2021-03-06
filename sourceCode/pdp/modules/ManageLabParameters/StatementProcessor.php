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
         * Εκτελεί τους ελέγχους και επιστρέφει αν η δήλωση είναι έγκυρη ή όχι.
         * @return boolean true αν η δήλωση είναι έγκυρη ή false αν δεν είναι. 
         */
	function process() {
                $updatesArray = Array();
                foreach($this->postArray as $fieldName => $data) {
                    // Χωρίζουμε το field στα επιμέρους στοιχεία του
                    $fields = explode('_', $fieldName);
                    $fieldType = $fields[0]; // Τι είδους δεδομένα περιέχει αυτό το πεδίο; (πχ. καθηγητή)
                    $courseID = $fields[1];
                    $labID = $fields[2];
                    
                    // Έλεγχος ότι το labID δεν είναι κενό
                    if($labID == null) {
                        continue;
                    }
                    
                    if($fieldType === 'labSize') {
                        $num = (int)$data;
                        if((!is_numeric($data) || $num < 0)) {
                            throw new Exception('Η χωρητικότητες όλων των τμημάτων πρέπει να είναι ακέραιοι αριθμοί από 0 και άνω.', 50002);
                        }
                        unset($num);
                    }
                    
                    // Τα προσθέτουμε στον κατάλληλο πίνακα
                    $updatesArray[$labID][$fieldType] = $data;
                }
                if(DataHandler::get()->updateLabParameters($updatesArray)) {
                        return true;
                } else {
                        throw new Exception('Σφάλμα κατά την εκτέλεση ερωτήματος στη βάση δεδομένων.', 30006);
                }
		throw new Exception('Άγνωστο σφάλμα.', 30007);
		return false; // Something must have gone really really wrong if we reach this
	}
}
?>