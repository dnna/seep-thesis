<?php
class Feedback implements IModule {
        /**
         * Η κύρια συνάρτηση που θα τρέξει όταν το module φορτωθεί.
         */
	function run() {
            if(!isset($_POST['comments']) || $_POST['comments'] == null) {
                $this->createFeedback();
            } else {
                $this->processFeedback();
            }
	}

        function createFeedback() {
                TemplateEngine::get()->handle()->assign('head', TemplateEngine::get()->handle()->fetch('templates/modules/' . $_GET['module'] . '/Head.tpl'));
                TemplateEngine::get()->handle()->display('templates/modules/' . $_GET['module'] . '/' . $_GET['module'] . '.tpl');
        }

        function processFeedBack() {
                global $_POST;
                // SMTP Settings
                require_once "Mail.php";
                $smtp = Mail::factory('smtp',array (
                        'host' => "mail.teiath.gr",
                        'auth' => false
                    ));
                $from = "cs051092@teiath.gr";
                $to = "Dimosthenis Nikoudis <dnna@dnna.gr>";

                // Form the message
                $message = "";
                if(isset($_POST['email']) && $_POST['email'] != null) {
                    $message .= "Από: ".$_POST['email']."\n\n";
                }
                $message .= "Σχόλια:\n";
                $message .= $_POST['comments'];
                // Send it
                $headers = array (
                        'From' => $from,
                        'To' => $to,
                        'Subject' => iconv("UTF-8", "ISO-8859-7", "ΣΕΕΠ Σχόλια")
                );
                $mail = $smtp->send($to, $headers, iconv("UTF-8", "ISO-8859-7", $message));
                if(PEAR::isError($mail)) {
                        throw new Exception("Υπηρξε κάποιο πρόβλημα κατά την αποστολή. Το πρόβλημα που επιστράφηκε ήταν:<BR>".$mail->getMessage());
                } else {
                        //echo("<p>Message successfully sent!</p>");
                }
                TemplateEngine::get()->handle()->assign('referer', PageComposer::getReferer());
                TemplateEngine::get()->handle()->display('templates/modules/' . $_GET['module'] . '/SubmissionSuccess.tpl');
        }
}
?>