<?php /* Smarty version Smarty-3.0.7, created on 2011-03-25 18:55:18
         compiled from "./templates/modules/ViewStatistics/ViewStatistics.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12100225044d8cc8f68a22a1-86674342%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cdc972d402dfa214e98b6f3cf5f29c6df0d81977' => 
    array (
      0 => './templates/modules/ViewStatistics/ViewStatistics.tpl',
      1 => 1301072112,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12100225044d8cc8f68a22a1-86674342',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<?php $_smarty_tpl->tpl_vars["pageTitle"] = new Smarty_variable("Εμφάνιση Στατιστικών Στοιχείων", null, null);?>
<?php $_template = new Smarty_Internal_Template("templates/header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<div id="leftcolumn" class="NonPrintable">
        <h2 class="subsectiontitle">Ημ/νίες Ολοκληρωμένων Κληρώσεων</h2>
	<div style='position:relative;left:10%;width:80%'>
            <?php if (count($_smarty_tpl->getVariable('completedLotteryChoices')->value)>1){?>
                <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['name'] = 'curLottery';
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('completedLotteryChoices')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['start'] = (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['curLottery']['max']);
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
                        <?php if ($_smarty_tpl->getVariable('completedLotteryChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curLottery']['index']]->isInProgress()){?>
                            <?php $_smarty_tpl->tpl_vars['lotteryInProgress'] = new Smarty_variable($_smarty_tpl->getVariable('completedLotteryChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curLottery']['index']]->getDate(), null, null);?>
                            <div class="choice">
                                    <?php echo $_smarty_tpl->getVariable('completedLotteryChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curLottery']['index']]->getDate();?>

                                    <BR>
                                    (Σε εξέλιξη)
                            </div>
                        <?php }else{ ?>
                            <div class="curChoice">
                                    <?php echo $_smarty_tpl->getVariable('completedLotteryChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curLottery']['index']]->getDate();?>

                            </div>
                        <?php }?>
                <?php endfor; endif; ?>
            <?php }?>
	</div>
</div>
<a href="#" style="display:none" id="separator" onclick="toggleSidebar();"></a>
<div id="rightcolumn" style="min-height:400px">
	<h2 class="sectiontitle"><?php echo $_smarty_tpl->getVariable('pageTitle')->value;?>
</h2>
        <?php if (!empty($_smarty_tpl->getVariable('lotteryChoices',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('curLottery',null,true,false)->value)){?>
            <div class="valid">Κλήρωση <span style="font-weight:bold"><?php echo $_smarty_tpl->getVariable('curLottery')->value[0]['lotDate'];?>
</span></div>
            <p></p>
            <?php echo $_smarty_tpl->getVariable('curStatistics')->value;?>

        <?php }elseif(empty($_smarty_tpl->getVariable('lotteryChoices',null,true,false)->value)){?>
            <div class="invalid">Αυτή τη στιγμή δεν υπάρχουν κληρώσεις που να έχουν ολοκληρωθεί.</div>
        <?php }else{ ?>
            <div class="invalid">Η κλήρωση που επιλέξατε δεν είναι έγκυρη.</div>
        <?php }?>
	<p class="subsectioncontent"></p>
</div>

<?php $_template = new Smarty_Internal_Template("templates/footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>