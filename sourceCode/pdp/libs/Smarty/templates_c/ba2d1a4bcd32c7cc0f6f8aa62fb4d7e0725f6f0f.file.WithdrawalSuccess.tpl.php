<?php /* Smarty version Smarty-3.0.7, created on 2011-03-21 19:45:49
         compiled from "./templates/modules/ViewLotteryStatus/WithdrawalSuccess.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1240161884d878ecded4ea7-35122634%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ba2d1a4bcd32c7cc0f6f8aa62fb4d7e0725f6f0f' => 
    array (
      0 => './templates/modules/ViewLotteryStatus/WithdrawalSuccess.tpl',
      1 => 1300556296,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1240161884d878ecded4ea7-35122634',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<?php $_smarty_tpl->tpl_vars["pageTitle"] = new Smarty_variable("Επιτυχής Αποχώρηση", null, null);?>
<?php $_template = new Smarty_Internal_Template("templates/header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<div>
	<h2 class="sectiontitle"><?php echo $_smarty_tpl->getVariable('pageTitle')->value;?>
</h2> 
	<p class="sectioncontent">
		Αποχωρήσατε από το εργαστηριακό τμήμα με επιτυχία.
	</p>
	<p class="sectioncontent">
		<a href="?module=ViewLotteryStatus"><u>Αποτελέσματα Κληρώσεων</u></a>
	</p>
	<p class="sectioncontent">
		<a href="."><u>Αρχική Σελίδα</u></a>
	</p>
</div>

<?php $_template = new Smarty_Internal_Template("templates/footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>