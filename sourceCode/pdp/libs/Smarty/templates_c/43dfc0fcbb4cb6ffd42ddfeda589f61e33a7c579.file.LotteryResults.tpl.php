<?php /* Smarty version Smarty-3.0.7, created on 2011-03-21 19:35:24
         compiled from "./templates/modules/ViewLotteryStatus/LotteryResults.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14909756524d878c5cc70534-75126636%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '43dfc0fcbb4cb6ffd42ddfeda589f61e33a7c579' => 
    array (
      0 => './templates/modules/ViewLotteryStatus/LotteryResults.tpl',
      1 => 1300035862,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14909756524d878c5cc70534-75126636',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<form method="POST" action="?module=ViewLotteryStatus&withdraw">
        <span style="font-weight:bold">Επιτυχείς Εγγραφές</span>
	<TABLE class="prefTable" id="prefTable">
	<TR><TH>Μάθημα</TH><TH>Τμήμα</TH><TH>Ημέρα</TH><TH>Ώρα</TH><TH>Αποτέλεσμα</TH><TH>Ενέργεια</TH></TR>
	<?php  $_smarty_tpl->tpl_vars['allotedLab'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('allocatedLabs')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['allotedLab']->key => $_smarty_tpl->tpl_vars['allotedLab']->value){
?>
	<TR class="valid">
	<TD><?php echo $_smarty_tpl->tpl_vars['allotedLab']->value['courseName'];?>
</TD>
	<TD><?php echo $_smarty_tpl->tpl_vars['allotedLab']->value['labName'];?>
</TD>
	<TD><?php echo $_smarty_tpl->tpl_vars['allotedLab']->value['dayName'];?>
</TD>
	<TD><?php echo $_smarty_tpl->tpl_vars['allotedLab']->value['ttime'];?>
</TD>
	<TD><span style="color:darkgreen">√</span></TD>
        <TD><a href="?module=ViewLotteryStatus&withdraw=<?php echo $_smarty_tpl->tpl_vars['allotedLab']->value['courseID'];?>
_<?php echo $_smarty_tpl->tpl_vars['allotedLab']->value['labID'];?>
"><span style="text-decoration: underline;">Αποχώρηση</span></a></TD>
	</TR>
	<?php }} ?>
        </TABLE>
        <BR>
        <span style="font-weight:bold">Αποτυχία Εγγραφής σε Εργαστηριακά Μαθήματα</span>
        <TABLE class="prefTable" id="prefTable">
        <TR><TH>Μάθημα</TH></TR>
	<?php  $_smarty_tpl->tpl_vars['failedRegistrationCourse'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('failedRegistrationsCourses')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['failedRegistrationCourse']->key => $_smarty_tpl->tpl_vars['failedRegistrationCourse']->value){
?>
	<TR class="invalid">
	<TD><?php echo $_smarty_tpl->tpl_vars['failedRegistrationCourse']->value['courseName'];?>
</TD>
	</TR>
	<?php }} ?>
	</TABLE>
        <BR>
        <span style="font-weight:bold">Μη-Επιτυχείς Εγγραφές σε Τμήματα Υψηλότερης Προτεραιότητας</span>
        <TABLE class="prefTable" id="prefTable">
        <TR><TH>Μάθημα</TH><TH>Τμήμα</TH><TH>Ημέρα</TH><TH>Ώρα</TH><TH>Λόγος Αποτυχίας</TH></TR>
	<?php  $_smarty_tpl->tpl_vars['failedRegistrationLab'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('failedRegistrationsLabs')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['failedRegistrationLab']->key => $_smarty_tpl->tpl_vars['failedRegistrationLab']->value){
?>
	<TR class="invalid">
	<TD><?php echo $_smarty_tpl->tpl_vars['failedRegistrationLab']->value['courseName'];?>
</TD>
	<TD><?php echo $_smarty_tpl->tpl_vars['failedRegistrationLab']->value['labName'];?>
</TD>
	<TD><?php echo $_smarty_tpl->tpl_vars['failedRegistrationLab']->value['dayName'];?>
</TD>
	<TD><?php echo $_smarty_tpl->tpl_vars['failedRegistrationLab']->value['ttime'];?>
</TD>
	<TD><?php echo $_smarty_tpl->tpl_vars['failedRegistrationLab']->value['failReason'];?>
</TD>
	</TR>
	<?php }} ?>
	</TABLE>
</form>