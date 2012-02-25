<?php /* Smarty version Smarty-3.0.7, created on 2011-03-28 13:33:30
         compiled from "./templates/modules/ManageRegistrationPriorities/ManageRegistrationPrioritiesAdvanced.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8631452314d9063fa4531a2-81951593%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9f9fdc52d90fd8482638881e72508ede4475866d' => 
    array (
      0 => './templates/modules/ManageRegistrationPriorities/ManageRegistrationPrioritiesAdvanced.tpl',
      1 => 1287247658,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8631452314d9063fa4531a2-81951593',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<?php $_smarty_tpl->tpl_vars["pageTitle"] = new Smarty_variable("Επεξεργασία Προτεραιοτήτων Εγγραφής", null, null);?>
<?php $_template = new Smarty_Internal_Template("templates/header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<div>
	<h2 class="sectiontitle"><?php echo $_smarty_tpl->getVariable('pageTitle')->value;?>
</h2> 
	<p class="sectioncontent">
            <form action="?module=ManageRegistrationPriorities&ProcessStatement" id="statementForm" method="POST">
            <TABLE style="width:95%;height:95%" class="prefTable" id="prefTable">
                <TR><TH>Προτεραιότητα</TH><TH>Ενεργοποιημένη</TH><TH>Όνομα</TH><TH>Query</TH></TR>
            <?php  $_smarty_tpl->tpl_vars['curPriority'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('registrationPriorities')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['curPriority']->key => $_smarty_tpl->tpl_vars['curPriority']->value){
?>
                <TR>
                <TD style="width:10%"><?php echo $_smarty_tpl->tpl_vars['curPriority']->value['rpPrio'];?>
</TD>
                <TD style="width:10%">
                    <input type="hidden" name="enabled_<?php echo $_smarty_tpl->tpl_vars['curPriority']->value['rpId'];?>
" value="no">
                    <?php if ($_smarty_tpl->tpl_vars['curPriority']->value['rpEnabled']==="1"){?>
                        <input type="checkbox" name="enabled_<?php echo $_smarty_tpl->tpl_vars['curPriority']->value['rpId'];?>
" value="yes" checked />
                    <?php }else{ ?>
                        <input type="checkbox" name="enabled_<?php echo $_smarty_tpl->tpl_vars['curPriority']->value['rpId'];?>
" value="yes" />
                    <?php }?>
                </TD>
                <TD style="width:30%"><input type="text" name="name_<?php echo $_smarty_tpl->tpl_vars['curPriority']->value['rpId'];?>
" maxlength=100 style="width:98%" value="<?php echo $_smarty_tpl->tpl_vars['curPriority']->value['rpName'];?>
" /></TD>
                <TD style="width:50%"><input type="text" name="parameters_<?php echo $_smarty_tpl->tpl_vars['curPriority']->value['rpId'];?>
" maxlength=255 style="width:98%" value="<?php echo $_smarty_tpl->tpl_vars['curPriority']->value['rpParameters'];?>
" /></TD>
                </TR>
            <?php }} ?>
            </TABLE>
        </p>
        <p><a href="?module=ManageRegistrationPriorities">Απλή Μορφή</a></p>
        <p><input type="submit" class="NonPrintable" name="submitted" value="Καταχώρηση">
        <input type="reset" class="NonPrintable" value="Ακύρωση Αλλαγών"></p>
        </form>
        <p class="subsectioncontent"></p>
</div>

<?php $_template = new Smarty_Internal_Template("templates/footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>