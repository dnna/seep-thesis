{* Smarty template *}

{if $pageBreak == true}
	<p class="subsectioncontent" style="page-break-after: always;">
{else}
	<p class="subsectioncontent">
{/if}
{if $semesterNum != null}
	<h3 class="subsectiontitle">Εξάμηνο {$semesterNum}</h3>
{/if}
	<TABLE width=95% height=95% class="prefTable">
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
                                    ({$entry->getcourseType()})<BR>
				{else}
                                    <div class="lab" style="background-color: {$entry->getColor()};">
                                    {$entry->getCourseName()}{if $entry->getCourseName() !== $entry->getLabName()}<BR>
                                    ({$entry->getLabName()}){/if}<BR>
				{/if}
                                {if $entry->getTeacherName() !== '-'}
                                    <span style="font-style:italic">{$entry->getTeacherName()}</span><BR>
                                {/if}
				</div>
			{/foreach}
			</TD>
		{/foreach}
		</TR>
	{/foreach}
	</TABLE>
</p>