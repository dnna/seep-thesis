{* Smarty template *}

{assign var="pageTitle" value="Επιτυχής Επεξεργασία"}
{include file="templates/header.tpl"}

<div>
	<h2 class="sectiontitle">{$pageTitle}</h2> 
	<p class="sectioncontent">
		Οι κληρώσεις ενημερώθηκαν με επιτυχία.
	</p>
	<p class="sectioncontent">
		<a href="{$referer}"><u>Επιστροφή</u></a>
	</p>
</div>

{include file="templates/footer.tpl"}