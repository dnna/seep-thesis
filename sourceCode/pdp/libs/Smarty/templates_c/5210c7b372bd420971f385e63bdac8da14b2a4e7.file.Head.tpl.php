<?php /* Smarty version Smarty-3.0.7, created on 2011-03-21 19:31:02
         compiled from "./templates/modules/ManageLotteries/Head.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13864456114d878b56b43439-63255244%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5210c7b372bd420971f385e63bdac8da14b2a4e7' => 
    array (
      0 => './templates/modules/ManageLotteries/Head.tpl',
      1 => 1300714597,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13864456114d878b56b43439-63255244',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<script type="text/javascript" src="templates/jquery.js"></script>
<script type="text/javascript" src="templates/jquery.tablesorter.js"></script>
<script type="text/javascript" src="templates/modules/ManageLotteries/datetimepicker_css.js"></script>
<script type="text/javascript">

addLoadEvent(function(){
	$("#prefTable").tablesorter({sortList: [[0,0]],headers:{1:{sorter:false}}});
});

</script>