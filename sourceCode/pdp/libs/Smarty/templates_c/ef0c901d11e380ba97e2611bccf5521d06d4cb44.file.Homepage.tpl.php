<?php /* Smarty version Smarty-3.0.7, created on 2011-03-30 02:07:40
         compiled from "./templates/modules/Homepage/Homepage.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1946834234d92663cc47142-68408816%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ef0c901d11e380ba97e2611bccf5521d06d4cb44' => 
    array (
      0 => './templates/modules/Homepage/Homepage.tpl',
      1 => 1301440059,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1946834234d92663cc47142-68408816',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<?php $_smarty_tpl->tpl_vars["pageTitle"] = new Smarty_variable("Αρχική Σελίδα", null, null);?>
<?php $_template = new Smarty_Internal_Template("templates/header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<div>
	<h2 class="sectiontitle"><?php echo $_smarty_tpl->getVariable('pageTitle')->value;?>
</h2> 
	<p class="sectioncontent">
                <strong>Για αυθεντικοποίηση μπορείτε να χρησιμοποιήσετε το λογαριασμό που έχετε στο<BR>
                    <a href="http://eclass.cs.teiath.gr">http://eclass.cs.teiath.gr</a></strong><BR>
                <BR>
                <strong>Υλοποιήθηκε στα πλαίσια της πτυχιακής εργασίας του Δημοσθένη Νικούδη<BR>
                για το Τεχνολογικό Εκπαιδευτικό Ίδρυμα Αθήνας</strong><BR>
                <BR>
                <strong>Σύστημα κληρώσεων:</strong><BR>
                Έμπειρο Σύστημα υλοποιημένο σε Java/Jess.<BR>
                <BR>
                <strong>Περιβάλλον Δήλωσης Προτιμήσεων:</strong><BR>
                PHP, MySQL και SOAP Client.
	</p>
</div>

<?php $_template = new Smarty_Internal_Template("templates/footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>