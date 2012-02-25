{* Smarty template *}

<script type="text/javascript" src="templates/jquery.js"></script>
<script type="text/javascript" src="templates/jquery.tablesorter.js"></script>
<script type="text/javascript" src="templates/modules/ManageLotteries/datetimepicker_css.js"></script>
<script type="text/javascript">
{literal}
addLoadEvent(function(){
	$("#prefTable").tablesorter({sortList: [[0,0]],headers:{1:{sorter:false}}});
});
{/literal}
</script>