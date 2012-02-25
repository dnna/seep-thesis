<?php /* Smarty version Smarty-3.0.7, created on 2011-03-28 00:19:40
         compiled from "./templates/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5371916374d8fa9ec349dc0-02894145%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '97c13ae6868bbc459509c9f1b968154acd23eecc' => 
    array (
      0 => './templates/header.tpl',
      1 => 1301260746,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5371916374d8fa9ec349dc0-02894145',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $_smarty_tpl->getVariable('pageTitle')->value;?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="content-language" content="gr" />
<meta http-equiv="pragma" content="no-cache" />
<link rel="stylesheet" type="text/css" media="print" href="templates/print.css" />
<link rel="stylesheet" type="text/css" media="screen" href="templates/style.css" />

<script type="text/javascript">
function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      if (oldonload) {
        oldonload();
      }
      func();
    }
  }
}
function loadSidebar() {
    var separator = document.getElementById('separator');
    if(separator != null) {
        separator.style.display = '';
        var fragment = location.hash;
        if(fragment == "#hideSidebar") {
            toggleSidebar(1);
        }
    }
}
function toggleSidebar(pageJustLoaded) {
    pageJustLoaded = typeof(pageJustLoaded) != 'undefined' ? pageJustLoaded : 0;
    var leftcol = document.getElementById('leftcolumn');
    var rightcol = document.getElementById('rightcolumn');
    var separator = document.getElementById('separator');
    if(leftcol != null && separator != null) {
        if (leftcol.style.display != 'none') {
            leftcol.style.display = 'none';
            rightcol.style.margin="0 0 0 0%";
            rightcol.style.width="100%";
            separator.style.backgroundImage = "url('templates/images/sidebar-arrows/right.jpg')";
            if(pageJustLoaded == 0) {
                separator.href = "#hideSidebar";
            }
        } else {
            leftcol.style.display = '';
            rightcol.style.margin="0 0 0 20%"
            rightcol.style.width="80%";
            separator.style.backgroundImage = "url('templates/images/sidebar-arrows/left.jpg')";
            separator.href = "#";
        }
    }
}
addLoadEvent(loadSidebar);
</script>

<?php if (isset($_smarty_tpl->getVariable('head',null,true,false)->value)){?>
    <?php echo $_smarty_tpl->getVariable('head')->value;?>

<?php }?>
</head>
<body>
<div id="blur">
  <div id="shadow">
    <div id="mainbody">
      <div id="header">
			<div class="login" style="display:inline">
				<?php if ($_smarty_tpl->getVariable('auth')->value->getID()==='-1'){?>
					<form action='?login' method='POST'>
					<p><label for="username">Όνομα Χρήστη:</label><input type='text' name='username' size='20'></p><BR>
					<p><label for="password">Συνθηματικό:</label><input type='password' name='password' size='20'></p><BR>
                                        <p class="submit"><input type='submit' value='Σύνδεση' /></p>
					</form>
				<?php }else{ ?>
					<p>Έχετε συνδεθεί ως:<br><?php echo $_smarty_tpl->getVariable('auth')->value->getFirstName();?>
 <?php echo $_smarty_tpl->getVariable('auth')->value->getLastName();?>
<BR>
                                           (<?php echo $_smarty_tpl->getVariable('auth')->value->getTranslatedRolesString();?>
)<br>
					<u><a href="?logout">Αποσύνδεση</a></u></p>
				<?php }?>
                                <?php if (isset($_smarty_tpl->getVariable('authenticationForm',null,true,false)->value)){?>
                                    <?php echo $_smarty_tpl->getVariable('authenticationForm')->value;?>

                                <?php }?>
			</div>
			<span class="logo">
				<span><a href="http://www.teiath.gr/"><img src="templates/images/logo.gif" alt="ΤΕΙ Αθήνας" /></a></span>
				<span style="display:block;clear:right"><a href="http://www.cs.teiath.gr/">Τμήμα Πληροφορικής</a></span>
			</span>
			<span>
				<h1 id="pagetitle">Σύστημα Εργαστηριακών Εγγραφών<BR>βάσει Προτιμήσεων</h1><br><br>
				<span class="navigation">
					<?php if (isset($_smarty_tpl->getVariable('menuHelp',null,true,false)->value)){?>
						<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['name'] = 'menuHelpIndex';
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('menuHelp')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['menuHelpIndex']['total']);
?>
								<?php if ($_smarty_tpl->getVariable('menuHelp')->value[$_smarty_tpl->getVariable('smarty')->value['section']['menuHelpIndex']['index']]!=null){?>
										<?php if ($_smarty_tpl->getVariable('menuHelp')->value[$_smarty_tpl->getVariable('smarty')->value['section']['menuHelpIndex']['index']]->isCurrentChoice()==true){?>
												<span class="curPage"><?php echo $_smarty_tpl->getVariable('menuHelp')->value[$_smarty_tpl->getVariable('smarty')->value['section']['menuHelpIndex']['index']]->getName();?>
</span>
										<?php }else{ ?>
												<a href="<?php echo $_smarty_tpl->getVariable('menuHelp')->value[$_smarty_tpl->getVariable('smarty')->value['section']['menuHelpIndex']['index']]->getURL();?>
"><?php echo $_smarty_tpl->getVariable('menuHelp')->value[$_smarty_tpl->getVariable('smarty')->value['section']['menuHelpIndex']['index']]->getName();?>
</a>
										<?php }?>
								<?php }?>
						<?php endfor; endif; ?>
					<?php }?>
				</span>
			</span>
	  </div>
      <div class="navigation NonPrintable">
		<span style="position: absolute;left: 0;">
			<?php if (isset($_smarty_tpl->getVariable('menuLeft',null,true,false)->value)){?>
				| <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['name'] = 'menuLeftIndex';
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('menuLeft')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['menuLeftIndex']['total']);
?>
					<?php if ($_smarty_tpl->getVariable('menuLeft')->value[$_smarty_tpl->getVariable('smarty')->value['section']['menuLeftIndex']['index']]!=null){?>
						<?php if ($_smarty_tpl->getVariable('menuLeft')->value[$_smarty_tpl->getVariable('smarty')->value['section']['menuLeftIndex']['index']]->isCurrentChoice()==true){?>
							<span class="curPage"><?php echo $_smarty_tpl->getVariable('menuLeft')->value[$_smarty_tpl->getVariable('smarty')->value['section']['menuLeftIndex']['index']]->getName();?>
</span>
						<?php }else{ ?>
							<a href="<?php echo $_smarty_tpl->getVariable('menuLeft')->value[$_smarty_tpl->getVariable('smarty')->value['section']['menuLeftIndex']['index']]->getURL();?>
"><?php echo $_smarty_tpl->getVariable('menuLeft')->value[$_smarty_tpl->getVariable('smarty')->value['section']['menuLeftIndex']['index']]->getName();?>
</a>
						<?php }?> | 
					<?php }?>
				<?php endfor; endif; ?>
			<?php }?>
		</span>
		<span>
			<?php if (isset($_smarty_tpl->getVariable('menuCenter',null,true,false)->value)){?>
				| <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['name'] = 'menuCenterIndex';
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('menuCenter')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['menuCenterIndex']['total']);
?>
					<?php if ($_smarty_tpl->getVariable('menuCenter')->value[$_smarty_tpl->getVariable('smarty')->value['section']['menuCenterIndex']['index']]!=null){?>
						<?php if ($_smarty_tpl->getVariable('menuCenter')->value[$_smarty_tpl->getVariable('smarty')->value['section']['menuCenterIndex']['index']]->isCurrentChoice()==true){?>
							<span class="curPage"><?php echo $_smarty_tpl->getVariable('menuCenter')->value[$_smarty_tpl->getVariable('smarty')->value['section']['menuCenterIndex']['index']]->getName();?>
</span>
						<?php }else{ ?>
							<a href="<?php echo $_smarty_tpl->getVariable('menuCenter')->value[$_smarty_tpl->getVariable('smarty')->value['section']['menuCenterIndex']['index']]->getURL();?>
"><?php echo $_smarty_tpl->getVariable('menuCenter')->value[$_smarty_tpl->getVariable('smarty')->value['section']['menuCenterIndex']['index']]->getName();?>
</a>
						<?php }?> | 
					<?php }?>
				<?php endfor; endif; ?>
			<?php }?>
		</span>
		<span style="position: absolute;right: 0;">
			<?php if (isset($_smarty_tpl->getVariable('menuRight',null,true,false)->value)){?>
				| <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['name'] = 'menuRightIndex';
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('menuRight')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['menuRightIndex']['total']);
?>
					<?php if ($_smarty_tpl->getVariable('menuRight')->value[$_smarty_tpl->getVariable('smarty')->value['section']['menuRightIndex']['index']]!=null){?>
						<?php if ($_smarty_tpl->getVariable('menuRight')->value[$_smarty_tpl->getVariable('smarty')->value['section']['menuRightIndex']['index']]->isCurrentChoice()==true){?>
							<span class="curPage"><?php echo $_smarty_tpl->getVariable('menuRight')->value[$_smarty_tpl->getVariable('smarty')->value['section']['menuRightIndex']['index']]->getName();?>
</span>
						<?php }else{ ?>
							<a href="<?php echo $_smarty_tpl->getVariable('menuRight')->value[$_smarty_tpl->getVariable('smarty')->value['section']['menuRightIndex']['index']]->getURL();?>
"><?php echo $_smarty_tpl->getVariable('menuRight')->value[$_smarty_tpl->getVariable('smarty')->value['section']['menuRightIndex']['index']]->getName();?>
</a>
						<?php }?> | 
					<?php }?>
				<?php endfor; endif; ?>
			<?php }?>
		</span>
	  </div>
      <div id="content">