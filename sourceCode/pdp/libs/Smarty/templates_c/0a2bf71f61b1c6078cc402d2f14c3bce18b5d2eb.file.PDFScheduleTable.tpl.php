<?php /* Smarty version Smarty-3.0.7, created on 2011-03-26 23:07:57
         compiled from "./templates/modules/ViewPersonalSchedule/PDFScheduleTable.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3549419094d8e55adc51293-49050607%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0a2bf71f61b1c6078cc402d2f14c3bce18b5d2eb' => 
    array (
      0 => './templates/modules/ViewPersonalSchedule/PDFScheduleTable.tpl',
      1 => 1301173672,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3549419094d8e55adc51293-49050607',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta http-equiv="content-language" content="gr" />
    <meta http-equiv="pragma" content="no-cache" />

    <style type="text/css">
    .sectiontitle {margin:0 0.5em;padding:0;font-size:1.5em;text-align:center;}
    .sectioncontent {margin:0 0.5em 0.5em;padding:0.5em;font-size:1em;text-align:center;}
    .footerDate {text-align:center;}
    table.prefTable {
            border-collapse: collapse;
            /*empty-cells:show;*/
    }
    table.prefTable th {
            border-width: 1px 1px 1px 1px;
            padding: 4px 4px 4px 4px;
            border-style: solid solid solid solid;
            border-color: black black black black;
    }
    table.prefTable tr { }
    table.prefTable td {
            border-width: 1px 1px 1px 1px;
            padding: 4px 4px 4px 4px;
            border-style: solid solid solid solid;
            border-color: black black black black;
    }
    table.prefTable td.hours {
            font-weight: bold;
    }
    .theory {
            background-color: #E6E7FF;
            border-width: 1px 1px 1px 1px;
            padding: 4px 4px 4px 4px;
            border-style: dotted dotted dotted dotted;
            border-color: black;
            text-align:center;
    }
    .lab {
            background-color: #FFF4D4;
            border-width: 1px 1px 1px 1px;
            padding: 4px 4px 4px 4px;
            border-style: solid solid solid solid;
            border-color: black;
            text-align:center;
    }
</style>

</head>
<body>
    <div>
    <div><h2 class="sectiontitle">Προσωπικό Ωρολόγιο Πρόγραμμα</h2></div>
    <div><h2 class="sectiontitle"><?php echo $_smarty_tpl->getVariable('auth')->value->getFirstName();?>
 <?php echo $_smarty_tpl->getVariable('auth')->value->getLastName();?>
</h2></div>
    <TABLE class="prefTable">
    <TR><TH width="24px"></TH>
    <?php  $_smarty_tpl->tpl_vars['day'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['dayName'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('days')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['day']->key => $_smarty_tpl->tpl_vars['day']->value){
 $_smarty_tpl->tpl_vars['dayName']->value = $_smarty_tpl->tpl_vars['day']->key;
?>
            <TH><?php echo $_smarty_tpl->tpl_vars['day']->value[1];?>
</TH>
    <?php }} ?>
    </TR>
    <?php  $_smarty_tpl->tpl_vars['hour'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['hourName'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('schedule')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['hour']->key => $_smarty_tpl->tpl_vars['hour']->value){
 $_smarty_tpl->tpl_vars['hourName']->value = $_smarty_tpl->tpl_vars['hour']->key;
?>
            <TR><TD class="hours" width="24px"><?php echo $_smarty_tpl->tpl_vars['hourName']->value;?>
</TD>
            <?php  $_smarty_tpl->tpl_vars['day'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['dayName'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['hour']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['day']->key => $_smarty_tpl->tpl_vars['day']->value){
 $_smarty_tpl->tpl_vars['dayName']->value = $_smarty_tpl->tpl_vars['day']->key;
?>
                    <TD style="padding: 4px 4px 4px 4px;">
                    <?php  $_smarty_tpl->tpl_vars['entry'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['day']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['entry']->key => $_smarty_tpl->tpl_vars['entry']->value){
?>
                            <?php if ($_smarty_tpl->getVariable('entry')->value->getcourseType()=='Θεωρία'){?>
                                    <div class="theory">
                                    <div><?php echo $_smarty_tpl->getVariable('entry')->value->getCourseName();?>
</div>
                                    <div>(<?php echo $_smarty_tpl->getVariable('entry')->value->getcourseType();?>
)</div>
                            <?php }else{ ?>
                                    <?php $_smarty_tpl->tpl_vars['combinedID'] = new Smarty_variable((($_smarty_tpl->getVariable('entry')->value->getcourseID()).('_')).($_smarty_tpl->getVariable('entry')->value->getlabID()), null, null);?>
                                    <div class="lab" style="background-color: <?php echo $_smarty_tpl->getVariable('entry')->value->getColor();?>
;">
                                    <div><?php echo $_smarty_tpl->getVariable('entry')->value->getCourseName();?>
<?php if ($_smarty_tpl->getVariable('entry')->value->getCourseName()!==$_smarty_tpl->getVariable('entry')->value->getLabName()){?></div>
                                    <div>(<?php echo $_smarty_tpl->getVariable('entry')->value->getLabName();?>
)<?php }?></div>
                            <?php }?>
                            </div>
                    <?php }} ?>
                    </TD>
            <?php }} ?>
            </TR>
    <?php }} ?>
    </TABLE>
    <div class="footerDate">Πιο πρόσφατη κλήρωση: <?php echo $_smarty_tpl->getVariable('lastLotDate')->value;?>
</div>
    </div>
</body>
</html>