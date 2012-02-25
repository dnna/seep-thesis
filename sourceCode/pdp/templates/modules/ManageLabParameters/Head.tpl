<script type="text/javascript" src="templates/jquery.js"></script>
<script type="text/javascript" src="templates/jquery.tablesorter.js"></script>
<script type="text/javascript" src="templates/jquery.tablesorter.dayparser.js"></script>
<script type="text/javascript">
    <!--
{literal}
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
{/literal}
    //-->
</script>