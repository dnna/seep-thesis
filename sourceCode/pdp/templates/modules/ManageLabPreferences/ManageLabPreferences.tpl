{* Smarty template *}

{assign var="pageTitle" value="Δήλωση Προτιμήσεων"}
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
        <BR>
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
        <BR>
	<div>
		<h2 class="sectiontitle">Εργαστήρια Χωρίς Παρακολούθηση</h2>
		<div style='position:relative;left:10%;width:80%'>
                {if count($oldStudentAlreadyRegisteredChoices) > 0}
                    {section name=curChoice loop=$oldStudentAlreadyRegisteredChoices}
                            {if $oldStudentAlreadyRegisteredChoices[curChoice]->isPicked() == true}
                                    <div class='curChoice'>{$oldStudentAlreadyRegisteredChoices[curChoice]->getName()}
                            {else}
                                    <div class='{$oldStudentAlreadyRegisteredChoices[curChoice]->getColorClass()}' onclick="location.href='{$oldStudentAlreadyRegisteredChoices[curChoice]->getURL()}&format=OldStudent';" style="cursor: pointer;"
                                         onMouseOver="this.oldBackgroundColor=this.style.backgroundColor;this.style.backgroundColor='#FFFFFF';" onMouseOut="this.style.backgroundColor=this.oldBackgroundColor;">
                                        <a href={$oldStudentAlreadyRegisteredChoices[curChoice]->getURL()}&format=OldStudent>{$oldStudentAlreadyRegisteredChoices[curChoice]->getName()}</a>
                            {/if}
                            </div>
                    {/section}
                {else}
                    Δεν έχετε εγγραφεί ως παλαιός σπουδαστής σε κανένα μάθημα.
                {/if}
		</div>
	</div>
</div>
<a href="#" style="display:none" id="separator" onclick="toggleSidebar();"></a>
<div id="rightcolumn" style="min-height:{(count($lessonChoices) * 120) + (count($oldStudentAlreadyRegisteredChoices) * 80)}px">
	<h2 class="sectiontitle">{$pageTitle}</h2>
		{foreach from=$schedules item=schedule}
			{$schedule}
		{/foreach}
	<p class="subsectioncontent"></p>
</div>

{include file="templates/footer.tpl"}