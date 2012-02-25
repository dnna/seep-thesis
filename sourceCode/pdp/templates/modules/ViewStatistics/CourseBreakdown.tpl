{* Smarty template *}

<TABLE width=95% height=95% class="prefTable tablesorter" id="courseBreakdownTable">
    <THEAD><TR><TH>Εργαστηριακο Τμήμα</TH><TH>Επιτυχείς Εγγραφές</TH><TH>Ανεπιτυχείς Εγγραφές</TH><TH>Σύνολο</TH></TR></THEAD>
    <TBODY>
    {foreach from=$courseBreakdown key=curCourseID item=curCourse}
        {assign var='totalRegistrations' value=$curCourse.successfulRegistrations+$curCourse.failedRegistrations}
        <TR style="height:35px">
            <TD class="hours" style="width:15%">
                <a href="?module=ViewStatistics&displayLabBreakdown={$curCourse.courseID}&showLottery={$curLotteryID}" onClick="return labBreakdownPopup(this, 'labBreakdown')"><span style="text-decoration: underline">{$curCourse.courseName}</span></a>
            </TD>
            <TD class="valid">{$curCourse.successfulRegistrations} ({math equation="x/t*100" t=$totalRegistrations x=$curCourse.successfulRegistrations format="%.1f"}%)</TD>
            <TD class="invalid">{$curCourse.failedRegistrations} ({math equation="x/t*100" t=$totalRegistrations x=$curCourse.failedRegistrations format="%.1f"}%)</TD>
            <TD class="warning">{$totalRegistrations}</TD>
        </TR>
    {/foreach}
    </TBODY>
</TABLE>