<?php
/**
 * Η βασική σελίδα σφάλματος. Εμφανίζει στον χρήστη τον κωδικό του σφάλματος,
 * την περιγραφή και κάποιες πληροφορίες για το τι μπορεί να κάνει.
 * @uses ErrorPage.tpl
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class ErrorPage implements IModule {
        /**
         * @var Exception Το σφάλμα που παρουσιάστηκε.
         */
	protected $exception;
	
        /**
         * Αρχικοποιεί τη σελίδα με το Exception που δίνεται σαν παράμετρος.
         * @param Exception $exception Το σφάλμα που παρουσιάστηκε.
         */
	function __construct($exception) {
		$this->exception = $exception;
	}
	
        /**
         * Εμφανίζει τη σελίδα.
         */
	function run() {
		global $_SERVER;
                TemplateEngine::get()->handle()->assign('auth', User::getUser()); // Used to be assignByRef
		TemplateEngine::get()->handle()->assign('request_uri', $_SERVER['REQUEST_URI']);
		TemplateEngine::get()->handle()->assign('referer', PageComposer::getReferer());
                TemplateEngine::get()->handle()->assign('pageTitle', 'Σφάλμα'); // Δεν χρειάζεται ο χρήστης να βλέπει τον κωδικό του σφάλματος
		//TemplateEngine::get()->handle()->assign('pageTitle', 'Σφάλμα '.$this->exception->getCode());
		TemplateEngine::get()->handle()->assign('exceptionDescription', $this->exception->getMessage());
		TemplateEngine::get()->handle()->display('templates/ErrorPage.tpl');
		die(); // This makes sure that we don't get a messed up page if the error message is simply a warning
	}
}
?>