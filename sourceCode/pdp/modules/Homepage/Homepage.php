<?php
/**
 * Εμφανίζει την αρχική σελίδα.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class Homepage implements IModule {
        /**
         * Η κύρια συνάρτηση που θα τρέξει όταν το module φορτωθεί.
         */
	function run() {
		TemplateEngine::get()->handle()->display('templates/modules/Homepage/Homepage.tpl');
	}
}
?>