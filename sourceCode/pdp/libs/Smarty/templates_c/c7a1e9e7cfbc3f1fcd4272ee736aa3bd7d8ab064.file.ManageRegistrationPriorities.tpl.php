<?php /* Smarty version Smarty-3.0.7, created on 2011-03-21 19:31:02
         compiled from "./templates/modules/ManageRegistrationPriorities/ManageRegistrationPriorities.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21319687794d878b56169cc5-80950541%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c7a1e9e7cfbc3f1fcd4272ee736aa3bd7d8ab064' => 
    array (
      0 => './templates/modules/ManageRegistrationPriorities/ManageRegistrationPriorities.tpl',
      1 => 1287672853,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21319687794d878b56169cc5-80950541',
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
                <TR><TH>Προτεραιότητα</TH><TH>Ενεργοποιημένη</TH><TH>Όνομα</TH></TR>
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
" value="no" />
                    <?php if ($_smarty_tpl->tpl_vars['curPriority']->value['rpEnabled']==="1"){?>
                        <input type="checkbox" name="enabled_<?php echo $_smarty_tpl->tpl_vars['curPriority']->value['rpId'];?>
" value="yes" checked />
                    <?php }else{ ?>
                        <input type="checkbox" name="enabled_<?php echo $_smarty_tpl->tpl_vars['curPriority']->value['rpId'];?>
" value="yes" />
                    <?php }?>
                </TD>
                <TD style="width:70%"><?php echo $_smarty_tpl->tpl_vars['curPriority']->value['rpName'];?>
<input type="hidden" name="name_<?php echo $_smarty_tpl->tpl_vars['curPriority']->value['rpId'];?>
" maxlength=100 style="width:98%" value="<?php echo $_smarty_tpl->tpl_vars['curPriority']->value['rpName'];?>
"/></TD>
                <input type="hidden" name="parameters_<?php echo $_smarty_tpl->tpl_vars['curPriority']->value['rpId'];?>
" maxlength=255 style="width:98%" value="<?php echo $_smarty_tpl->tpl_vars['curPriority']->value['rpParameters'];?>
" />
                </TR>
            <?php }} ?>
            </TABLE>
        </p>
        <p><a href="?module=ManageRegistrationPriorities&Advanced">Για προχωρημένους</a></p>
        <p><input type="submit" class="NonPrintable" name="submitted" value="Καταχώρηση">
        <input type="reset" class="NonPrintable" value="Ακύρωση Αλλαγών"></p>
        </form>
        <p class="subsectioncontent"></p>
</div>

<?php $_template = new Smarty_Internal_Template("templates/footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>