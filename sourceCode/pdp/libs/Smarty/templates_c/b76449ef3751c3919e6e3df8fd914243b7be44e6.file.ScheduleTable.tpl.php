<?php /* Smarty version Smarty-3.0.7, created on 2011-04-06 22:24:14
         compiled from "./templates/modules/ManageLabParameters/ScheduleTable.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14509381614d9cbddec0aa02-76404417%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b76449ef3751c3919e6e3df8fd914243b7be44e6' => 
    array (
      0 => './templates/modules/ManageLabParameters/ScheduleTable.tpl',
      1 => 1302117849,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14509381614d9cbddec0aa02-76404417',
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
                                    <?php $_smarty_tpl->tpl_vars['labID'] = new Smarty_variable($_smarty_tpl->getVariable('entry')->value->getlabID(), null, null);?>
                                    <?php $_smarty_tpl->tpl_vars['selectedTeacherID'] = new Smarty_variable($_smarty_tpl->getVariable('entry')->value->getTeacherID(), null, null);?>
                                            <div class="warningBackground" id="div_<?php echo $_smarty_tpl->getVariable('entry')->value->getcourseID();?>
_<?php echo $_smarty_tpl->getVariable('entry')->value->getlabID();?>
">
                                                    <div class="lab" style="background-color: <?php echo $_smarty_tpl->getVariable('entry')->value->getColor();?>
;">
                                                    Μάθημα:<?php echo $_smarty_tpl->getVariable('entry')->value->getCourseName();?>
<BR>
                                                    Όνομα: <?php echo $_smarty_tpl->getVariable('entry')->value->getLabName();?>
<BR>
                                                    Μέγεθος: <?php echo $_smarty_tpl->getVariable('entry')->value->getMaxStudents();?>
<BR>
                                                    (Πρώτη Προτίμηση: <?php echo $_smarty_tpl->getVariable('entry')->value->getFirstPriorityCount();?>
)<BR>
                                                    <span style="font-style:italic"><?php echo $_smarty_tpl->getVariable('entry')->value->getTeacherName();?>
</span><BR>
                                                    Έχουν Κληρωθεί: <?php echo $_smarty_tpl->getVariable('entry')->value->getNumStudents();?>
<BR>(<a href="?module=<?php echo $_smarty_tpl->getVariable('curModule')->value;?>
&displayRegisteredStudents=<?php echo (($_smarty_tpl->getVariable('entry')->value->getcourseID()).('_')).($_smarty_tpl->getVariable('entry')->value->getlabID());?>
" onClick="return popup(this, 'regStudents')">Εμφάνιση</a>)<BR>
				<?php }?>
						</div>
					</div>
			<?php }} ?>
			</TD>
		<?php }} ?>
		</TR>
	<?php }} ?>
	</TABLE>
</p>