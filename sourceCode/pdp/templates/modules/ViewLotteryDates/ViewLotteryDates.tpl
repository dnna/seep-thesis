{* Smarty template *}

{assign var="pageTitle" value="Ημερομηνίες Κληρώσεων"}
{include file="templates/header.tpl"}

<h2 class="sectiontitle">{$pageTitle}</h2> 

<div style='position:relative;left:10%;width:80%'>
    <h2 class="subsectiontitle">Μελλοντικές</h2>
    <table width=95% height=95% class="prefTable" id="prefTable">
    <tr><th>Ημερομηνία</th><th>Ώρα</th></tr>
    {section name=curLottery loop=$futureLotteryChoices}
            {assign var=curLottery value=$futureLotteryChoices[curLottery]->getDate()}
            <tr><td>{$curLottery[0]|date_format:"%D"}</td><td>{$curLottery[1]}</td></tr>
    {/section}
    </table>
    <p class="subsectioncontent"></p>
    
    <h2 class="subsectiontitle">Προηγούμενες</h2>
    <table width=95% height=95% class="prefTable" id="prefTable">
    <tr><th>Ημερομηνία</th><th>Ώρα</th></tr>
    {section name=curLottery loop=$completedLotteryChoices}
            {assign var=curLottery value=$completedLotteryChoices[curLottery]->getDate()}
            <tr><td>{$curLottery[0]|date_format:"%D"}</td><td>{$curLottery[1]}</td></tr>
    {/section}
    </table>
    
    <p class="subsectioncontent"></p>
</div>

{include file="templates/footer.tpl"}