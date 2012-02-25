<script type="text/javascript" src="templates/jquery.js"></script>
<script type="text/javascript" src="templates/jquery.tablesorter.js"></script>
<script type="text/javascript">
{literal}
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
{/literal}
</script>