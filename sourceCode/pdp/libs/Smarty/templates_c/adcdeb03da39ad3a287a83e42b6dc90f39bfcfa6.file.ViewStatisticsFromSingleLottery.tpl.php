<?php /* Smarty version Smarty-3.0.7, created on 2011-03-26 23:35:34
         compiled from "./templates/modules/ViewStatistics/ViewStatisticsFromSingleLottery.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15723003564d8e5c26d50243-63201198%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'adcdeb03da39ad3a287a83e42b6dc90f39bfcfa6' => 
    array (
      0 => './templates/modules/ViewStatistics/ViewStatisticsFromSingleLottery.tpl',
      1 => 1301175331,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15723003564d8e5c26d50243-63201198',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_math')) include '/var/www/seep/libs/Smarty/plugins/function.math.php';
?>

<div>
        Ποσοστά εγγραφών ανά προτίμηση:<BR>
        <TABLE width=95% height=95% class="prefTable tablesorter" id="preferenceBreakdownTable">
            <THEAD><TR><TH>Προτίμηση</TH><TH>Επιτυχείς Εγγραφές</TH><TH>Ανεπιτυχείς Εγγραφές</TH><TH>Σύνολο</TH></TR></THEAD>
            <TBODY>
            <?php  $_smarty_tpl->tpl_vars['curPreference'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['curPreferenceNum'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('preferenceBreakdown')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['curPreference']->key => $_smarty_tpl->tpl_vars['curPreference']->value){
 $_smarty_tpl->tpl_vars['curPreferenceNum']->value = $_smarty_tpl->tpl_vars['curPreference']->key;
?>
                <?php if ($_smarty_tpl->tpl_vars['curPreference']->value['totalRegistrations']>0){?>
                    <TR>
                        <TD class="hours"><?php echo $_smarty_tpl->tpl_vars['curPreferenceNum']->value;?>
</TD>
                        <TD class="valid"><?php echo $_smarty_tpl->tpl_vars['curPreference']->value['successfulRegistrations'];?>
 (<?php echo smarty_function_math(array('equation'=>"x/t*100",'t'=>$_smarty_tpl->tpl_vars['curPreference']->value['totalRegistrations'],'x'=>$_smarty_tpl->tpl_vars['curPreference']->value['successfulRegistrations'],'format'=>"%.1f"),$_smarty_tpl);?>
%)</TD>
                        <TD class="invalid"><?php echo $_smarty_tpl->tpl_vars['curPreference']->value['failedRegistrations'];?>
 (<?php echo smarty_function_math(array('equation'=>"x/t*100",'t'=>$_smarty_tpl->tpl_vars['curPreference']->value['totalRegistrations'],'x'=>$_smarty_tpl->tpl_vars['curPreference']->value['failedRegistrations'],'format'=>"%.1f"),$_smarty_tpl);?>
%)</TD>
                        <TD class="warning"><?php echo $_smarty_tpl->tpl_vars['curPreference']->value['totalRegistrations'];?>
</TD>
                    </TR>
                <?php }?>
            <?php }} ?>
            </TBODY>
        </TABLE>
        <p></p>
        Σπουδαστές που δεν γράφτηκαν σε κανένα τμημα, εμφάνιση κατά μάθημα:<BR>
        <TABLE width=95% height=95% class="prefTable tablesorter" id="failedCourseBreakdownTable">
            <THEAD><TR><TH>Μάθημα</TH><TH>Σπουδαστές</TH></TR></THEAD>
            <TBODY>
            <?php  $_smarty_tpl->tpl_vars['curCourse'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['curCourseID'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('failedCourseBreakdown')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['curCourse']->key => $_smarty_tpl->tpl_vars['curCourse']->value){
 $_smarty_tpl->tpl_vars['curCourseID']->value = $_smarty_tpl->tpl_vars['curCourse']->key;
?>
                <?php if ($_smarty_tpl->tpl_vars['curCourse']->value['failedRegistrations']>0){?>
                    <TR style="height:35px">
                        <TD class="hours" style="width:15%">
                            <?php echo $_smarty_tpl->tpl_vars['curCourse']->value['courseName'];?>

                        </TD>
                        <TD class="invalid">
                            <?php echo $_smarty_tpl->tpl_vars['curCourse']->value['failedRegistrations'];?>
<BR>
                            (<a href="?module=ViewStatistics&displayFailedRegistrationStudents=<?php echo $_smarty_tpl->tpl_vars['curCourseID']->value;?>
&showLottery=<?php echo $_smarty_tpl->getVariable('curLotteryID')->value;?>
" onClick="return popup(this, 'failedRegistrationStudents')"><span style="text-decoration: underline">Εμφάνιση</span></a>)
                        </TD>
                    </TR>
                <?php }?>
            <?php }} ?>
            </TBODY>
        </TABLE>
        <span class="note">* Οι σπουδαστές που δεν είχαν ορίσει καμία προτιμήση δεν προσμετρώνται στον παραπάνω πίνακα.</span>
        <p></p>
        Ποσοστά εγγραφών ανά μάθημα:<BR>
        <?php if (isset($_GET['showCourseBreakdown'])){?>
            <a href="?module=ViewStatistics&showLottery=<?php echo $_smarty_tpl->getVariable('curLotteryID')->value;?>
#hideSidebar">Απόκρυψη</a>
            <?php $_template = new Smarty_Internal_Template("templates/modules/ViewStatistics/CourseBreakdown.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
        <?php }else{ ?>
            <div class="warning">Το στατιστικό αυτό ενδέχεται να περιέχει μεγάλο αριθμό γραμμών και έχει αποκρυφθεί.<BR>
            Εαν θέλετε να το εμφανίσετε επιλέξτε τον παρακάτω σύνδεσμο.</div>
            <a href="?module=ViewStatistics&showCourseBreakdown&showLottery=<?php echo $_smarty_tpl->getVariable('curLotteryID')->value;?>
#hideSidebar">Εμφάνιση</a>
        <?php }?>
        <p></p>
</div>