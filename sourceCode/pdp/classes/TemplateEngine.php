<?php
/**
 * Η κλάση αυτή ασχολείται με την αρχικοποίηση, την παραμετροποίηση και την
 * εύκολη ανάκτηση του handle για το Smarty. Είναι singleton, δηλαδή μπορεί να
 * υπάρχει μόνο ένα αντικείμενο αυτής της κλάσης σε μια δεδομένη στιγμή, και
 * μπορεί να ανακτηθεί με τη στατικη μέθοδο get.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class TemplateEngine {
        /**
         * @var Smarty Το handle της μηχανής του Smarty.
         */
	protected $templateEngine;
        /**
         * @var TemplateEngine $engine Το instance της κλάσης.
         */
        protected static $engine;
        
        /**
         * Αρχικοποιεί τις παραμέτρους του smarty όπως το που βρίσκονται οι
         * διάφοροι φάκελοι. Είναι protected για να μην μπορεί να αρχικοποιηθεί
         * εκτός κλάσης.
         */
	protected function __construct() {
		// NOTE: Smarty has a capital 'S'
		require_once('libs/Smarty/Smarty.class.php');
		$this->templateEngine = new Smarty();
		$this->templateEngine->template_dir = '.';
		$this->templateEngine->compile_dir  = 'libs/Smarty/templates_c/';
		$this->templateEngine->config_dir   = 'libs/Smarty/configs/';
		$this->templateEngine->cache_dir    = 'libs/Smarty/cache/';
	}
	
        /**
         * Αυτή η στατική μέθοδος επιστρέφει το instance της κλάσης, ή το
         * δημιουργεί, αν αυτό δεν υπάρχει.
         * @return TemplateEngine Το instance της κλάσης.
         */
	public static function get() {
		//TemplateEngine::$engine = null;
		if (TemplateEngine::$engine == null)
			TemplateEngine::$engine = new TemplateEngine();
		return TemplateEngine::$engine;
	}
	
        /**
         * Επιστρέφει το handle της μηχανής του Smarty.
         * @return Smarty Το handle της μηχανής του Smarty.
         */
	public function handle() {
		return $this->templateEngine;
	}
}
?>