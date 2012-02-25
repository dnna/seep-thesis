<?php /* Smarty version Smarty-3.0.7, created on 2011-03-21 19:43:12
         compiled from "./templates/modules/ManageLabPreferences/OldStudentReg.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19149389924d878e302d9344-13883001%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c3ab1affdffd7ac7b9cfe1f51a364c9da65e04de' => 
    array (
      0 => './templates/modules/ManageLabPreferences/OldStudentReg.tpl',
      1 => 1299951270,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19149389924d878e302d9344-13883001',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<span style="font-weight: bold">Εγγραφή Παλαιού Σπουδαστή</span>
<p>Πρόκειται να εγγραφείτε στο τμήμα παλαιών σπουδαστών του παρακάτω μαθήματος:</p>
<TABLE width=95% class="prefTable" id="prefTable">
    <TR><TD><?php echo $_smarty_tpl->getVariable('lessonInfo')->value['courseName'];?>
</TD></TR>
</TABLE>
<p>Για να συνεχίσετε πατήστε στο παρακάτω κουμπί:<BR>
<form action="?module=ManageLabPreferences&ProcessStatement&OldStudent" id="statementForm" method="POST">
		<input type="hidden" name="courseID" value="<?php echo $_smarty_tpl->getVariable('lessonInfo')->value['courseID'];?>
">
		<input type="submit" class="NonPrintable" name="submitted" value="Εγγραφή">
</form>
</p>