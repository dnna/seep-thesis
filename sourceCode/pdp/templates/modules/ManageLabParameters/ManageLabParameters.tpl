{* Smarty template *}

{assign var="pageTitle" value="Εμφάνιση Κληρωθέντων Σπουδαστών"}
{include file="templates/header.tpl"}

<div id="leftcolumn" class="NonPrintable">
	<div>
		<h2 class="sectiontitle">Λίστα Εργαστηριακών Τμημάτων ανά Μάθημα</h2> 
		<div style='position:relative;left:10%;width:80%'>
		{section name=curChoice loop=$lessonChoices}
			{if $lessonChoices[curChoice]->isPicked() == true && $format === "LabList"}
			<div class='curChoice'>
				{$lessonChoices[curChoice]->getName()}
			{else}
			<div class='{$lessonChoices[curChoice]->getColorClass()}' onclick="location.href='{$lessonChoices[curChoice]->getURL()}&format=LabList';" style="cursor: pointer;"
			onMouseOver="this.oldBackgroundColor=this.style.backgroundColor;this.style.backgroundColor='#FFFFFF';" onMouseOut="this.style.backgroundColor=this.oldBackgroundColor;">
				<a href={$lessonChoices[curChoice]->getURL()}&format=LabList>{$lessonChoices[curChoice]->getName()}</a>
			{/if}
			</div>
		{/section}
		</div>
	</div>
	<div>
		<h2 class="sectiontitle">Πίνακας Εργαστηριακών Τμημάτων ανά Μάθημα</h2> 
		<div style='position:relative;left:10%;width:80%'>
		{section name=curChoice loop=$lessonChoices}
			{if $lessonChoices[curChoice]->isPicked() == true && ($format == null || $format !== "LabList")}
			<div class='curChoice'>
				{$lessonChoices[curChoice]->getName()}
			{else}
			<div class='{$lessonChoices[curChoice]->getColorClass()}' onclick="location.href='{$lessonChoices[curChoice]->getURL()}';" style="cursor: pointer;"
			onMouseOver="this.oldBackgroundColor=this.style.backgroundColor;this.style.backgroundColor='#FFFFFF';" onMouseOut="this.style.backgroundColor=this.oldBackgroundColor;">
				<a href={$lessonChoices[curChoice]->getURL()}>{$lessonChoices[curChoice]->getName()}</a>
			{/if}
			</div>
		{/section}
		</div>
	</div>
</div>
<a href="#" style="display:none" id="separator" onclick="toggleSidebar();"></a>
<div id="rightcolumn" style="min-height:400px">
	<h2 class="sectiontitle">{$pageTitle}</h2>
        <p><a href="?module={$curModule}&displayOldStudents={$courseID}" onClick="return popup(this, 'regStudents')">Εμφάνιση Παλαιών Σπουδαστών</a></p>
		{foreach from=$schedules item=schedule}
			{$schedule}
		{/foreach}
	<p class="subsectioncontent"></p>
</div>

{include file="templates/footer.tpl"}