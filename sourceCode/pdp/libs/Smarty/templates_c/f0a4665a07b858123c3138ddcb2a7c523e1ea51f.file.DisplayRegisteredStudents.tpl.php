<?php /* Smarty version Smarty-3.0.7, created on 2011-04-05 18:04:59
         compiled from "./templates/modules/ManageLabParameters/DisplayRegisteredStudents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7865941464d9b2f9befea25-60217558%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f0a4665a07b858123c3138ddcb2a7c523e1ea51f' => 
    array (
      0 => './templates/modules/ManageLabParameters/DisplayRegisteredStudents.tpl',
      1 => 1302015896,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7865941464d9b2f9befea25-60217558',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<head>
    <title>Εγγεγραμένοι Φοιτητές</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
    <table border="1">
        <thead>
            <tr><th>Α.Μ.</th><th>Όνομα</th></tr>
        </thead>
        <tbody>
        <?php  $_smarty_tpl->tpl_vars['curStudent'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('students')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['curStudent']->key => $_smarty_tpl->tpl_vars['curStudent']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['curStudent']->key;
?>
            <tr><td><?php echo substr($_smarty_tpl->tpl_vars['curStudent']->value['username'],2);?>
</td><td><?php echo $_smarty_tpl->tpl_vars['curStudent']->value['name'];?>
</td></tr>
        <?php }} ?>
        </tbody>
    </table>
    <form action="">
        <input type="button" name="close" value="Κλείσιμο" onClick="self.close();" />
    </form>
</body>