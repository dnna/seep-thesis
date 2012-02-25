{* Smarty template *}

<div>
        Ποσοστά εγγραφών ανά προτίμηση:<BR>
        <TABLE width=95% height=95% class="prefTable tablesorter" id="preferenceBreakdownTable">
            <THEAD><TR><TH>Προτίμηση</TH><TH>Επιτυχείς Εγγραφές</TH><TH>Ανεπιτυχείς Εγγραφές</TH><TH>Σύνολο</TH></TR></THEAD>
            <TBODY>
            {foreach from=$preferenceBreakdown key=curPreferenceNum item=curPreference}
                {if $curPreference.totalRegistrations > 0}
                    <TR>
                        <TD class="hours">{$curPreferenceNum}</TD>
                        <TD class="valid">{$curPreference.successfulRegistrations} ({math equation="x/t*100" t=$curPreference.totalRegistrations x=$curPreference.successfulRegistrations format="%.1f"}%)</TD>
                        <TD class="invalid">{$curPreference.failedRegistrations} ({math equation="x/t*100" t=$curPreference.totalRegistrations x=$curPreference.failedRegistrations format="%.1f"}%)</TD>
                        <TD class="warning">{$curPreference.totalRegistrations}</TD>
                    </TR>
                {/if}
            {/foreach}
            </TBODY>
        </TABLE>
        <p></p>
        Σπουδαστές που δεν γράφτηκαν σε κανένα τμημα, εμφάνιση κατά μάθημα:<BR>
        <TABLE width=95% height=95% class="prefTable tablesorter" id="failedCourseBreakdownTable">
            <THEAD><TR><TH>Μάθημα</TH><TH>Σπουδαστές</TH></TR></THEAD>
            <TBODY>
            {foreach from=$failedCourseBreakdown key=curCourseID item=curCourse}
                {if $curCourse.failedRegistrations > 0}
                    <TR style="height:35px">
                        <TD class="hours" style="width:15%">
                            {$curCourse.courseName}
                        </TD>
                        <TD class="invalid">
                            {$curCourse.failedRegistrations}<BR>
                            (<a href="?module=ViewStatistics&displayFailedRegistrationStudents={$curCourseID}&showLottery={$curLotteryID}" onClick="return popup(this, 'failedRegistrationStudents')"><span style="text-decoration: underline">Εμφάνιση</span></a>)
                        </TD>
                    </TR>
                {/if}
            {/foreach}
            </TBODY>
        </TABLE>
        <span class="note">* Οι σπουδαστές που δεν είχαν ορίσει καμία προτιμήση δεν προσμετρώνται στον παραπάνω πίνακα.</span>
        <p></p>
        Ποσοστά εγγραφών ανά μάθημα:<BR>
        {if isset($smarty.get.showCourseBreakdown)}
            <a href="?module=ViewStatistics&showLottery={$curLotteryID}#hideSidebar">Απόκρυψη</a>
            {include file="templates/modules/ViewStatistics/CourseBreakdown.tpl"}
        {else}
            <div class="warning">Το στατιστικό αυτό ενδέχεται να περιέχει μεγάλο αριθμό γραμμών και έχει αποκρυφθεί.<BR>
            Εαν θέλετε να το εμφανίσετε επιλέξτε τον παρακάτω σύνδεσμο.</div>
            <a href="?module=ViewStatistics&showCourseBreakdown&showLottery={$curLotteryID}#hideSidebar">Εμφάνιση</a>
        {/if}
        <p></p>
</div>