<?php /* Smarty version Smarty-3.0.7, created on 2011-04-06 22:24:10
         compiled from "./templates/modules/ManageLabParameters/LabList.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18433290724d9cbddac31107-57157943%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '22bad2a8f6afa4a860e6f1b4de3b33cd87f7c0eb' => 
    array (
      0 => './templates/modules/ManageLabParameters/LabList.tpl',
      1 => 1302117838,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18433290724d9cbddac31107-57157943',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<?php if ($_smarty_tpl->getVariable('pageBreak')->value==true){?>
	<p class="subsectioncontent" style="page-break-after: always;">
<?php }else{ ?>
	<p class="subsectioncontent">
<?php }?>
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
	<?php  $_smarty_tpl->tpl_vars['entry'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['entryNum'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('schedule')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['entry']->key => $_smarty_tpl->tpl_vars['entry']->value){
 $_smarty_tpl->tpl_vars['entryNum']->value = $_smarty_tpl->tpl_vars['entry']->key;
?>
                <?php if ($_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getcourseType()=='Εργαστήριο'){?>
                <?php $_smarty_tpl->tpl_vars['labID'] = new Smarty_variable($_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getlabID(), true, null);?>
                <?php $_smarty_tpl->tpl_vars['selectedTeacherID'] = new Smarty_variable($_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getTeacherID(), true, null);?>
                        <TR style="background-color: <?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getColor();?>
;">
                        <TD><?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getLabName();?>
</TD>
                        <TD><?php echo $_smarty_tpl->tpl_vars['entry']->value['day'];?>
</TD>
                        <TD><?php echo $_smarty_tpl->tpl_vars['entry']->value['time'];?>
</TD>
                        <TD><?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getNumStudents();?>
<BR>
                            (<a href="?module=<?php echo $_smarty_tpl->getVariable('curModule')->value;?>
&displayRegisteredStudents=<?php echo (($_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getcourseID()).('_')).($_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getlabID());?>
" onClick="return popup(this, 'regStudents')">Εμφάνιση</a>)</TD>
                        <TD><?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getMaxStudents();?>
</TD>
                        <TD><?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getFirstPriorityCount();?>
</TD>
                        <TD><span style="font-style:italic"><?php echo $_smarty_tpl->getVariable('entry')->value['ScheduleEntry']->getTeacherName();?>
</span></TD>
                        </TR>
                <?php }?>
	<?php }} ?>
	</TBODY>
	</TABLE>
</p>