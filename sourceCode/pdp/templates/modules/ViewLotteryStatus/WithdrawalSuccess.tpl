{* Smarty template *}

{assign var="pageTitle" value="Επιτυχής Αποχώρηση"}
{include file="templates/header.tpl"}

<div>
	<h2 class="sectiontitle">{$pageTitle}</h2> 
	<p class="sectioncontent">
		Αποχωρήσατε από το εργαστηριακό τμήμα με επιτυχία.
	</p>
	<p class="sectioncontent">
		<a href="?module=ViewLotteryStatus"><u>Αποτελέσματα Κληρώσεων</u></a>
	</p>
	<p class="sectioncontent">
		<a href="."><u>Αρχική Σελίδα</u></a>
	</p>
</div>

{include file="templates/footer.tpl"}