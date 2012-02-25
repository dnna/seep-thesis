{* Smarty template *}

{assign var="pageTitle" value="Επιτυχής Αποστολή"}
{include file="templates/header.tpl"}

<div>
	<h2 class="sectiontitle">{$pageTitle}</h2> 
	<p class="sectioncontent">
		Τα σχόλια σας καταχωρήθηκαν με επιτυχία.
	</p>
	<p class="sectioncontent">
		<a href="{$referer}"><u>Επιστροφή</u></a>
	</p>
</div>

{include file="templates/footer.tpl"}