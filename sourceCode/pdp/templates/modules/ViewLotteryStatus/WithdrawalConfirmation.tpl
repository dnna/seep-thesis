{* Smarty template *}

{assign var="pageTitle" value="Επιβεβαίωση Αποχώρησης"}
{include file="templates/header.tpl"}

<div>
	<h2 class="sectiontitle">Θέλετε σίγουρα να αποχωρήσετε από το συγκεκριμένο τμήμα;</h2>
	<BR>
	<TABLE class="prefTable" id="prefTable" style="width:50%">
	<TR>
        <TD>{$labInfo.courseName}</TD>
	<TD>{$labInfo.labName}</TD>
        {if $labInfo.dayName !== '-'}
            <TD>{$labInfo.dayName}</TD>
        {/if}
        {if $labInfo.dayName !== '-'}
            <TD>{$labInfo.ttime}</TD>
        {/if}
	</TR>
	</TABLE>
	<BR>
	<form method="POST" action="">
	<p class="sectioncontent">
		Αν ναί, πληκτρολογήστε ΝΑΙ (με κεφαλαία Ελληνικά γράμματα) ή YES (με κεφαλαία Αγγλικά γράμματα) και επιλέξτε το κουμπί Αποχώρηση.<BR>
		<label for="confirmTextbox">Επιβεβαίωση: </label><input type="text" name="confirmTextbox"><BR>
		<input type="submit" value="Αποχώρηση">
	</p>
	</form>
	<p class="sectioncontent">
		<a href="{$referer}"><u>Επιστροφή</u></a>
	</p>
</div>

{include file="templates/footer.tpl"}