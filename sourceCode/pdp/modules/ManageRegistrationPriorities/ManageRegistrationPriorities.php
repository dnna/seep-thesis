<?php
/**
 * Δίνει τη δυνατότητα καθορισμού των προτεραιοτήτων με τις οποίες θα γράφονται
 * οι φοιτητές.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class ManageRegistrationPriorities implements IModule {
    function displayRegistrationPriorities() {
        TemplateEngine::get()->handle()->assign('registrationPriorities', DataHandler::get()->getRegistrationPriorities());
        TemplateEngine::get()->handle()->display('templates/modules/' . $_GET['module'] . '/' . $_GET['module'] . '.tpl');
    }
    
    function displayRegistrationPrioritiesAdvanced() {
        TemplateEngine::get()->handle()->assign('registrationPriorities', DataHandler::get()->getRegistrationPriorities());
        TemplateEngine::get()->handle()->display('templates/modules/' . $_GET['module'] . '/' . $_GET['module'] . 'Advanced.tpl');
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
        } else if(isset($_GET['Advanced'])) {
            $this->displayRegistrationPrioritiesAdvanced();
        } else {
            $this->displayRegistrationPriorities();
        }
    }
}

?>