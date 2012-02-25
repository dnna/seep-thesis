<?php /* Smarty version Smarty-3.0.7, created on 2011-03-23 13:52:00
         compiled from "./templates/modules/ManageLotteries/SubmissionSuccess.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14161934724d89dee0e2f1f9-67090634%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bf2f9c0f566da5e2dc9142c5353501dc32de5592' => 
    array (
      0 => './templates/modules/ManageLotteries/SubmissionSuccess.tpl',
      1 => 1287593680,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14161934724d89dee0e2f1f9-67090634',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<?php $_smarty_tpl->tpl_vars["pageTitle"] = new Smarty_variable("Επιτυχής Επεξεργασία", null, null);?>
<?php $_template = new Smarty_Internal_Template("templates/header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<div>
	<h2 class="sectiontitle"><?php echo $_smarty_tpl->getVariable('pageTitle')->value;?>
</h2> 
	<p class="sectioncontent">
		Οι κληρώσεις ενημερώθηκαν με επιτυχία.
	</p>
	<p class="sectioncontent">
		<a href="<?php echo $_smarty_tpl->getVariable('referer')->value;?>
"><u>Επιστροφή</u></a>
	</p>
</div>

<?php $_template = new Smarty_Internal_Template("templates/footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>