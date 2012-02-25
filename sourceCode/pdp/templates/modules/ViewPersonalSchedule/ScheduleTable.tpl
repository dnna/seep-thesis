{* Smarty template *}

{if $pageBreak == true}
	<p class="subsectioncontent" style="page-break-after: always;">
{else}
	<p class="subsectioncontent">
{/if}
{if $semesterNum != null}
	<h3 class="subsectiontitle">Εξάμηνο {$semesterNum}</h3>
{/if}
	<TABLE class="prefTable">
	<TR><TH></TH>
	{foreach name=day from=$days item=day key=dayName}
		<TH>{$day[1]}</TH>
	{/foreach}
	</TR>
	{foreach from=$schedule item=hour key=hourName}
		<TR><TD class="hours">{$hourName}</TD>
		{foreach from=$hour item=day key=dayName}
			<TD style="padding: 4px 4px 4px 4px;">
			{foreach from=$day item=entry}
				{if $entry->getcourseType() == 'Θεωρία'}
					<div class="theory">
					{$entry->getCourseName()}<BR>
					({$entry->getcourseType()})
				{else}
                                        {assign var='combinedID' value=$entry->getcourseID()|cat:'_'|cat:$entry->getlabID()}
					<div class="lab" style="background-color: {$entry->getColor()};">
					{$entry->getCourseName()}{if $entry->getCourseName() !== $entry->getLabName()}<BR>({$entry->getLabName()}){/if}<BR>
                                        <div class="NonPrintable">(Εγγεγραμμένοι: {$entry->getNumStudents()}/{$entry->getMaxStudents()})</div>
                                        {if $entry->isAllocatedToThis() == true}
						<div class="NonPrintable">(Κληρωμένο Εργαστήριο)</div>
						<div class="NonPrintable">(<a href="?module=ViewLotteryStatus&withdraw={$entry->getcourseID()}_{$entry->getlabID()}"><span style="color:green;text-decoration: underline;">Αποχώρηση</span></a>)</div>
					{else}
						<div class="NonPrintable">
                                                    {if isset($currentPreferences.$combinedID)}
                                                            (Αρ. Προτίμησης {$currentPreferences.$combinedID})
                                                    {else}
                                                            (<a href="?module=ManageLabPreferences&showLesson={$entry->getcourseID()}"><span style="color:darkred;text-decoration: underline;">Δεν έχει οριστεί προτίμηση</span></a>)
                                                    {/if}
                                                </div>
					{/if}
				{/if}
				</div>
			{/foreach}
			</TD>
		{/foreach}
		</TR>
	{/foreach}
	</TABLE>
</p>