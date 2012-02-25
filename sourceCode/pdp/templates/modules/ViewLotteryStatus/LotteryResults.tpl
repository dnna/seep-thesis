{* Smarty template *}

<form method="POST" action="?module=ViewLotteryStatus&withdraw">
        <span style="font-weight:bold">Επιτυχείς Εγγραφές</span>
	<TABLE class="prefTable" id="prefTable">
	<TR><TH>Μάθημα</TH><TH>Τμήμα</TH><TH>Ημέρα</TH><TH>Ώρα</TH><TH>Αποτέλεσμα</TH><TH>Ενέργεια</TH></TR>
	{foreach from=$allocatedLabs item=allotedLab}
	<TR class="valid">
	<TD>{$allotedLab.courseName}</TD>
	<TD>{$allotedLab.labName}</TD>
	<TD>{$allotedLab.dayName}</TD>
	<TD>{$allotedLab.ttime}</TD>
	<TD><span style="color:darkgreen">√</span></TD>
        <TD><a href="?module=ViewLotteryStatus&withdraw={$allotedLab.courseID}_{$allotedLab.labID}"><span style="text-decoration: underline;">Αποχώρηση</span></a></TD>
	</TR>
	{/foreach}
        </TABLE>
        <BR>
        <span style="font-weight:bold">Αποτυχία Εγγραφής σε Εργαστηριακά Μαθήματα</span>
        <TABLE class="prefTable" id="prefTable">
        <TR>{*<TH>Ημ/νία που έγινε η κλήρωση</TH>*}<TH>Μάθημα</TH>{*<TH>Λόγος Αποτυχίας</TH>*}</TR>
	{foreach from=$failedRegistrationsCourses item=failedRegistrationCourse}
	<TR class="invalid">
	{*<TD>{$failedRegistrationCourse.lotDate}</TD>*}
	<TD>{$failedRegistrationCourse.courseName}</TD>
	{*<TD>{$failedRegistrationCourse.failReason}</TD>*}
	</TR>
	{/foreach}
	</TABLE>
        <BR>
        <span style="font-weight:bold">Μη-Επιτυχείς Εγγραφές σε Τμήματα Υψηλότερης Προτεραιότητας</span>
        <TABLE class="prefTable" id="prefTable">
        <TR><TH>Μάθημα</TH><TH>Τμήμα</TH><TH>Ημέρα</TH><TH>Ώρα</TH><TH>Λόγος Αποτυχίας</TH></TR>
	{foreach from=$failedRegistrationsLabs item=failedRegistrationLab}
	<TR class="invalid">
	<TD>{$failedRegistrationLab.courseName}</TD>
	<TD>{$failedRegistrationLab.labName}</TD>
	<TD>{$failedRegistrationLab.dayName}</TD>
	<TD>{$failedRegistrationLab.ttime}</TD>
	<TD>{$failedRegistrationLab.failReason}</TD>
	</TR>
	{/foreach}
	</TABLE>
</form>