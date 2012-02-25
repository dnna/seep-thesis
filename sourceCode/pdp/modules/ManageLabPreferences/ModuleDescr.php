<?php
// Αυτό το module εμφανίζεται μόνο αν υπάρχουν μελλοντικές κληρώσεις.
if(count(DataHandler::get()->getLotteries('future')) > 0 && !DataHandler::get()->lotteryInProgress()) {
    $mDescr['MenuTitle'] = 'Δήλωση Προτιμήσεων';
    $mDescr['MenuURL'] = '?module=ManageLabPreferences&format=LabList';
    $mDescr['MenuSide'] = 'left';
    $mDescr['MenuWeight'] = 1;
}
$mDescr['Roles'][0] = 'student';
$mDescr['Descr'] = 'Όλες οι λειτουργίες που αφορούν τη δήλωση μαθημάτων';
?>