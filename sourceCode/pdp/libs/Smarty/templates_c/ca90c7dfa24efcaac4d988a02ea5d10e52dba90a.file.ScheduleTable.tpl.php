<?php /* Smarty version Smarty-3.0.7, created on 2011-03-23 13:28:18
         compiled from "./templates/modules/ManageLabPreferences/ScheduleTable.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16103556594d89d9525fc537-58455335%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ca90c7dfa24efcaac4d988a02ea5d10e52dba90a' => 
    array (
      0 => './templates/modules/ManageLabPreferences/ScheduleTable.tpl',
      1 => 1300879686,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16103556594d89d9525fc537-58455335',
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
	<div id="noChoicesDivTop" class="warning" style="display:none;">Υπάρχουν μαθήματα, στον παρακάτω πίνακα, στα οποία δεν έχετε επιλέξει καμία προτίμηση.</div>
	<div id="sameLabDivTop" class="invalid" style="display:none;">Έχετε ορίσει ίδια προτίμηση σε διαφορετικά τμήματα του ίδιου μαθήματος.</div>
	<div id="wrongOrderDivTop" class="invalid" style="display:none;">Οι προτιμήσεις των τμημάτων για κάθε μάθημα πρέπει να αυξάνονται με βήμα 1.</div>
	<div id="validStateDivTop" class="valid" style="display:none;">Οι τρέχουσες επιλογές σας είναι έγκυρες. Πιέστε το κουμπί "Καταχώρηση" για να τις αποθηκεύσετε.</div>
	<div id="javascriptOffDivTop" class="warning" style="display:block;">Για την καλύτερη λειτουργία αυτής της σελίδας προτείνεται η ενεργοποίηση του Javascript στον browser σας.</div>
	</div>
	<TABLE width=95% height=95% class="prefTable" id="prefTable">
	<TR><TH></TH>
	<?php  $_smarty_tpl->tpl_vars['day'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['dayName'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('days')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['day']->key => $_smarty_tpl->tpl_vars['day']->value){
 $_smarty_tpl->tpl_vars['dayName']->value = $_smarty_tpl->tpl_vars['day']->key;
?>
		<TH><?php echo $_smarty_tpl->tpl_vars['day']->value[1];?>
</TH>
	<?php }} ?>
	</TR>
	<?php  $_smarty_tpl->tpl_vars['hour'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['hourName'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('schedule')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['hour']->key => $_smarty_tpl->tpl_vars['hour']->value){
 $_smarty_tpl->tpl_vars['hourName']->value = $_smarty_tpl->tpl_vars['hour']->key;
?>
		<TR><TD class="hours"><?php echo $_smarty_tpl->tpl_vars['hourName']->value;?>
</TD>
		<?php  $_smarty_tpl->tpl_vars['day'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['dayName'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['hour']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['day']->key => $_smarty_tpl->tpl_vars['day']->value){
 $_smarty_tpl->tpl_vars['dayName']->value = $_smarty_tpl->tpl_vars['day']->key;
?>
			<TD>
			<?php  $_smarty_tpl->tpl_vars['entry'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['entryNum'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['day']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['entry']->key => $_smarty_tpl->tpl_vars['entry']->value){
 $_smarty_tpl->tpl_vars['entryNum']->value = $_smarty_tpl->tpl_vars['entry']->key;
?>
				<?php if ($_smarty_tpl->getVariable('entry')->value->getcourseType()=='Θεωρία'){?>
					<div class="theoryBackground">
						<div class="theory">
						<?php echo $_smarty_tpl->getVariable('entry')->value->getCourseName();?>
<BR>
						(<?php echo $_smarty_tpl->getVariable('entry')->value->getcourseType();?>
)
				<?php }else{ ?>
                                        <?php $_smarty_tpl->tpl_vars['combinedID'] = new Smarty_variable((($_smarty_tpl->getVariable('entry')->value->getcourseID()).('_')).($_smarty_tpl->getVariable('entry')->value->getlabID()), null, null);?>
					<?php if ($_smarty_tpl->getVariable('entry')->value->isAllocatedToThis()==true){?>
						<div class="theoryBackground">
						<div class="lab" style="background-color: <?php echo $_smarty_tpl->getVariable('entry')->value->getColor();?>
;">
						<?php echo $_smarty_tpl->getVariable('entry')->value->getCourseName();?>
<?php if ($_smarty_tpl->getVariable('entry')->value->getCourseName()!==$_smarty_tpl->getVariable('entry')->value->getLabName()){?><BR>(<?php echo $_smarty_tpl->getVariable('entry')->value->getLabName();?>
)<?php }?><BR>
                                                (Εγγεγραμμένοι: <?php echo $_smarty_tpl->getVariable('entry')->value->getNumStudents();?>
/<?php echo $_smarty_tpl->getVariable('entry')->value->getMaxStudents();?>
)<BR>
						(Κληρωμένο Εργαστήριο)<BR>
						(<a href="?module=ViewLotteryStatus&withdraw=<?php echo $_smarty_tpl->getVariable('entry')->value->getcourseID();?>
_<?php echo $_smarty_tpl->getVariable('entry')->value->getlabID();?>
"><span style="color:green;text-decoration: underline;">Αποχώρηση</span></a>)
					<?php }else{ ?>
						<div class="warningBackground" id="div_<?php echo $_smarty_tpl->getVariable('entry')->value->getcourseID();?>
_<?php echo $_smarty_tpl->getVariable('entry')->value->getlabID();?>
">
							<div class="lab" style="background-color: <?php echo $_smarty_tpl->getVariable('entry')->value->getColor();?>
;">
							<?php echo $_smarty_tpl->getVariable('entry')->value->getCourseName();?>
<?php if ($_smarty_tpl->getVariable('entry')->value->getCourseName()!==$_smarty_tpl->getVariable('entry')->value->getLabName()){?><BR>(<?php echo $_smarty_tpl->getVariable('entry')->value->getLabName();?>
)<?php }?><BR>
                                                        (Εγγεγραμμένοι: <?php echo $_smarty_tpl->getVariable('entry')->value->getNumStudents();?>
/<?php echo $_smarty_tpl->getVariable('entry')->value->getMaxStudents();?>
)<BR>
                                                        (Πρώτη Προτίμηση: <?php echo $_smarty_tpl->getVariable('entry')->value->getFirstPriorityCount();?>
)<BR>
							<select class="warning" name="pref_<?php echo $_smarty_tpl->getVariable('entry')->value->getcourseID();?>
_<?php echo $_smarty_tpl->getVariable('entry')->value->getlabID();?>
" id="pref_<?php echo $_smarty_tpl->getVariable('entry')->value->getcourseID();?>
_<?php echo $_smarty_tpl->getVariable('entry')->value->getlabID();?>
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
			<?php }} ?>
			</TD>
		<?php }} ?>
		</TR>
	<?php }} ?>
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