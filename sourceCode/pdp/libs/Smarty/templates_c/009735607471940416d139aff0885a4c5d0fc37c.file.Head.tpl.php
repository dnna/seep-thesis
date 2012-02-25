<?php /* Smarty version Smarty-3.0.7, created on 2011-03-24 02:54:57
         compiled from "./templates/modules/ViewStatistics/Head.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3105127844d8a9661970f31-89299443%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '009735607471940416d139aff0885a4c5d0fc37c' => 
    array (
      0 => './templates/modules/ViewStatistics/Head.tpl',
      1 => 1300928095,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3105127844d8a9661970f31-89299443',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript" src="templates/jquery.js"></script>
<script type="text/javascript" src="templates/jquery.tablesorter.js"></script>
<script type="text/javascript">

addLoadEvent(function(){
        $("#preferenceBreakdownTable").tablesorter({sortList: [[2,1]]});
        $("#failedCourseBreakdownTable").tablesorter({sortList: [[1,1]]});
	$("#courseBreakdownTable").tablesorter({sortList: [[2,1]]});
});

function popup(mylink, windowname) {
    if (! window.focus) {
        return true;
    }
    var href;
    if (typeof(mylink) == 'string') {
        href=mylink;
    } else {
        href=mylink.href;
    }
    window.open(href, windowname, 'width=400,height=600,scrollbars=yes,toolbar=no,directories=no,location=no,menubar=no,status=yes');
    return false;
}

function labBreakdownPopup(mylink, windowname) {
    if (! window.focus) {
        return true;
    }
    var href;
    if (typeof(mylink) == 'string') {
        href=mylink;
    } else {
        href=mylink.href;
    }
    window.open(href, windowname, 'width=800,height=600,scrollbars=yes,toolbar=no,directories=no,location=no,menubar=no,status=yes');
    return false;
}

</script>