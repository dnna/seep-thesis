<?php /* Smarty version Smarty-3.0.7, created on 2011-03-21 19:31:05
         compiled from "./templates/modules/ViewHourlySchedule/ViewHourlySchedule.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19750845824d878b599fb3d0-39535240%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '034eb5d66be11dcadb8baf0c42b49135d99c2e83' => 
    array (
      0 => './templates/modules/ViewHourlySchedule/ViewHourlySchedule.tpl',
      1 => 1300722797,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19750845824d878b599fb3d0-39535240',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<?php $_smarty_tpl->tpl_vars["pageTitle"] = new Smarty_variable("Ωρολόγιο Πρόγραμμα", null, null);?>
<?php $_template = new Smarty_Internal_Template("templates/header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<div id="leftcolumn" class="NonPrintable">
	<h2 class="sectiontitle">Εξάμηνα</h2> 
	<div>
		<div style='position:absolute;left:10%;width:80%'>
		<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['name'] = 'curChoice';
$_smarty_tpl->tpl_vars['smarty']->value['section']['curChoice']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('semesterChoices')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
			<?php if ($_smarty_tpl->getVariable('semesterChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curChoice']['index']]->isPicked()==true){?>
			<div class='curChoice'>
				<?php echo $_smarty_tpl->getVariable('semesterChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curChoice']['index']]->getName();?>

			<?php }else{ ?>
			<div class='<?php echo $_smarty_tpl->getVariable('semesterChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curChoice']['index']]->getColorClass();?>
' onclick="location.href='<?php echo $_smarty_tpl->getVariable('semesterChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curChoice']['index']]->getURL();?>
';" style="cursor: pointer;"
			onMouseOver="this.oldBackgroundColor=this.style.backgroundColor;this.style.backgroundColor='#FFFFFF';" onMouseOut="this.style.backgroundColor=this.oldBackgroundColor;">
				<a href=<?php echo $_smarty_tpl->getVariable('semesterChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curChoice']['index']]->getURL();?>
><?php echo $_smarty_tpl->getVariable('semesterChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curChoice']['index']]->getName();?>
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