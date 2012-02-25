{* Smarty template *}

{assign var="pageTitle" value="Αποτελέσματα Κληρώσεων"}
{include file="templates/header.tpl"}

<div id="leftcolumn" class="NonPrintable">
        <h2 class="subsectiontitle">Ημ/νίες Κληρώσεων</h2>
	<div style='position:relative;left:10%;width:80%'>
            {if !empty($futureLotteryChoices)}
                <h2 class="subsectiontitle">Μελλοντικές</h2>
                {section name=curLottery loop=$futureLotteryChoices}
                        <div class="choiceHighlighted">
                                {$futureLotteryChoices[curLottery]->getDate()}
                        </div>
                {/section}
            {/if}
                
            {if !empty($lastLottery)}
                <h2 class="subsectiontitle">Πιο πρόσφατη</h2>
                {if $lastLottery[0]->isInProgress()}
                    {assign var='lotteryInProgress' value=$lastLottery[0]->getDate()}
                    <div class="choice" style="font-weight:bold">
                            {$lastLottery[0]->getDate()}
                            <BR>
                            (Σε εξέλιξη)
                    </div>
                {else}
                    <div class="choiceHighlighted" style="font-weight:bold">
                            {$lastLottery[0]->getDate()}
                    </div>
                {/if}
            {/if}
                
            {if count($completedLotteryChoices) > 1}
                <h2 class="subsectiontitle">Προηγούμενες</h2>
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
        {if !empty($lastLottery)}
            <div class="valid">Κλήρωση <span style="font-weight:bold">{$lastLottery[0]->getDate()}</span></div>
            {if isset($lotteryInProgress)}
            <div class="warning">Αυτή τη στιγμή βρίσκεται σε εξέλιξη η κλήρωση: <span style="font-weight: bold">{$lotteryInProgress}</span><BR>
            Ανανεώστε αυτή τη σελίδα σε 5-10 λεπτά για να δείτε τα αποτελέσματα.</div>
            {/if}
            {$lotteryLog}
        {else}
            <div class="invalid">Αυτή τη στιγμή δεν υπάρχουν κληρώσεις που να έχουν ολοκληρωθεί.</div>
        {/if}
	<p class="subsectioncontent"></p>
</div>

{include file="templates/footer.tpl"}