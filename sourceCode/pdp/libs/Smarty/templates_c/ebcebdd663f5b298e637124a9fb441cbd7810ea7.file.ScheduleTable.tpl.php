<?php /* Smarty version Smarty-3.0.7, created on 2011-03-21 19:31:05
         compiled from "./templates/modules/ViewHourlySchedule/ScheduleTable.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4143445934d878b598e4b47-75417194%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ebcebdd663f5b298e637124a9fb441cbd7810ea7' => 
    array (
      0 => './templates/modules/ViewHourlySchedule/ScheduleTable.tpl',
      1 => 1300722516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4143445934d878b598e4b47-75417194',
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
	<TABLE width=95% height=95% class="prefTable">
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
)<BR>
				<?php }else{ ?>
                                    <div class="lab" style="background-color: <?php echo $_smarty_tpl->getVariable('entry')->value->getColor();?>
;">
                                    <?php echo $_smarty_tpl->getVariable('entry')->value->getCourseName();?>
<?php if ($_smarty_tpl->getVariable('entry')->value->getCourseName()!==$_smarty_tpl->getVariable('entry')->value->getLabName()){?><BR>
                                    (<?php echo $_smarty_tpl->getVariable('entry')->value->getLabName();?>
)<?php }?><BR>
				<?php }?>
                                <?php if ($_smarty_tpl->getVariable('entry')->value->getTeacherName()!=='-'){?>
                                    <span style="font-style:italic"><?php echo $_smarty_tpl->getVariable('entry')->value->getTeacherName();?>
</span><BR>
                                <?php }?>
				</div>
			<?php }} ?>
			</TD>
		<?php }} ?>
		</TR>
	<?php }} ?>
	</TABLE>
</p>