<?php /* Smarty version Smarty-3.0.7, created on 2011-04-06 18:15:26
         compiled from "./templates/modules/ViewStatistics/LabBreakdown.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21367048404d9c838e404849-49101728%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '76d0741423b9c8115c0859af066e1ae926999a3a' => 
    array (
      0 => './templates/modules/ViewStatistics/LabBreakdown.tpl',
      1 => 1302102923,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21367048404d9c838e404849-49101728',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<head>
    <title>Εμφάνιση Στατιστικών Εργαστηριακού Μαθήματος</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" media="print" href="templates/print.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="templates/style.css" />
    <script type="text/javascript" src="templates/jquery.js"></script>
    <script type="text/javascript" src="templates/jquery.tablesorter.js"></script>
    <script type="text/javascript">
    
    window.onload = function(){$("#labBreakdownTable").tablesorter({sortList: [[2,1]]})};
    
    </script>
</head>
    <body>
    <TABLE width=95% class="prefTable tablesorter" id="labBreakdownTable">
        <THEAD><TR><TH>Εργαστηριακο Τμήμα</TH><TH>Επιτυχείς Εγγραφές</TH><TH>Ανεπιτυχείς Εγγραφές</TH></TR></THEAD>
        <TBODY>
        <?php  $_smarty_tpl->tpl_vars['curLab'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['curLabID'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('labBreakdown')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['curLab']->key => $_smarty_tpl->tpl_vars['curLab']->value){
 $_smarty_tpl->tpl_vars['curLabID']->value = $_smarty_tpl->tpl_vars['curLab']->key;
?>
            <TR>
                <TD class="hours" style="width:15%"><?php echo $_smarty_tpl->tpl_vars['curLab']->value['labName'];?>
</TD>
                <TD class="valid">
                    <?php if (isset($_smarty_tpl->tpl_vars['curLab']->value['successfulRegistrations'])){?>
                        <?php echo $_smarty_tpl->tpl_vars['curLab']->value['successfulRegistrations'];?>

                    <?php }else{ ?>
                        0
                    <?php }?>
                </TD>
                <TD class="invalid">
                    <?php if (isset($_smarty_tpl->tpl_vars['curLab']->value['failedRegistrations'])){?>
                        <?php echo $_smarty_tpl->tpl_vars['curLab']->value['failedRegistrations'];?>

                    <?php }else{ ?>
                        0
                    <?php }?>
                </TD>
            </TR>
        <?php }} ?>
        </TBODY>
    </TABLE>
    <form action="">
        <center><input type="button" name="close" value="Κλείσιμο" onClick="self.close();" /></center>
    </form>
</body>