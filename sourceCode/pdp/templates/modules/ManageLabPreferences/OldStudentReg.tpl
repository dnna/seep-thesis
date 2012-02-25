<span style="font-weight: bold">Εγγραφή Παλαιού Σπουδαστή</span>
<p>Πρόκειται να εγγραφείτε στο τμήμα παλαιών σπουδαστών του παρακάτω μαθήματος:</p>
<TABLE width=95% class="prefTable" id="prefTable">
    <TR><TD>{$lessonInfo.courseName}</TD></TR>
</TABLE>
<p>Για να συνεχίσετε πατήστε στο παρακάτω κουμπί:<BR>
<form action="?module=ManageLabPreferences&ProcessStatement&OldStudent" id="statementForm" method="POST">
		<input type="hidden" name="courseID" value="{$lessonInfo.courseID}">
		<input type="submit" class="NonPrintable" name="submitted" value="Εγγραφή">
</form>
</p>