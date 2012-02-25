<?php /* Smarty version Smarty-3.0.7, created on 2011-03-28 00:12:27
         compiled from "./templates/modules/ManageLabParameters/ManageLabParameters.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6214713304d8fa83bbf7e33-85194546%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4f301fcdd406b8605268e935718d0da0e8e23a7c' => 
    array (
      0 => './templates/modules/ManageLabParameters/ManageLabParameters.tpl',
      1 => 1301260344,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6214713304d8fa83bbf7e33-85194546',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<?php $_smarty_tpl->tpl_vars["pageTitle"] = new Smarty_variable("Εμφάνιση Κληρωθέντων Σπουδαστών", null, null);?>
<?php $_template = new Smarty_Internal_Template("templates/header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<div id="leftcolumn" class="NonPrintable">
	<div>
		<h2 class="sectiontitle">Λίστα Εργαστηριακών Τμημάτων ανά Μάθημα</h2> 
		<div style='position:relative;left:10%;width:80%'>
		<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['name'] = 'curChoice';
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('lessonChoices')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['total']);
?>
			<?php if ($_smarty_tpl->getVariable('lessonChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curChoice']['index']]->isPicked()==true&&$_smarty_tpl->getVariable('format')->value==="LabList"){?>
			<div class='curChoice'>
				<?php echo $_smarty_tpl->getVariable('lessonChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curChoice']['index']]->getName();?>

			<?php }else{ ?>
			<div class='<?php echo $_smarty_tpl->getVariable('lessonChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curChoice']['index']]->getColorClass();?>
' onclick="location.href='<?php echo $_smarty_tpl->getVariable('lessonChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curChoice']['index']]->getURL();?>
&format=LabList';" style="cursor: pointer;"
			onMouseOver="this.oldBackgroundColor=this.style.backgroundColor;this.style.backgroundColor='#FFFFFF';" onMouseOut="this.style.backgroundColor=this.oldBackgroundColor;">
				<a href=<?php echo $_smarty_tpl->getVariable('lessonChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curChoice']['index']]->getURL();?>
&format=LabList><?php echo $_smarty_tpl->getVariable('lessonChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curChoice']['index']]->getName();?>
</a>
			<?php }?>
			</div>
		<?php endfor; endif; ?>
		</div>
	</div>
	<div>
		<h2 class="sectiontitle">Πίνακας Εργαστηριακών Τμημάτων ανά Μάθημα</h2> 
		<div style='position:relative;left:10%;width:80%'>
		<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['name'] = 'curChoice';
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('lessonChoices')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['total']);
?>
			<?php if ($_smarty_tpl->getVariable('lessonChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curChoice']['index']]->isPicked()==true&&($_smarty_tpl->getVariable('format')->value==null||$_smarty_tpl->getVariable('format')->value!=="LabList")){?>
			<div class='curChoice'>
				<?php echo $_smarty_tpl->getVariable('lessonChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curChoice']['index']]->getName();?>

			<?php }else{ ?>
			<div class='<?php echo $_smarty_tpl->getVariable('lessonChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curChoice']['index']]->getColorClass();?>
' onclick="location.href='<?php echo $_smarty_tpl->getVariable('lessonChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curChoice']['index']]->getURL();?>
';" style="cursor: pointer;"
			onMouseOver="this.oldBackgroundColor=this.style.backgroundColor;this.style.backgroundColor='#FFFFFF';" onMouseOut="this.style.backgroundColor=this.oldBackgroundColor;">
				<a href=<?php echo $_smarty_tpl->getVariable('lessonChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curChoice']['index']]->getURL();?>
><?php echo $_smarty_tpl->getVariable('lessonChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curChoice']['index']]->getName();?>
</a>
			<?php }?>
			</div>
		<?php endfor; endif; ?>
		</div>
	</div>
</div>
<a href="#" style="display:none" id="separator" onclick="toggleSidebar();"></a>
<div id="rightcolumn" style="min-height:400px">
	<h2 class="sectiontitle"><?php echo $_smarty_tpl->getVariable('pageTitle')->value;?>
</h2>
        <p><a href="?module=<?php echo $_smarty_tpl->getVariable('curModule')->value;?>
&displayOldStudents=<?php echo $_smarty_tpl->getVariable('courseID')->value;?>
" onClick="return popup(this, 'regStudents')">Εμφάνιση Παλαιών Σπουδαστών</a></p>
		<?php  $_smarty_tpl->tpl_vars['schedule'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('schedules')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['schedule']->key => $_smarty_tpl->tpl_vars['schedule']->value){
?>
			<?php echo $_smarty_tpl->tpl_vars['schedule']->value;?>

		<?php }} ?>
	<p class="subsectioncontent"></p>
</div>

<?php $_template = new Smarty_Internal_Template("templates/footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>