{* Smarty template *}

{include file="templates/header.tpl"}

<div>
	<h2 class="sectiontitle">{$pageTitle}</h2> 
	<p class="sectioncontent">
		Περιγραφή Σφάλματος:<BR>{$exceptionDescription}
	</p>
	{if $referer != "" && $referer !== $request_uri}
		<p class="sectioncontent">
			<a href="{$referer}"><u>Επιστροφή</u></a>
		</p>
	{/if}
	<p class="sectioncontent">
		<a href="."><u>Αρχική Σελίδα</u></a>
	</p>
</div>

{include file="templates/footer.tpl"}