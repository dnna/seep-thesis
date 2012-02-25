<?php /* Smarty version Smarty-3.0.7, created on 2011-03-21 19:35:04
         compiled from "./templates/modules/ViewPersonalSchedule/ScheduleTable.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14602040144d878c48658e09-34713160%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd40bbe9b13da784d84e35803fe72c6a359278646' => 
    array (
      0 => './templates/modules/ViewPersonalSchedule/ScheduleTable.tpl',
      1 => 1300728901,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14602040144d878c48658e09-34713160',
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
<?php if ($_smarty_tpl->getVariable('semesterNum')->value!=null){?>
	<h3 class="subsectiontitle">Εξάμηνο <?php echo $_smarty_tpl->getVariable('semesterNum')->value;?>
</h3>
<?php }?>
	<TABLE class="prefTable">
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
			<TD style="padding: 4px 4px 4px 4px;">
			<?php  $_smarty_tpl->tpl_vars['entry'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['day']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['entry']->key => $_smarty_tpl->tpl_vars['entry']->value){
?>
				<?php if ($_smarty_tpl->getVariable('entry')->value->getcourseType()=='Θεωρία'){?>
					<div class="theory">
					<?php echo $_smarty_tpl->getVariable('entry')->value->getCourseName();?>
<BR>
					(<?php echo $_smarty_tpl->getVariable('entry')->value->getcourseType();?>
)
				<?php }else{ ?>
                                        <?php $_smarty_tpl->tpl_vars['combinedID'] = new Smarty_variable((($_smarty_tpl->getVariable('entry')->value->getcourseID()).('_')).($_smarty_tpl->getVariable('entry')->value->getlabID()), null, null);?>
					<div class="lab" style="background-color: <?php echo $_smarty_tpl->getVariable('entry')->value->getColor();?>
;">
					<?php echo $_smarty_tpl->getVariable('entry')->value->getCourseName();?>
<?php if ($_smarty_tpl->getVariable('entry')->value->getCourseName()!==$_smarty_tpl->getVariable('entry')->value->getLabName()){?><BR>(<?php echo $_smarty_tpl->getVariable('entry')->value->getLabName();?>
)<?php }?><BR>
                                        <div class="NonPrintable">(Εγγεγραμμένοι: <?php echo $_smarty_tpl->getVariable('entry')->value->getNumStudents();?>
/<?php echo $_smarty_tpl->getVariable('entry')->value->getMaxStudents();?>
)</div>
                                        <?php if ($_smarty_tpl->getVariable('entry')->value->isAllocatedToThis()==true){?>
						<div class="NonPrintable">(Κληρωμένο Εργαστήριο)</div>
						<div class="NonPrintable">(<a href="?module=ViewLotteryStatus&withdraw=<?php echo $_smarty_tpl->getVariable('entry')->value->getcourseID();?>
_<?php echo $_smarty_tpl->getVariable('entry')->value->getlabID();?>
"><span style="color:green;text-decoration: underline;">Αποχώρηση</span></a>)</div>
					<?php }else{ ?>
						<div class="NonPrintable">
                                                    <?php if (isset($_smarty_tpl->getVariable('currentPreferences',null,true,false)->value[$_smarty_tpl->getVariable('combinedID',null,true,false)->value])){?>
                                                            (Αρ. Προτίμησης <?php echo $_smarty_tpl->getVariable('currentPreferences')->value[$_smarty_tpl->getVariable('combinedID')->value];?>
)
                                                    <?php }else{ ?>
                                                            (<a href="?module=ManageLabPreferences&showLesson=<?php echo $_smarty_tpl->getVariable('entry')->value->getcourseID();?>
"><span style="color:darkred;text-decoration: underline;">Δεν έχει οριστεί προτίμηση</span></a>)
                                                    <?php }?>
                                                </div>
					<?php }?>
				<?php }?>
				</div>
			<?php }} ?>
			</TD>
		<?php }} ?>
		</TR>
	<?php }} ?>
	</TABLE>
</p>