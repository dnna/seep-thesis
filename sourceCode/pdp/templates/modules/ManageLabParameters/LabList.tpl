{* Smarty template *}

{if $pageBreak == true}
	<p class="subsectioncontent" style="page-break-after: always;">
{else}
	<p class="subsectioncontent">
{/if}
        <div class="note" style="display:none" id="selectionNote"><strong>Σημείωση:</strong> Μπορείτε να ταξινομήσετε πολλές στήλες ταυτόχρονα κρατώντας πατημένο το SHIFT.</div>
	<TABLE style="width:95%;height:95%" class="prefTable tablesorter" id="prefTable">
	<THEAD>
	<TR>
	<TH>Όνομα Τμήματος</TH>
	<TH>Ημέρα</TH>
	<TH>Ώρα</TH>
	<TH>Έχουν Κληρωθεί</TH>
	<TH>Μέγεθος</TH>
	<TH>Σπουδαστές σε αναμονή που το έχουν δηλώσει σαν Πρώτη Προτίμηση</TH>
	<TH>Καθηγητής</TH>
	</TR>
	</THEAD>
	<TBODY>
	{foreach from=$schedule item=entry key=entryNum}
                {if $entry.ScheduleEntry->getcourseType() == 'Εργαστήριο'}
                {assign var='labID' value=$entry.ScheduleEntry->getlabID()}
                {assign var='selectedTeacherID' value=$entry.ScheduleEntry->getTeacherID()}
                        <TR style="background-color: {$entry.ScheduleEntry->getColor()};">
                        <TD>{$entry.ScheduleEntry->getLabName()}</TD>
                        <TD>{$entry.day}</TD>
                        <TD>{$entry.time}</TD>
                        <TD>{$entry.ScheduleEntry->getNumStudents()}<BR>
                            (<a href="?module={$curModule}&displayRegisteredStudents={$entry.ScheduleEntry->getcourseID()|cat:'_'|cat:$entry.ScheduleEntry->getlabID()}" onClick="return popup(this, 'regStudents')">Εμφάνιση</a>)</TD>
                        <TD>{$entry.ScheduleEntry->getMaxStudents()}</TD>
                        <TD>{$entry.ScheduleEntry->getFirstPriorityCount()}</TD>
                        <TD><span style="font-style:italic">{$entry.ScheduleEntry->getTeacherName()}</span></TD>
                        </TR>
                {/if}
	{/foreach}
	</TBODY>
	</TABLE>
</p>