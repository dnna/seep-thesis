<?php /* Smarty version Smarty-3.0.7, created on 2011-03-21 19:43:13
         compiled from "./templates/modules/ManageLabPreferences/SubmissionSuccess.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2474579294d878e311d80b6-39100251%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c69391ef1391efb13d33830dd77fbc5c208ca2bd' => 
    array (
      0 => './templates/modules/ManageLabPreferences/SubmissionSuccess.tpl',
      1 => 1281812153,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2474579294d878e311d80b6-39100251',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<?php $_smarty_tpl->tpl_vars["pageTitle"] = new Smarty_variable("Επιτυχής Δήλωση", null, null);?>
<?php $_template = new Smarty_Internal_Template("templates/header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<div>
	<h2 class="sectiontitle"><?php echo $_smarty_tpl->getVariable('pageTitle')->value;?>
</h2> 
	<p class="sectioncontent">
		Η δήλωση σας καταχωρήθηκε με επιτυχία.
	</p>
	<p class="sectioncontent">
		<a href="<?php echo $_smarty_tpl->getVariable('referer')->value;?>
"><u>Επιστροφή</u></a>
	</p>
</div>

<?php $_template = new Smarty_Internal_Template("templates/footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>