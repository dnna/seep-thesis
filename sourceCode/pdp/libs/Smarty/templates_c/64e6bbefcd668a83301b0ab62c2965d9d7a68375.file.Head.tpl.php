<?php /* Smarty version Smarty-3.0.7, created on 2011-03-21 19:41:05
         compiled from "./templates/modules/Feedback/Head.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7078239904d878db1233ff2-74281594%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '64e6bbefcd668a83301b0ab62c2965d9d7a68375' => 
    array (
      0 => './templates/modules/Feedback/Head.tpl',
      1 => 1300627181,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7078239904d878db1233ff2-74281594',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>



<script type="text/javascript">
function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}
</script>
