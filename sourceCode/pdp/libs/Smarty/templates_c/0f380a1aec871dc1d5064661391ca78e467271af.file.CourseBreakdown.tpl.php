<?php /* Smarty version Smarty-3.0.7, created on 2011-03-26 23:25:23
         compiled from "./templates/modules/ViewStatistics/CourseBreakdown.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16816309504d8e59c38ff3f2-25785649%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0f380a1aec871dc1d5064661391ca78e467271af' => 
    array (
      0 => './templates/modules/ViewStatistics/CourseBreakdown.tpl',
      1 => 1301174717,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16816309504d8e59c38ff3f2-25785649',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_math')) include '/var/www/seep/libs/Smarty/plugins/function.math.php';
?>

<TABLE width=95% height=95% class="prefTable tablesorter" id="courseBreakdownTable">
    <THEAD><TR><TH>Εργαστηριακο Τμήμα</TH><TH>Επιτυχείς Εγγραφές</TH><TH>Ανεπιτυχείς Εγγραφές</TH><TH>Σύνολο</TH></TR></THEAD>
    <TBODY>
    <?php  $_smarty_tpl->tpl_vars['curCourse'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['curCourseID'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('courseBreakdown')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['curCourse']->key => $_smarty_tpl->tpl_vars['curCourse']->value){
 $_smarty_tpl->tpl_vars['curCourseID']->value = $_smarty_tpl->tpl_vars['curCourse']->key;
?>
        <?php $_smarty_tpl->tpl_vars['totalRegistrations'] = new Smarty_variable($_smarty_tpl->tpl_vars['curCourse']->value['successfulRegistrations']+$_smarty_tpl->tpl_vars['curCourse']->value['failedRegistrations'], null, null);?>
        <TR style="height:35px">
            <TD class="hours" style="width:15%">
                <a href="?module=ViewStatistics&displayLabBreakdown=<?php echo $_smarty_tpl->tpl_vars['curCourse']->value['courseID'];?>
&showLottery=<?php echo $_smarty_tpl->getVariable('curLotteryID')->value;?>
" onClick="return labBreakdownPopup(this, 'labBreakdown')"><span style="text-decoration: underline"><?php echo $_smarty_tpl->tpl_vars['curCourse']->value['courseName'];?>
</span></a>
            </TD>
            <TD class="valid"><?php echo $_smarty_tpl->tpl_vars['curCourse']->value['successfulRegistrations'];?>
 (<?php echo smarty_function_math(array('equation'=>"x/t*100",'t'=>$_smarty_tpl->getVariable('totalRegistrations')->value,'x'=>$_smarty_tpl->tpl_vars['curCourse']->value['successfulRegistrations'],'format'=>"%.1f"),$_smarty_tpl);?>
%)</TD>
            <TD class="invalid"><?php echo $_smarty_tpl->tpl_vars['curCourse']->value['failedRegistrations'];?>
 (<?php echo smarty_function_math(array('equation'=>"x/t*100",'t'=>$_smarty_tpl->getVariable('totalRegistrations')->value,'x'=>$_smarty_tpl->tpl_vars['curCourse']->value['failedRegistrations'],'format'=>"%.1f"),$_smarty_tpl);?>
%)</TD>
            <TD class="warning"><?php echo $_smarty_tpl->getVariable('totalRegistrations')->value;?>
</TD>
        </TR>
    <?php }} ?>
    </TBODY>
</TABLE>