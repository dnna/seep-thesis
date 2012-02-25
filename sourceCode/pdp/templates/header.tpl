{* Smarty template *}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$pageTitle}</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="content-language" content="gr" />
<meta http-equiv="pragma" content="no-cache" />
<link rel="stylesheet" type="text/css" media="print" href="templates/print.css" />
<link rel="stylesheet" type="text/css" media="screen" href="templates/style.css" />
{literal}
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
{/literal}
{if isset($head)}
    {$head}
{/if}
</head>
<body>
<div id="blur">
  <div id="shadow">
    <div id="mainbody">
      <div id="header">
			<div class="login" style="display:inline">
				{if $auth->getID() === '-1'}
					<form action='?login' method='POST'>
					<p><label for="username">Όνομα Χρήστη:</label><input type='text' name='username' size='20'></p><BR>
					<p><label for="password">Συνθηματικό:</label><input type='password' name='password' size='20'></p><BR>
                                        <p class="submit"><input type='submit' value='Σύνδεση' /></p>
					</form>
				{else}
					<p>Έχετε συνδεθεί ως:<br>{$auth->getFirstName()} {$auth->getLastName()}<BR>
                                           ({$auth->getTranslatedRolesString()})<br>
					<u><a href="?logout">Αποσύνδεση</a></u></p>
				{/if}
                                {if isset($authenticationForm)}
                                    {$authenticationForm}
                                {/if}
			</div>
			<span class="logo">
				<span><a href="http://www.teiath.gr/"><img src="templates/images/logo.gif" alt="ΤΕΙ Αθήνας" /></a></span>
				<span style="display:block;clear:right"><a href="http://www.cs.teiath.gr/">Τμήμα Πληροφορικής</a></span>
			</span>
			<span>
				<h1 id="pagetitle">Σύστημα Εργαστηριακών Εγγραφών<BR>βάσει Προτιμήσεων</h1><br><br>
				<span class="navigation">
					{if isset($menuHelp)}
						{section name=menuHelpIndex loop=$menuHelp}
								{if $menuHelp[menuHelpIndex] != null}
										{if $menuHelp[menuHelpIndex]->isCurrentChoice() == true}
												<span class="curPage">{$menuHelp[menuHelpIndex]->getName()}</span>
										{else}
												<a href="{$menuHelp[menuHelpIndex]->getURL()}">{$menuHelp[menuHelpIndex]->getName()}</a>
										{/if}
								{/if}
						{/section}
					{/if}
				</span>
			</span>
	  </div>
      <div class="navigation NonPrintable">
		<span style="position: absolute;left: 0;">
			{if isset($menuLeft)}
				| {section name=menuLeftIndex loop=$menuLeft}
					{if $menuLeft[menuLeftIndex] != null}
						{if $menuLeft[menuLeftIndex]->isCurrentChoice() == true}
							<span class="curPage">{$menuLeft[menuLeftIndex]->getName()}</span>
						{else}
							<a href="{$menuLeft[menuLeftIndex]->getURL()}">{$menuLeft[menuLeftIndex]->getName()}</a>
						{/if} | 
					{/if}
				{/section}
			{/if}
		</span>
		<span>
			{if isset($menuCenter)}
				| {section name=menuCenterIndex loop=$menuCenter}
					{if $menuCenter[menuCenterIndex] != null}
						{if $menuCenter[menuCenterIndex]->isCurrentChoice() == true}
							<span class="curPage">{$menuCenter[menuCenterIndex]->getName()}</span>
						{else}
							<a href="{$menuCenter[menuCenterIndex]->getURL()}">{$menuCenter[menuCenterIndex]->getName()}</a>
						{/if} | 
					{/if}
				{/section}
			{/if}
		</span>
		<span style="position: absolute;right: 0;">
			{if isset($menuRight)}
				| {section name=menuRightIndex loop=$menuRight}
					{if $menuRight[menuRightIndex] != null}
						{if $menuRight[menuRightIndex]->isCurrentChoice() == true}
							<span class="curPage">{$menuRight[menuRightIndex]->getName()}</span>
						{else}
							<a href="{$menuRight[menuRightIndex]->getURL()}">{$menuRight[menuRightIndex]->getName()}</a>
						{/if} | 
					{/if}
				{/section}
			{/if}
		</span>
	  </div>
      <div id="content">