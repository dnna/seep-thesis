{* Smarty template *}

{if $pageBreak == true}
	<p class="subsectioncontent" style="page-break-after: always;">
{else}
	<p class="subsectioncontent">
{/if}
	<form action="?module=ManageLabPreferences&ProcessStatement" id="statementForm" method="POST" onsubmit="return confirm(this);">
	<div class="NonPrintable">
	<div id="noChoicesDivTop" class="warning" style="display:none;">Υπάρχουν μαθήματα, στον παρακάτω πίνακα, στα οποία δεν έχετε επιλέξει καμία προτίμηση.</div>
	<div id="sameLabDivTop" class="invalid" style="display:none;">Έχετε ορίσει ίδια προτίμηση σε διαφορετικά τμήματα του ίδιου μαθήματος.</div>
	<div id="wrongOrderDivTop" class="invalid" style="display:none;">Οι προτιμήσεις των τμημάτων για κάθε μάθημα πρέπει να αυξάνονται με βήμα 1.</div>
	<div id="validStateDivTop" class="valid" style="display:none;">Οι τρέχουσες επιλογές σας είναι έγκυρες. Πιέστε το κουμπί "Καταχώρηση" για να τις αποθηκεύσετε.</div>
	<div id="javascriptOffDivTop" class="warning" style="display:block;">Για την καλύτερη λειτουργία αυτής της σελίδας προτείνεται η ενεργοποίηση του Javascript στον browser σας.</div>
	</div>
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
                                        {assign var='combinedID' value=$entry->getcourseID()|cat:'_'|cat:$entry->getlabID()}
					{if $entry->isAllocatedToThis() == true}
						<div class="theoryBackground">
						<div class="lab" style="background-color: {$entry->getColor()};">
						{$entry->getCourseName()}{if $entry->getCourseName() !== $entry->getLabName()}<BR>({$entry->getLabName()}){/if}<BR>
                                                (Εγγεγραμμένοι: {$entry->getNumStudents()}/{$entry->getMaxStudents()})<BR>
						(Κληρωμένο Εργαστήριο)<BR>
						(<a href="?module=ViewLotteryStatus&withdraw={$entry->getcourseID()}_{$entry->getlabID()}"><span style="color:green;text-decoration: underline;">Αποχώρηση</span></a>)
					{else}
						<div class="warningBackground" id="div_{$entry->getcourseID()}_{$entry->getlabID()}">
							<div class="lab" style="background-color: {$entry->getColor()};">
							{$entry->getCourseName()}{if $entry->getCourseName() !== $entry->getLabName()}<BR>({$entry->getLabName()}){/if}<BR>
                                                        (Εγγεγραμμένοι: {$entry->getNumStudents()}/{$entry->getMaxStudents()})<BR>
                                                        (Πρώτη Προτίμηση: {$entry->getFirstPriorityCount()})<BR>
							<select class="warning" name="pref_{$entry->getcourseID()}_{$entry->getlabID()}" id="pref_{$entry->getcourseID()}_{$entry->getlabID()}" onfocusin="chooseNextPrio(this); return true;" onfocus="chooseNextPrio(this); return true;" onchange="updateValidity(); return true;">
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
			{/foreach}
			</TD>
		{/foreach}
		</TR>
	{/foreach}
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