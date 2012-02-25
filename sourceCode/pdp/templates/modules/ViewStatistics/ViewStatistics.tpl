{* Smarty template *}

{assign var="pageTitle" value="Εμφάνιση Στατιστικών Στοιχείων"}
{include file="templates/header.tpl"}

<div id="leftcolumn" class="NonPrintable">
        <h2 class="subsectiontitle">Ημ/νίες Ολοκληρωμένων Κληρώσεων</h2>
	<div style='position:relative;left:10%;width:80%'>
            {if count($completedLotteryChoices) > 1}
                {section name=curLottery loop=$completedLotteryChoices start=1}
                        {if $completedLotteryChoices[curLottery]->isInProgress()}
                            {assign var='lotteryInProgress' value=$completedLotteryChoices[curLottery]->getDate()}
                            <div class="choice">
                                    {$completedLotteryChoices[curLottery]->getDate()}
                                    <BR>
                                    (Σε εξέλιξη)
                            </div>
                        {else}
                            <div class="curChoice">
                                    {$completedLotteryChoices[curLottery]->getDate()}
                            </div>
                        {/if}
                {/section}
            {/if}
	</div>
</div>
<a href="#" style="display:none" id="separator" onclick="toggleSidebar();"></a>
<div id="rightcolumn" style="min-height:400px">
	<h2 class="sectiontitle">{$pageTitle}</h2>
        {if !empty($lotteryChoices) && !empty($curLottery)}
            <div class="valid">Κλήρωση <span style="font-weight:bold">{$curLottery[0].lotDate}</span></div>
            <p></p>
            {$curStatistics}
        {else if empty($lotteryChoices)}
            <div class="invalid">Αυτή τη στιγμή δεν υπάρχουν κληρώσεις που να έχουν ολοκληρωθεί.</div>
        {else}
            <div class="invalid">Η κλήρωση που επιλέξατε δεν είναι έγκυρη.</div>
        {/if}
	<p class="subsectioncontent"></p>
</div>

{include file="templates/footer.tpl"}