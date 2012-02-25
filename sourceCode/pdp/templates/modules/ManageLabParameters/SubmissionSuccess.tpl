{* Smarty template *}

{assign var="pageTitle" value="Επιτυχής Δήλωση"}
{include file="templates/header.tpl"}

<div>
	<h2 class="sectiontitle">{$pageTitle}</h2> 
	<p class="sectioncontent">
		Οι προτιμήσεις σας ενημερώθηκαν με επιτυχία.<BR>
	</p>
	<p class="sectioncontent">
		<a href="{$referer}"><u>Επιστροφή</u></a>
	</p>
</div>

{include file="templates/footer.tpl"}