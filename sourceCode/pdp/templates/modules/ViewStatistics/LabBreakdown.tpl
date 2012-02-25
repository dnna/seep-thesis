{* Smarty template *}

<head>
    <title>Εμφάνιση Στατιστικών Εργαστηριακού Μαθήματος</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" media="print" href="templates/print.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="templates/style.css" />
    <script type="text/javascript" src="templates/jquery.js"></script>
    <script type="text/javascript" src="templates/jquery.tablesorter.js"></script>
    <script type="text/javascript">
    {literal}
    window.onload = function(){$("#labBreakdownTable").tablesorter({sortList: [[2,1]]})};
    {/literal}
    </script>
</head>
    <body>
    <TABLE width=95% class="prefTable tablesorter" id="labBreakdownTable">
        <THEAD><TR><TH>Εργαστηριακο Τμήμα</TH><TH>Επιτυχείς Εγγραφές</TH><TH>Ανεπιτυχείς Εγγραφές</TH></TR></THEAD>
        <TBODY>
        {foreach from=$labBreakdown key=curLabID item=curLab}
            <TR>
                <TD class="hours" style="width:15%">{$curLab.labName}</TD>
                <TD class="valid">
                    {if isset($curLab.successfulRegistrations)}
                        {$curLab.successfulRegistrations}
                    {else}
                        0
                    {/if}
                </TD>
                <TD class="invalid">
                    {if isset($curLab.failedRegistrations)}
                        {$curLab.failedRegistrations}
                    {else}
                        0
                    {/if}
                </TD>
            </TR>
        {/foreach}
        </TBODY>
    </TABLE>
    <form action="">
        <center><input type="button" name="close" value="Κλείσιμο" onClick="self.close();" /></center>
    </form>
</body>