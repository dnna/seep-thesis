<?php /* Smarty version Smarty-3.0.7, created on 2011-03-31 14:55:59
         compiled from "./templates/modules/Feedback/SubmissionSuccess.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12813383664d946bcfdec3f7-15937071%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eae4a6fb034663e3a544fd6264d113e81cbf89e7' => 
    array (
      0 => './templates/modules/Feedback/SubmissionSuccess.tpl',
      1 => 1300627878,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12813383664d946bcfdec3f7-15937071',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<?php $_smarty_tpl->tpl_vars["pageTitle"] = new Smarty_variable("Επιτυχής Αποστολή", null, null);?>
<?php $_template = new Smarty_Internal_Template("templates/header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<div>
	<h2 class="sectiontitle"><?php echo $_smarty_tpl->getVariable('pageTitle')->value;?>
</h2> 
	<p class="sectioncontent">
		Τα σχόλια σας καταχωρήθηκαν με επιτυχία.
	</p>
	<p class="sectioncontent">
		<a href="<?php echo $_smarty_tpl->getVariable('referer')->value;?>
"><u>Επιστροφή</u></a>
	</p>
</div>

<?php $_template = new Smarty_Internal_Template("templates/footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>