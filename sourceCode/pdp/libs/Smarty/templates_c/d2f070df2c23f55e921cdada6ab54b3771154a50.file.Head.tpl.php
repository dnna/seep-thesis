<?php /* Smarty version Smarty-3.0.7, created on 2011-03-21 20:05:08
         compiled from "./templates/modules/ManageLabParameters/Head.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8175224684d879354a3fe05-40566951%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd2f070df2c23f55e921cdada6ab54b3771154a50' => 
    array (
      0 => './templates/modules/ManageLabParameters/Head.tpl',
      1 => 1300730702,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8175224684d879354a3fe05-40566951',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript" src="templates/jquery.js"></script>
<script type="text/javascript" src="templates/jquery.tablesorter.js"></script>
<script type="text/javascript" src="templates/jquery.tablesorter.dayparser.js"></script>
<script type="text/javascript">
    <!--

    addLoadEvent(function(){
            var note = document.getElementById('selectionNote');
            note.style.display = '';
	    $("#prefTable").tablesorter({sortList: [[0,0]],headers:{1:{sorter:'days'},6:{sorter:false}}});
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

    //-->
</script>