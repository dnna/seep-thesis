{* Smarty template *}

{assign var="pageTitle" value="Επεξεργασία Κληρώσεων"}
{include file="templates/header.tpl"}

<div>
	<h2 class="sectiontitle">{$pageTitle}</h2> 
	<p class="sectioncontent">
            <form action="?module=ManageLotteries&ProcessStatement" id="statementForm" method="POST">
            <b>Διαγραφή Μελλοντικών Κληρώσεων</b>
            <TABLE style="width:95%;height:95%" class="prefTable tablesorter" id="prefTable">
                <THEAD><TR><TH style="width:80%">Ημερομηνία και Ώρα</TH><TH style="width:20%" class="unsortable">Επιλογή</TH></TR></THEAD>
				<TBODY>
            {foreach from=$lotteries item=curLottery key=k}
                {assign var=curLotteryChoice value=$lotteryChoices.$k->getDate()}
                <TR>
                <TD style="width:10%">
                    {$curLotteryChoice[0]|date_format:"%D"} {$curLotteryChoice[1]}
                </TD>
                <TD>
                    <input type="hidden" name="delete_{$curLottery.lotID}" value="no" />
                    <input type="checkbox" name="delete_{$curLottery.lotID}" value="yes" />
                </TD>
                </TR>
            {/foreach}
			</TBODY>
            </TABLE>
            <p>
			<input type="submit" class="NonPrintable" name="submitted" value="Διαγραφή Επιλεγμένων"
                               onClick="if(confirm('Θέλετε σίγουρα να διαγράψετε τις επιλεγμένες κληρώσεις;')) return true; else return false;" >
            {*<input type="reset" class="NonPrintable" value="Αποεπιλογή Όλων">*}
			</form>
			</p>
        </p>
        <p class="sectioncontent">
            <form action="?module=ManageLotteries&ProcessStatement" id="statementForm" method="POST">
            <b>Εισαγωγή Νέας Κλήρωσης</b>
            <div class="warning">Οι κληρώσεις προτείνεται να απέχουν τουλάχιστον 24 ώρες μεταξύ τους.</div>
            <TABLE style="width:95%;height:95%" class="prefTable" id="prefTable">
                <TR><TH>
                    {* Το lotID στο όνομα παρακάτω θα αγνοηθεί γιατί καθορίζεται από την αποθήκη δεδομένων. *}
                    <input id="insert_0" name="insert_0" type="text" size="15" readonly />
                    <a href="javascript:NewCssCal('insert_0','mmddyyyy','arrow',true)">
                    <img src="templates/modules/ManageLotteries/images/cal.gif" width="16" height="16" style="border:none" alt="Επιλογή Ημερομηνίας"></a>
                </TH></TR>
            </TABLE>
            <p><input type="submit" class="NonPrintable" name="submitted" value="Εισαγωγή Κλήρωσης">
            <input type="reset" class="NonPrintable" value="Ακύρωση"></form></p>
            </form>
        </p>
        <p class="subsectioncontent"></p>
</div>

{include file="templates/footer.tpl"}