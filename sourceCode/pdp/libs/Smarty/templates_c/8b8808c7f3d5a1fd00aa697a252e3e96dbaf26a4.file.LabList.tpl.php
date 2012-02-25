<?php /* Smarty version Smarty-3.0.7, created on 2011-03-23 13:27:25
         compiled from "./templates/modules/ManageLabPreferences/LabList.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21038845154d89d91de56930-16057684%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8b8808c7f3d5a1fd00aa697a252e3e96dbaf26a4' => 
    array (
      0 => './templates/modules/ManageLabPreferences/LabList.tpl',
      1 => 1300879639,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21038845154d89d91de56930-16057684',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<?php if ($_smarty_tpl->getVariable('pageBreak')->value==true){?>
	<p class="subsectioncontent" style="page-break-after: always;">
<?php }else{ ?>
	<p class="subsectioncontent">
<?php }?>
	<form action="?module=ManageLabPreferences&ProcessStatement" id="statementForm" method="POST" onsubmit="return confirm(this);">
	<div class="NonPrintable">
        <div class="note" style="display:none" id="selectionNote"><strong>Σημείωση:</strong> Μπορείτε να ταξινομήσετε πολλές στήλες ταυτόχρονα κρατώντας πατημένο το SHIFT.</div>
	<div id="noChoicesDivTop" class="warning" style="display:none;">Υπάρχουν μαθήματα, στην παρακάτω λίστα, στα οποία δεν έχετε επιλέξει καμία προτίμηση.</div>
	<div id="sameLabDivTop" class="invalid" style="display:none;">Έχετε ορίσει ίδια προτίμηση σε διαφορετικά τμήματα του ίδιου μαθήματος.</div>
	<div id="wrongOrderDivTop" class="invalid" style="display:none;">Οι προτιμήσεις των τμημάτων για κάθε μάθημα πρέπει να αυξάνονται με βήμα 1.</div>
	<div id="validStateDivTop" class="valid" style="display:none;">Οι τρέχουσες επιλογές σας είναι έγκυρες. Πιέστε το κουμπί "Καταχώρηση" για να τις αποθηκεύσετε.</div>
	<div id="javascriptOffDivTop" class="warning" style="display:block;">Για την καλύτερη λειτουργία αυτής της σελίδας προτείνεται η ενεργοποίηση του Javascript στον browser σας.</div>
	</div>
	<TABLE style="width:95%;height:95%" class="prefTable tablesorter" id="prefTable">
	<THEAD>
        <TR>
		<TH>Μάθημα</TH>
        <TH>Όνομα Τμήματος</TH>
        <TH>Ημέρα</TH>
        <TH>Ώρα</TH>
        <TH>Αριθμός Εγγεγραμένων Σπουδαστών</TH>
        <TH>Αριθμός Σπουδαστών που το έχουν δηλώσει σαν Πρώτη Προτίμηση</TH>
        <TH>Επιλογή Προτίμησης</TH>
        </TR>
	</THEAD>
	<TBODY>
	<?php  $_smarty_tpl->tpl_vars['entry'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['entryNum'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('schedule')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['entry']->key => $_smarty_tpl->tpl_vars['entry']->value){
 $_smarty_tpl->tpl_vars['entryNum']->value = $_smarty_tpl->tpl_vars['entry']->key;
?>
                <?php if ($_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getcourseType()=='Εργαστήριο'){?>
                <?php $_smarty_tpl->tpl_vars['combinedID'] = new Smarty_variable((($_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getcourseID()).('_')).($_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getlabID()), null, null);?>
                        <TR style="background-color: <?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getColor();?>
;">
                        <TD><?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getCourseName();?>
</TD>
                        <TD><?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getLabName();?>
</TD>
                        <TD><?php echo $_smarty_tpl->tpl_vars['entry']->value['day'];?>
</TD>
                        <TD><?php echo $_smarty_tpl->tpl_vars['entry']->value['time'];?>
</TD>
                        <TD><?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getNumStudents();?>
/<?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getMaxStudents();?>
</TD>
                        <TD><?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getFirstPriorityCount();?>
</TD>
                        <TD>
                        <?php if ($_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->isAllocatedToThis()==true){?>
                                <div class="theoryBackground">
                                        <div class="lab" style="background-color: <?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getColor();?>
;">
                                        <a href="?module=ViewLotteryStatus&withdraw=<?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getcourseID();?>
_<?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getlabID();?>
"><span style="color:green;text-decoration: underline;">Αποχώρηση</span></a>
                        <?php }else{ ?>
                                <div class="warningBackground" id="div_<?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getcourseID();?>
_<?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getlabID();?>
">
                                        <div class="lab" style="background-color: <?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getColor();?>
;">

                                        <select class="warning" name="pref_<?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getcourseID();?>
_<?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getlabID();?>
" id="pref_<?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getcourseID();?>
_<?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getlabID();?>
" onfocusin="chooseNextPrio(this); return true;" onfocus="chooseNextPrio(this); return true;" onchange="updateValidity(); return true;">
                                        <option value="none">Καμία</option>
                                        <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['name'] = 'curPref';
$_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['loop'] = is_array($_loop=8) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['curPref']['total']);
?>
                                                <?php if ($_smarty_tpl->getVariable('currentPreferences')->value[$_smarty_tpl->getVariable('combinedID')->value]==$_smarty_tpl->getVariable('smarty')->value['section']['curPref']['iteration']){?>
                                                        <?php $_smarty_tpl->tpl_vars['selected'] = new Smarty_variable(' selected="selected"', null, null);?>
												<?php }else{ ?>
														<?php $_smarty_tpl->tpl_vars['selected'] = new Smarty_variable('', null, null);?>
                                                <?php }?>
                                                <option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['curPref']['iteration'];?>
"<?php echo $_smarty_tpl->getVariable('selected')->value;?>
><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['curPref']['iteration'];?>
</option>
                                                <?php $_smarty_tpl->tpl_vars['selected'] = new Smarty_variable('', null, null);?>
                                        <?php endfor; endif; ?>
                                        </select>
                                <?php }?>
                <?php }?>
                                </div>
                        </div>
                </TD>
                </TR>
	<?php }} ?>
	</TBODY>
	</TABLE>
	<div>
		<p><input type="submit" class="NonPrintable" name="submitted" value="Καταχώρηση">
		<input type="reset" class="NonPrintable" value="Ακύρωση Αλλαγών" onclick="this.onkeypress();" onkeypress="resetUpdate(event); return true;">
                <?php if ($_GET['showLesson']==null){?>
                    <?php $_smarty_tpl->tpl_vars['onclickcontent'] = new Smarty_variable("alert('Πρέπει να επιλέξετε κάποιο εργαστηριακό μάθημα από την λίστα μαθημάτων, αριστερά, για να εγγραφείτε ως παλαιός σπουδαστής.');", null, null);?>
                <?php }else{ ?>
                    <?php $_smarty_tpl->tpl_vars['onclickcontent'] = new Smarty_variable((("window.location = '?module=ManageLabPreferences&showLesson=").($_GET['showLesson'])).("&format=OldStudent'"), null, null);?>
                <?php }?>
                <input type="button" class="NonPrintable" value="Εγγραφή ως Παλαιός Σπουδαστής" onclick="<?php echo $_smarty_tpl->getVariable('onclickcontent')->value;?>
" onkeypress="resetUpdate(event); return true;"></p>
	</div>
	</form>
</p>