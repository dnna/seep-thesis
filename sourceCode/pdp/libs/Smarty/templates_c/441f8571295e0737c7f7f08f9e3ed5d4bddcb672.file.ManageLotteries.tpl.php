<?php /* Smarty version Smarty-3.0.7, created on 2011-03-21 19:31:02
         compiled from "./templates/modules/ManageLotteries/ManageLotteries.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10034272944d878b56b92a30-89706654%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '441f8571295e0737c7f7f08f9e3ed5d4bddcb672' => 
    array (
      0 => './templates/modules/ManageLotteries/ManageLotteries.tpl',
      1 => 1300714677,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10034272944d878b56b92a30-89706654',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/seep/libs/Smarty/plugins/modifier.date_format.php';
?>

<?php $_smarty_tpl->tpl_vars["pageTitle"] = new Smarty_variable("Επεξεργασία Κληρώσεων", null, null);?>
<?php $_template = new Smarty_Internal_Template("templates/header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<div>
	<h2 class="sectiontitle"><?php echo $_smarty_tpl->getVariable('pageTitle')->value;?>
</h2> 
	<p class="sectioncontent">
            <form action="?module=ManageLotteries&ProcessStatement" id="statementForm" method="POST">
            <b>Διαγραφή Μελλοντικών Κληρώσεων</b>
            <TABLE style="width:95%;height:95%" class="prefTable tablesorter" id="prefTable">
                <THEAD><TR><TH style="width:80%">Ημερομηνία και Ώρα</TH><TH style="width:20%" class="unsortable">Επιλογή</TH></TR></THEAD>
				<TBODY>
            <?php  $_smarty_tpl->tpl_vars['curLottery'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('lotteries')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['curLottery']->key => $_smarty_tpl->tpl_vars['curLottery']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['curLottery']->key;
?>
                <?php $_smarty_tpl->tpl_vars['curLotteryChoice'] = new Smarty_variable($_smarty_tpl->getVariable('lotteryChoices')->value[$_smarty_tpl->getVariable('k')->value]->getDate(), null, null);?>
                <TR>
                <TD style="width:10%">
                    <?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('curLotteryChoice')->value[0],"%D");?>
 <?php echo $_smarty_tpl->getVariable('curLotteryChoice')->value[1];?>

                </TD>
                <TD>
                    <input type="hidden" name="delete_<?php echo $_smarty_tpl->tpl_vars['curLottery']->value['lotID'];?>
" value="no" />
                    <input type="checkbox" name="delete_<?php echo $_smarty_tpl->tpl_vars['curLottery']->value['lotID'];?>
" value="yes" />
                </TD>
                </TR>
            <?php }} ?>
			</TBODY>
            </TABLE>
            <p>
			<input type="submit" class="NonPrintable" name="submitted" value="Διαγραφή Επιλεγμένων"
                               onClick="if(confirm('Θέλετε σίγουρα να διαγράψετε τις επιλεγμένες κληρώσεις;')) return true; else return false;" >
			</form>
			</p>
        </p>
        <p class="sectioncontent">
            <form action="?module=ManageLotteries&ProcessStatement" id="statementForm" method="POST">
            <b>Εισαγωγή Νέας Κλήρωσης</b>
            <div class="warning">Οι κληρώσεις προτείνεται να απέχουν τουλάχιστον 24 ώρες μεταξύ τους.</div>
            <TABLE style="width:95%;height:95%" class="prefTable" id="prefTable">
                <TR><TH>
                    <input id="insert_0" name="insert_0" type="text" size="15" readonly />
                    <a href="javascript:NewCssCal('insert_0','mmddyyyy','arrow',true)">
                    <img src="templates/modules/ManageLotteries/images/cal.gif" width="16" height="16" style="border:none" alt="Επιλογή Ημερομηνίας"></a>
                </TH></TR>
            </TABLE>
            <p><input type="submit" class="NonPrintable" name="submitted" value="Εισαγωγή Κλήρωσης">
            <input type="reset" class="NonPrintable" value="Ακύρωση"></form></p>
            </form>
        </p>
        <p class="subsectioncontent"></p>
</div>

<?php $_template = new Smarty_Internal_Template("templates/footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>