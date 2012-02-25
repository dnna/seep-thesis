<?php /* Smarty version Smarty-3.0.7, created on 2011-03-26 23:04:26
         compiled from "./templates/modules/ViewLotteryStatus/ViewLotteryStatus.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15477026944d8e54da1de7a9-87886254%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ced45db5c077cc34549f3cca28a8d2e6503ea1fe' => 
    array (
      0 => './templates/modules/ViewLotteryStatus/ViewLotteryStatus.tpl',
      1 => 1301173463,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15477026944d8e54da1de7a9-87886254',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<?php $_smarty_tpl->tpl_vars["pageTitle"] = new Smarty_variable("Αποτελέσματα Κληρώσεων", null, null);?>
<?php $_template = new Smarty_Internal_Template("templates/header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<div id="leftcolumn" class="NonPrintable">
        <h2 class="subsectiontitle">Ημ/νίες Κληρώσεων</h2>
	<div style='position:relative;left:10%;width:80%'>
            <?php if (!empty($_smarty_tpl->getVariable('futureLotteryChoices',null,true,false)->value)){?>
                <h2 class="subsectiontitle">Μελλοντικές</h2>
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
                        <div class="choiceHighlighted">
                                <?php echo $_smarty_tpl->getVariable('futureLotteryChoices')->value[$_smarty_tpl->getVariable('smarty')->value['section']['curLottery']['index']]->getDate();?>

                        </div>
                <?php endfor; endif; ?>
            <?php }?>
                
            <?php if (!empty($_smarty_tpl->getVariable('lastLottery',null,true,false)->value)){?>
                <h2 class="subsectiontitle">Πιο πρόσφατη</h2>
                <?php if ($_smarty_tpl->getVariable('lastLottery')->value[0]->isInProgress()){?>
                    <?php $_smarty_tpl->tpl_vars['lotteryInProgress'] = new Smarty_variable($_smarty_tpl->getVariable('lastLottery')->value[0]->getDate(), null, null);?>
                    <div class="choice" style="font-weight:bold">
                            <?php echo $_smarty_tpl->getVariable('lastLottery')->value[0]->getDate();?>

                            <BR>
                            (Σε εξέλιξη)
                    </div>
                <?php }else{ ?>
                    <div class="choiceHighlighted" style="font-weight:bold">
                            <?php echo $_smarty_tpl->getVariable('lastLottery')->value[0]->getDate();?>

                    </div>
                <?php }?>
            <?php }?>
                
            <?php if (count($_smarty_tpl->getVariable('completedLotteryChoices')->value)>1){?>
                <h2 class="subsectiontitle">Προηγούμενες</h2>
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
        <?php if (!empty($_smarty_tpl->getVariable('lastLottery',null,true,false)->value)){?>
            <div class="valid">Κλήρωση <span style="font-weight:bold"><?php echo $_smarty_tpl->getVariable('lastLottery')->value[0]->getDate();?>
</span></div>
            <?php if (isset($_smarty_tpl->getVariable('lotteryInProgress',null,true,false)->value)){?>
            <div class="warning">Αυτή τη στιγμή βρίσκεται σε εξέλιξη η κλήρωση: <span style="font-weight: bold"><?php echo $_smarty_tpl->getVariable('lotteryInProgress')->value;?>
</span><BR>
            Ανανεώστε αυτή τη σελίδα σε 5-10 λεπτά για να δείτε τα αποτελέσματα.</div>
            <?php }?>
            <?php echo $_smarty_tpl->getVariable('lotteryLog')->value;?>

        <?php }else{ ?>
            <div class="invalid">Αυτή τη στιγμή δεν υπάρχουν κληρώσεις που να έχουν ολοκληρωθεί.</div>
        <?php }?>
	<p class="subsectioncontent"></p>
</div>

<?php $_template = new Smarty_Internal_Template("templates/footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>