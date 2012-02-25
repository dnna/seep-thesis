{* Smarty template *}

{if $pageBreak == true}
	<p class="subsectioncontent" style="page-break-after: always;">
{else}
	<p class="subsectioncontent">
{/if}
	<form action="?module=ManageLabPreferences&ProcessStatement" id="statementForm" method="POST" onsubmit="return confirm(this);">
	<div class="NonPrintable">
        <div class="note" style="display:none" id="selectionNote"><strong>Σημείωση:</strong> Μπορείτε να ταξινομήσετε πολλές στήλες ταυτόχρονα κρατώντας πατημένο το SHIFT.</div>
	<div id="noChoicesDivTop" class="warning" style="display:none;">Υπάρχουν μαθήματα, στην παρακάτω λίστα, στα οποία δεν έχετε επιλέξει καμία προτίμηση.</div>
	<div id="sameLabDivTop" class="invalid" style="display:none;">Έχετε ορίσει ίδια προτίμηση σε διαφορετικά τμήματα του ίδιου μαθήματος.</div>
	<div id="wrongOrderDivTop" class="invalid" style="display:none;">Οι προτιμήσεις των τμημάτων για κάθε μάθημα πρέπει να αυξάνονται με βήμα 1.</div>
	<div id="validStateDivTop" class="valid" style="display:none;">Οι τρέχουσες επιλογές σας είναι έγκυρες. Πιέστε το κουμπί "Καταχώρηση" για να τις αποθηκεύσετε.</div>
	<div id="javascriptOffDivTop" class="warning" style="display:block;">Για την καλύτερη λειτουργία αυτής της σελίδας προτείνεται η ενεργοποίηση του Javascript στον browser σας.</div>
	</div>
	<TABLE style="width:95%;height:95%" class="prefTable tablesorter" id="prefTable">
	<THEAD>
        <TR>
		<TH>Μάθημα</TH>
        <TH>Όνομα Τμήματος</TH>
        <TH>Ημέρα</TH>
        <TH>Ώρα</TH>
        <TH>Αριθμός Εγγεγραμένων Σπουδαστών</TH>
        <TH>Αριθμός Σπουδαστών που το έχουν δηλώσει σαν Πρώτη Προτίμηση</TH>
        <TH>Επιλογή Προτίμησης</TH>
        </TR>
	</THEAD>
	<TBODY>
	{foreach from=$schedule item=entry key=entryNum}
                {if $entry.ScheduleEntry->getcourseType() == 'Εργαστήριο'}
                {assign var='combinedID' value=$entry.ScheduleEntry->getcourseID()|cat:'_'|cat:$entry.ScheduleEntry->getlabID()}
                        <TR style="background-color: {$entry.ScheduleEntry->getColor()};">
                        <TD>{$entry.ScheduleEntry->getCourseName()}</TD>
                        <TD>{$entry.ScheduleEntry->getLabName()}</TD>
                        <TD>{$entry.day}</TD>
                        <TD>{$entry.time}</TD>
                        <TD>{$entry.ScheduleEntry->getNumStudents()}/{$entry.ScheduleEntry->getMaxStudents()}</TD>
                        <TD>{$entry.ScheduleEntry->getFirstPriorityCount()}</TD>
                        <TD>
                        {if $entry.ScheduleEntry->isAllocatedToThis() == true}
                                <div class="theoryBackground">
                                        <div class="lab" style="background-color: {$entry.ScheduleEntry->getColor()};">
                                        <a href="?module=ViewLotteryStatus&withdraw={$entry.ScheduleEntry->getcourseID()}_{$entry.ScheduleEntry->getlabID()}"><span style="color:green;text-decoration: underline;">Αποχώρηση</span></a>
                        {else}
                                <div class="warningBackground" id="div_{$entry.ScheduleEntry->getcourseID()}_{$entry.ScheduleEntry->getlabID()}">
                                        <div class="lab" style="background-color: {$entry.ScheduleEntry->getColor()};">

                                        <select class="warning" name="pref_{$entry.ScheduleEntry->getcourseID()}_{$entry.ScheduleEntry->getlabID()}" id="pref_{$entry.ScheduleEntry->getcourseID()}_{$entry.ScheduleEntry->getlabID()}" onfocusin="chooseNextPrio(this); return true;" onfocus="chooseNextPrio(this); return true;" onchange="updateValidity(); return true;">
                                        <option value="none">Καμία</option>
                                        {section name=curPref loop=8}
                                                {if $currentPreferences.$combinedID == $smarty.section.curPref.iteration}
                                                        {assign var='selected' value=' selected="selected"'}
												{else}
														{assign var='selected' value=''}
                                                {/if}
                                                <option value="{$smarty.section.curPref.iteration}"{$selected}>{$smarty.section.curPref.iteration}</option>
                                                {assign var='selected' value=''}
                                        {/section}
                                        </select>
                                {/if}
                {/if}
                                </div>
                        </div>
                </TD>
                </TR>
	{/foreach}
	</TBODY>
	</TABLE>
	<div>
		<p><input type="submit" class="NonPrintable" name="submitted" value="Καταχώρηση">
		<input type="reset" class="NonPrintable" value="Ακύρωση Αλλαγών" onclick="this.onkeypress();" onkeypress="resetUpdate(event); return true;">
                {if $smarty.get.showLesson == null}
                    {assign var='onclickcontent' value="alert('Πρέπει να επιλέξετε κάποιο εργαστηριακό μάθημα από την λίστα μαθημάτων, αριστερά, για να εγγραφείτε ως παλαιός σπουδαστής.');"}
                {else}
                    {assign var='onclickcontent' value="window.location = '?module=ManageLabPreferences&showLesson="|cat:$smarty.get.showLesson|cat:"&format=OldStudent'"}
                {/if}
                <input type="button" class="NonPrintable" value="Εγγραφή ως Παλαιός Σπουδαστής" onclick="{$onclickcontent}" onkeypress="resetUpdate(event); return true;"></p>
	</div>
	</form>
</p>