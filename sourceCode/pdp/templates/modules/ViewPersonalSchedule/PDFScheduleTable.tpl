{* Smarty template *}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta http-equiv="content-language" content="gr" />
    <meta http-equiv="pragma" content="no-cache" />
{literal}
    <style type="text/css">
    .sectiontitle {margin:0 0.5em;padding:0;font-size:1.5em;text-align:center;}
    .sectioncontent {margin:0 0.5em 0.5em;padding:0.5em;font-size:1em;text-align:center;}
    .footerDate {text-align:center;}
    table.prefTable {
            border-collapse: collapse;
            /*empty-cells:show;*/
    }
    table.prefTable th {
            border-width: 1px 1px 1px 1px;
            padding: 4px 4px 4px 4px;
            border-style: solid solid solid solid;
            border-color: black black black black;
    }
    table.prefTable tr { }
    table.prefTable td {
            border-width: 1px 1px 1px 1px;
            padding: 4px 4px 4px 4px;
            border-style: solid solid solid solid;
            border-color: black black black black;
    }
    table.prefTable td.hours {
            font-weight: bold;
    }
    .theory {
            background-color: #E6E7FF;
            border-width: 1px 1px 1px 1px;
            padding: 4px 4px 4px 4px;
            border-style: dotted dotted dotted dotted;
            border-color: black;
            text-align:center;
    }
    .lab {
            background-color: #FFF4D4;
            border-width: 1px 1px 1px 1px;
            padding: 4px 4px 4px 4px;
            border-style: solid solid solid solid;
            border-color: black;
            text-align:center;
    }
</style>
{/literal}
</head>
<body>
    <div>
    <div><h2 class="sectiontitle">Προσωπικό Ωρολόγιο Πρόγραμμα</h2></div>
    <div><h2 class="sectiontitle">{$auth->getFirstName()} {$auth->getLastName()}</h2></div>
    <TABLE class="prefTable">
    <TR><TH width="24px"></TH>
    {foreach name=day from=$days item=day key=dayName}
            <TH>{$day[1]}</TH>
    {/foreach}
    </TR>
    {foreach from=$schedule item=hour key=hourName}
            <TR><TD class="hours" width="24px">{$hourName}</TD>
            {foreach from=$hour item=day key=dayName}
                    <TD style="padding: 4px 4px 4px 4px;">
                    {foreach from=$day item=entry}
                            {if $entry->getcourseType() == 'Θεωρία'}
                                    <div class="theory">
                                    <div>{$entry->getCourseName()}</div>
                                    <div>({$entry->getcourseType()})</div>
                            {else}
                                    {assign var='combinedID' value=$entry->getcourseID()|cat:'_'|cat:$entry->getlabID()}
                                    <div class="lab" style="background-color: {$entry->getColor()};">
                                    <div>{$entry->getCourseName()}{if $entry->getCourseName() !== $entry->getLabName()}</div>
                                    <div>({$entry->getLabName()}){/if}</div>
                            {/if}
                            </div>
                    {/foreach}
                    </TD>
            {/foreach}
            </TR>
    {/foreach}
    </TABLE>
    <div class="footerDate">Πιο πρόσφατη κλήρωση: {$lastLotDate}</div>
    {*<div class="footerDate">Δημιουργήθηκε: {$smarty.now|date_format:"%m/%d/%Y %H:%M"}</div>*}
    </div>
</body>
</html>