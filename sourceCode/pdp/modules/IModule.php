<?php
/**
 * Interface που καθορίζει τις συναρτήσεις που θα πρέπει να περιλαμβάνει ένα
 * module για να μπορεί να χρησιμοποιηθεί.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
interface IModule {
        /**
         * Η κύρια συνάρτηση που θα τρέξει όταν το module φορτωθεί.
         */
	public function run();
}
?>