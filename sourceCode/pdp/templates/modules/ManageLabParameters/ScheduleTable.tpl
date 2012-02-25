{* Smarty template *}

{if $pageBreak == true}
	<p class="subsectioncontent" style="page-break-after: always;">
{else}
	<p class="subsectioncontent">
{/if}
	<TABLE width=95% height=95% class="prefTable" id="prefTable">
	<TR><TH></TH>
	{foreach name=day from=$days item=day key=dayName}
		<TH>{$day[1]}</TH>
	{/foreach}
	</TR>
	{foreach from=$schedule item=hour key=hourName}
		<TR><TD class="hours">{$hourName}</TD>
		{foreach from=$hour item=day key=dayName}
			<TD>
			{foreach from=$day item=entry key=entryNum}
				{if $entry->getcourseType() == 'Θεωρία'}
					<div class="theoryBackground">
						<div class="theory">
						{$entry->getCourseName()}<BR>
						({$entry->getcourseType()})
				{else}
                                    {assign var='labID' value=$entry->getlabID()}
                                    {assign var='selectedTeacherID' value=$entry->getTeacherID()}
                                            <div class="warningBackground" id="div_{$entry->getcourseID()}_{$entry->getlabID()}">
                                                    <div class="lab" style="background-color: {$entry->getColor()};">
                                                    Μάθημα:{$entry->getCourseName()}<BR>
                                                    Όνομα: {$entry->getLabName()}<BR>
                                                    Μέγεθος: {$entry->getMaxStudents()}<BR>
                                                    {*Παλαιών Φοιτητών:
                                                    <select class="warning" name="labOldStudents_{$entry->getcourseID()}_{$entry->getlabID()}">
                                                        <option value="0"{if $entry->isForOldStudents() === "0"} selected="selected"{/if}>Όχι</option>
                                                        <option value="1"{if $entry->isForOldStudents() === "1"} selected="selected"{/if}>Ναί</option>
                                                    </select><BR>*}
                                                    (Πρώτη Προτίμηση: {$entry->getFirstPriorityCount()})<BR>
                                                    <span style="font-style:italic">{$entry->getTeacherName()}</span><BR>
                                                    Έχουν Κληρωθεί: {$entry->getNumStudents()}<BR>(<a href="?module={$curModule}&displayRegisteredStudents={$entry->getcourseID()|cat:'_'|cat:$entry->getlabID()}" onClick="return popup(this, 'regStudents')">Εμφάνιση</a>)<BR>
				{/if}
						</div>
					</div>
			{/foreach}
			</TD>
		{/foreach}
		</TR>
	{/foreach}
	</TABLE>
</p>