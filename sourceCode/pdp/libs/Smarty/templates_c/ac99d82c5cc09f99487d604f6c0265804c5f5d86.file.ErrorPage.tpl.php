<?php /* Smarty version Smarty-3.0.7, created on 2011-03-21 19:30:53
         compiled from "./templates/ErrorPage.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4277665664d878b4de160b8-21743866%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ac99d82c5cc09f99487d604f6c0265804c5f5d86' => 
    array (
      0 => './templates/ErrorPage.tpl',
      1 => 1287694584,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4277665664d878b4de160b8-21743866',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<?php $_template = new Smarty_Internal_Template("templates/header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<div>
	<h2 class="sectiontitle"><?php echo $_smarty_tpl->getVariable('pageTitle')->value;?>
</h2> 
	<p class="sectioncontent">
		Περιγραφή Σφάλματος:<BR><?php echo $_smarty_tpl->getVariable('exceptionDescription')->value;?>

	</p>
	<?php if ($_smarty_tpl->getVariable('referer')->value!=''&&$_smarty_tpl->getVariable('referer')->value!==$_smarty_tpl->getVariable('request_uri')->value){?>
		<p class="sectioncontent">
			<a href="<?php echo $_smarty_tpl->getVariable('referer')->value;?>
"><u>Επιστροφή</u></a>
		</p>
	<?php }?>
	<p class="sectioncontent">
		<a href="."><u>Αρχική Σελίδα</u></a>
	</p>
</div>

<?php $_template = new Smarty_Internal_Template("templates/footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>