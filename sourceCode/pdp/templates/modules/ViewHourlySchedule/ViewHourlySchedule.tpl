{* Smarty template *}

{assign var="pageTitle" value="Ωρολόγιο Πρόγραμμα"}
{include file="templates/header.tpl"}

<div id="leftcolumn" class="NonPrintable">
	<h2 class="sectiontitle">Εξάμηνα</h2> 
	<div>
		<div style='position:absolute;left:10%;width:80%'>
		{section name=curChoice loop=$semesterChoices}
			{if $semesterChoices[curChoice]->isPicked() == true}
			<div class='curChoice'>
				{$semesterChoices[curChoice]->getName()}
			{else}
			<div class='{$semesterChoices[curChoice]->getColorClass()}' onclick="location.href='{$semesterChoices[curChoice]->getURL()}';" style="cursor: pointer;"
			onMouseOver="this.oldBackgroundColor=this.style.backgroundColor;this.style.backgroundColor='#FFFFFF';" onMouseOut="this.style.backgroundColor=this.oldBackgroundColor;">
				<a href={$semesterChoices[curChoice]->getURL()}>{$semesterChoices[curChoice]->getName()}</a>
			{/if}
			</div>
		{/section}
		</div>
	</div>
</div>
<a href="#" style="display:none" id="separator" onclick="toggleSidebar();"></a>
<div id="rightcolumn" style="min-height:400px">
	<h2 class="sectiontitle">{$pageTitle}</h2> 
		{foreach from=$schedules item=schedule}
			{$schedule}
		{/foreach}
	<p class="subsectioncontent"></p>
</div>

{include file="templates/footer.tpl"}