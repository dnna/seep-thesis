<?php /* Smarty version Smarty-3.0.7, created on 2011-03-21 19:45:09
         compiled from "./templates/modules/ViewLotteryStatus/WithdrawalConfirmation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15979079294d878ea52e77b8-53457472%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '195475b5477f274525a0af44c4ecf8b4b0ef540f' => 
    array (
      0 => './templates/modules/ViewLotteryStatus/WithdrawalConfirmation.tpl',
      1 => 1300556231,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15979079294d878ea52e77b8-53457472',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<?php $_smarty_tpl->tpl_vars["pageTitle"] = new Smarty_variable("Επιβεβαίωση Αποχώρησης", null, null);?>
<?php $_template = new Smarty_Internal_Template("templates/header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<div>
	<h2 class="sectiontitle">Θέλετε σίγουρα να αποχωρήσετε από το συγκεκριμένο τμήμα;</h2>
	<BR>
	<TABLE class="prefTable" id="prefTable" style="width:50%">
	<TR>
        <TD><?php echo $_smarty_tpl->getVariable('labInfo')->value['courseName'];?>
</TD>
	<TD><?php echo $_smarty_tpl->getVariable('labInfo')->value['labName'];?>
</TD>
        <?php if ($_smarty_tpl->getVariable('labInfo')->value['dayName']!=='-'){?>
            <TD><?php echo $_smarty_tpl->getVariable('labInfo')->value['dayName'];?>
</TD>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('labInfo')->value['dayName']!=='-'){?>
            <TD><?php echo $_smarty_tpl->getVariable('labInfo')->value['ttime'];?>
</TD>
        <?php }?>
	</TR>
	</TABLE>
	<BR>
	<form method="POST" action="">
	<p class="sectioncontent">
		Αν ναί, πληκτρολογήστε ΝΑΙ (με κεφαλαία Ελληνικά γράμματα) ή YES (με κεφαλαία Αγγλικά γράμματα) και επιλέξτε το κουμπί Αποχώρηση.<BR>
		<label for="confirmTextbox">Επιβεβαίωση: </label><input type="text" name="confirmTextbox"><BR>
		<input type="submit" value="Αποχώρηση">
	</p>
	</form>
	<p class="sectioncontent">
		<a href="<?php echo $_smarty_tpl->getVariable('referer')->value;?>
"><u>Επιστροφή</u></a>
	</p>
</div>

<?php $_template = new Smarty_Internal_Template("templates/footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>