<?php
include("modules/ViewLotteryStatus/ViewLotteryStatus.php"); // Για να έχουμε διαθέσιμη την κλάση LotteryChoice και ViewLotteryStatus

/**
 * Εμφανίζει την αρχική σελίδα.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class ViewStatistics implements IModule {

    function displayFailedRegistrationStudents($courseID, $lotID) {
        TemplateEngine::get()->handle()->assign('students', DataHandler::get()->getFailedCourseStudent($lotID, $courseID));
        TemplateEngine::get()->handle()->display('templates/modules/' . $_GET['module'] . '/FailedRegistrationStudents.tpl');
    }

    function displayLabBreakdown($courseID, $lotID) {
        TemplateEngine::get()->handle()->assign('labBreakdown', DataHandler::get()->getLabBreakdownTable($lotID, $courseID));
        TemplateEngine::get()->handle()->display('templates/modules/' . $_GET['module'] . '/LabBreakdown.tpl');
    }

    function displayStatistics($lotID) {
        global $_GET;
        TemplateEngine::get()->handle()->assign('preferenceBreakdown', DataHandler::get()->getPreferenceBreakdownTable($lotID));
        TemplateEngine::get()->handle()->assign('failedCourseBreakdown', DataHandler::get()->getFailedCourseBreakdownTable($lotID));
        if(isset($_GET['showCourseBreakdown'])) {
            TemplateEngine::get()->handle()->assign('courseBreakdown', DataHandler::get()->getCourseBreakdownTable($lotID));
        }
        return TemplateEngine::get()->handle()->fetch('templates/modules/' . $_GET['module'] . '/ViewStatisticsFromSingleLottery.tpl');
    }

    /**
     * Η κύρια συνάρτηση που θα τρέξει όταν το module φορτωθεί.
     */
    function run() {
        global $_GET;
        if(isset($_GET['showLottery'])) {
            $curLottery = $_GET['showLottery'];
        } else {
            $curLottery = DataHandler::get()->getLatestLotID();
        }
        if(isset($_GET['displayFailedRegistrationStudents'])) {
            $this->displayFailedRegistrationStudents($_GET['displayFailedRegistrationStudents'], $curLottery);
        } else if(isset($_GET['displayLabBreakdown'])) {
            $this->displayLabBreakdown($_GET['displayLabBreakdown'], $curLottery);
        } else {
            $lotStatusClass = new ViewLotteryStatus();
            TemplateEngine::get()->handle()->assign('completedLotteryChoices', array_merge($lotStatusClass->getLotteryChoices('last'), $lotStatusClass->getLotteryChoices('completed')));
            TemplateEngine::get()->handle()->assign('head', TemplateEngine::get()->handle()->fetch('templates/modules/' . $_GET['module'] . '/Head.tpl'));
            $curLotteryInfo = DataHandler::get()->getLotteries('completed', $curLottery);
            TemplateEngine::get()->handle()->assign('curLottery', $curLotteryInfo);
            if(count($curLotteryInfo) > 0) {
                TemplateEngine::get()->handle()->assign('curLotteryID', $curLotteryInfo[0]['lotID']);
            }
            TemplateEngine::get()->handle()->assign('lotteryChoices', $lotStatusClass->getLotteryChoices('last'));
            TemplateEngine::get()->handle()->assign('curStatistics', $this->displayStatistics($curLottery));
            TemplateEngine::get()->handle()->display('templates/modules/' . $_GET['module'] . '/' . $_GET['module'] . '.tpl');
        }
    }

}

?>