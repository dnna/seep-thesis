{* Smarty template *}

{assign var="pageTitle" value="Επεξεργασία Προτεραιοτήτων Εγγραφής"}
{include file="templates/header.tpl"}

<div>
	<h2 class="sectiontitle">{$pageTitle}</h2> 
	<p class="sectioncontent">
            <form action="?module=ManageRegistrationPriorities&ProcessStatement" id="statementForm" method="POST">
            <TABLE style="width:95%;height:95%" class="prefTable" id="prefTable">
                <TR><TH>Προτεραιότητα</TH><TH>Ενεργοποιημένη</TH><TH>Όνομα</TH><TH>Query</TH></TR>
            {foreach from=$registrationPriorities item=curPriority}
                <TR>
                <TD style="width:10%">{$curPriority.rpPrio}</TD>
                <TD style="width:10%">
                    <input type="hidden" name="enabled_{$curPriority.rpId}" value="no">
                    {if $curPriority.rpEnabled === "1"}
                        <input type="checkbox" name="enabled_{$curPriority.rpId}" value="yes" checked />
                    {else}
                        <input type="checkbox" name="enabled_{$curPriority.rpId}" value="yes" />
                    {/if}
                </TD>
                <TD style="width:30%"><input type="text" name="name_{$curPriority.rpId}" maxlength=100 style="width:98%" value="{$curPriority.rpName}" /></TD>
                <TD style="width:50%"><input type="text" name="parameters_{$curPriority.rpId}" maxlength=255 style="width:98%" value="{$curPriority.rpParameters}" /></TD>
                </TR>
            {/foreach}
            </TABLE>
        </p>
        <p><a href="?module=ManageRegistrationPriorities">Απλή Μορφή</a></p>
        <p><input type="submit" class="NonPrintable" name="submitted" value="Καταχώρηση">
        <input type="reset" class="NonPrintable" value="Ακύρωση Αλλαγών"></p>
        </form>
        <p class="subsectioncontent"></p>
</div>

{include file="templates/footer.tpl"}