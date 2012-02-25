<?php
/**
 * Δημιουργεί PDF με το προσωπικό ωρολόγιο πρόγραμμα του σπουδαστή. Για λόγους
 * απόδοσης χρησιμοποιεί cache το οποίο ανανενώνεται μετά από κάθε κλήρωση.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class PersonalSchedulePDF {
    /**
     * @var mixed Πίνακας με τις ηέρες και ώρες του προσωπικού ωρολίγιου
     * προγράμματος. Μπορεί να είναι περισσότεροι από ένας, σε περίπτωση που
     * το PDF απεικονίζει περισσότερα του ενός εξάμηνα.
     */
    protected $schedules;

    /**
     * @var int Ο αριθμός του εξαμήνου που παρατίθεται το συγκεκριμένο προσωπικό
     * ωρολόγιο πρόγραμμα.
     */
    protected $semester;

    /**
     * @var Array Τα στοιχεία της πιο πρόσφατης κλήρωσης. Χρησιμεύει για να
     * γίνονται συγκρίσεις με παλιότερες εκδόσεις του PDF.
     */
    protected $lastLottery;

    function __construct($schedules, $semester = 'all') {
        $this->schedules = $schedules;
        $this->semester = $semester;
        $this->lastLottery = DataHandler::get()->getLotteries('last');
        if(count($this->lastLottery) <= 0) {
            // Δημιουργία μιας εικονικής κλήρωσης για να την αποφυγή σφαλμάτων
            $this->lastLottery[0] = Array('lotID' => '-2', 'lotDate' => 'Δεν έχει πραγματοποιηθεί καμία κλήρωση.', 'lotExecuted' => '1');
        }
    }

    function createPDF($outputPath) {
        // Generate PDF
        TemplateEngine::get()->handle()->assign('schedules', $this->schedules);
        TemplateEngine::get()->handle()->assign('lastLotDate', $this->lastLottery[0]['lotDate']);
        $html = TemplateEngine::get()->handle()->fetch('templates/modules/ViewPersonalSchedule/PDFScheduleTable.tpl');

        require_once('libs/tcpdf/config/lang/eng.php');
        require_once('libs/tcpdf/tcpdf.php');
        $pdf = new TCPDF("P", "mm", "A4", true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('SEEP PDF Generator'); // Το LotteryID θα χρησιμοποιηθεί για συγκρίσεις στο cache.
        $pdf->SetTitle('Προσωπικό Ωρολόγιο Πρόγραμμα '.User::getUser()->getFirstName().' '.User::getUser()->getLastName());
        $pdf->SetSubject('Κλήρωση '.$this->lastLottery[0]['lotDate'].' lotID:'.$this->lastLottery[0]['lotID']);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setLanguageArray($l);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('dejavusans', '', 4, '', true);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, false, false, '');
        ob_end_clean();
        $pdf->Output($outputPath, 'F');
    }

    function run() {
        // Zend Framework
        set_include_path(get_include_path() . PATH_SEPARATOR . getcwd().'/libs/Zend/library');
        include('libs/Zend/library/Zend/Pdf.php');
        $pdfPath = 'GeneratedFiles/PersonalSchedule/personalSchedule_'.User::getUser()->getuserName().'.pdf';
        $pdfLotID = "-20"; // Κανένα υπάρχον PDF δεν πρέπει να έχει αυτό το lotID
        if(file_exists($pdfPath)) {
            $pdf = Zend_Pdf::load($pdfPath);
            $subject = iconv("UTF-16", "UTF-8", $pdf->properties['Subject']); // Για κάποιο λόγο το Zend_Pdf επιστρέφει την πληροφορία σε UTF-16
            $pdfLotID = substr($subject, strpos($subject, 'lotID:') + strlen('lotID:')); // Παίρνουμε το lotID από το subject του PDF για σύγκριση
        }
        // Αν οι ημερομηνίες της κλήρωσης διαφέρουν τότε δημιουργούμε νέο PDF
        if($this->lastLottery[0]['lotID'] !== $pdfLotID) {
            $this->createPDF($pdfPath);
        }
        header('Location: '.$pdfPath);
    }
}
?>
