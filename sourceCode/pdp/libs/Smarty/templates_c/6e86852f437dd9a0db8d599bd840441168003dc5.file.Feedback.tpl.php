<?php /* Smarty version Smarty-3.0.7, created on 2011-03-21 19:41:05
         compiled from "./templates/modules/Feedback/Feedback.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12843253424d878db12830f4-82010496%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6e86852f437dd9a0db8d599bd840441168003dc5' => 
    array (
      0 => './templates/modules/Feedback/Feedback.tpl',
      1 => 1300653265,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12843253424d878db12830f4-82010496',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<?php $_smarty_tpl->tpl_vars["pageTitle"] = new Smarty_variable("Σχόλια/Αναφορά Προβλημάτων", null, null);?>
<?php $_template = new Smarty_Internal_Template("templates/header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<div>
	<h2 class="sectiontitle"><?php echo $_smarty_tpl->getVariable('pageTitle')->value;?>
</h2>
	<div class="sectioncontent">
                <p>Μπορείτε να χρησιμοποιήσετε την παρακάτω φόρμα για να μας αποστέλετε<BR>
                σχόλια, παρατηρήσεις, αναφορές σφαλμάτων (bugs) ή οτι άλλο κρίνετε χρήσιμο.</p>
                <p>Η διεύθυνση E-Mail είναι προαιρετική, εάν δεν την εισάγετε τότε η φόρμα είναι ανώνυμη.</p>
                <form action="?module=Feedback&ProcessFeedback" id="statementForm" method="POST">
                    <p>Διεύθυνση E-Mail:<BR>
                    <input type="text" name="email" /><BR></p>
                    <p>Περιγραφή:<BR>
                    <textarea name="comments" rows="15" cols="50" onKeyDown="limitText(this.form.comments,this.form.countdown,1000);"
                    onKeyUp="limitText(this.form.comments,this.form.countdown,1000);"></textarea><br>
                    <font size="1">(Μέγιστοι χαρακτήρες: 1000)<br>
                    Σας απομένουν <input readonly type="text" name="countdown" size="3" value="1000"> χαρακτήρες.</font></p>
                    <p><input type="submit" value="Αποστολή" /></p>
                </form>
	</div>
</div>

<?php $_template = new Smarty_Internal_Template("templates/footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>