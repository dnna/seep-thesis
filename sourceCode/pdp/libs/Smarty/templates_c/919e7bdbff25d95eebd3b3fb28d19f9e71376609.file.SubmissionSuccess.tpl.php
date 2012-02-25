<?php /* Smarty version Smarty-3.0.7, created on 2011-03-30 16:51:52
         compiled from "./templates/modules/ManageRegistrationPriorities/SubmissionSuccess.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5364182104d933578ccdc51-08932420%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '919e7bdbff25d95eebd3b3fb28d19f9e71376609' => 
    array (
      0 => './templates/modules/ManageRegistrationPriorities/SubmissionSuccess.tpl',
      1 => 1287593672,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5364182104d933578ccdc51-08932420',
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
		Οι προτεραιότητες εγγραφής ενημερώθηκαν με επιτυχία.
	</p>
	<p class="sectioncontent">
		<a href="<?php echo $_smarty_tpl->getVariable('referer')->value;?>
"><u>Επιστροφή</u></a>
	</p>
</div>

<?php $_template = new Smarty_Internal_Template("templates/footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>