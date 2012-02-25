<?php /* Smarty version Smarty-3.0.7, created on 2011-03-21 19:43:14
         compiled from "./templates/modules/ManageLabPreferences/OldStudentAlreadyRegistered.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11602536964d878e32846da2-36614500%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6e73264b6df0a8e7c8a92a6fc48c08a3fe7eecba' => 
    array (
      0 => './templates/modules/ManageLabPreferences/OldStudentAlreadyRegistered.tpl',
      1 => 1300555703,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11602536964d878e32846da2-36614500',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<span style="font-weight: bold">Εγγραφή Παλαιού Σπουδαστή</span>
<p>Έχετε εγγραφεί στο τμήμα παλαιών σπουδαστών του παρακάτω μαθήματος:</p>
<TABLE width=95% class="prefTable" id="prefTable">
    <TR><TD><?php echo $_smarty_tpl->getVariable('lessonInfo')->value['courseName'];?>
</TD></TR>
</TABLE>
<p>Εαν θέλετε να αποχωρήσετε χρησιμοποιήστε στον παρακάτω σύνδεσμο:<BR>
<a href="?module=ViewLotteryStatus&withdraw=<?php echo $_smarty_tpl->getVariable('lessonInfo')->value['courseID'];?>
_OLDSTUDENT"><span style="text-decoration: underline;">Αποχώρηση</span></a>