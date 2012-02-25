<?php /* Smarty version Smarty-3.0.7, created on 2011-03-21 19:31:04
         compiled from "./templates/modules/ViewLotteryDates/ViewLotteryDates.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1866805984d878b58b96213-27463486%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cbea9a958555c9b0ffcb2db2bf61de1f6f7ab445' => 
    array (
      0 => './templates/modules/ViewLotteryDates/ViewLotteryDates.tpl',
      1 => 1286710089,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1866805984d878b58b96213-27463486',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/seep/libs/Smarty/plugins/modifier.date_format.php';
?>

<?php $_smarty_tpl->tpl_vars["pageTitle"] = new Smarty_variable("Ημερομηνίες Κληρώσεων", null, null);?>
<?php $_template = new Smarty_Internal_Template("templates/header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<h2 class="sectiontitle"><?php echo $_smarty_tpl->getVariable('pageTitle')->value;?>
</h2> 

<div style='position:relative;left:10%;width:80%'>
    <h2 class="subsectiontitle">Μελλοντικές</h2>
    <table width=95% height=95% class="prefTable" id="prefTable">
    <tr><th>Ημερομηνία</th><th>Ώρα</th></tr>
    <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['name'] = 'curLottery';
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('futureLotteryChoices')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['total']);
?>
            <?php $_smarty_tpl->tpl_vars['curLottery'] = new Smarty_variable($_smarty_tpl->getVariable('futureLotteryChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curLottery']['index']]->getDate(), null, null);?>
            <tr><td><?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('curLottery')->value[0],"%D");?>
</td><td><?php echo $_smarty_tpl->getVariable('curLottery')->value[1];?>
</td></tr>
    <?php endfor; endif; ?>
    </table>
    <p class="subsectioncontent"></p>
    
    <h2 class="subsectiontitle">Προηγούμενες</h2>
    <table width=95% height=95% class="prefTable" id="prefTable">
    <tr><th>Ημερομηνία</th><th>Ώρα</th></tr>
    <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['name'] = 'curLottery';
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('completedLotteryChoices')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['total']);
?>
            <?php $_smarty_tpl->tpl_vars['curLottery'] = new Smarty_variable($_smarty_tpl->getVariable('completedLotteryChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curLottery']['index']]->getDate(), null, null);?>
            <tr><td><?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('curLottery')->value[0],"%D");?>
</td><td><?php echo $_smarty_tpl->getVariable('curLottery')->value[1];?>
</td></tr>
    <?php endfor; endif; ?>
    </table>
    
    <p class="subsectioncontent"></p>
</div>

<?php $_template = new Smarty_Internal_Template("templates/footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>