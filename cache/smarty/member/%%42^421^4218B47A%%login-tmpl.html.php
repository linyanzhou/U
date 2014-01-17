<?php /* Smarty version 2.6.26, created on 2014-01-17 02:17:27
         compiled from login/login-tmpl.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My Toocle&nbsp;&nbsp;<?php echo $this->_tpl_vars['_login_user_id']; ?>
&nbsp;&nbsp;sign</title>

<link href="<?php echo $this->_tpl_vars['_url_ui']; ?>
/css/de/member.css" type="text/css" rel="stylesheet">
<script language="javascript" type="text/javascript" src="<?php echo $this->_tpl_vars['_url_ui']; ?>
/js/jquery163.js"></script>
</head>

<body class="bodybj">
<div class="container">
	<div id="toplogin">der Hersteller-und Angeboterhandelszirkel von globalen Einkäufern</div>
	<div id="header">
    	<div class="logo fl mr10"><img src="<?php echo $this->_tpl_vars['_url_ui']; ?>
/images/de/logo.jpg" width="190" height="50" /></div>
        <div class="de ml10 sign">Will ein Mitglied sein ? <a href="http://de.toocle.com/my/" class="txt-line">Registriern hier</a><br><a href="http://de.toocle.com/my/index.php?_d=my&_a=main&f=forget" target="_blank">Passwort vergessen?</a></div>
        <div class="fl join">Anmelden</div>
    	<div class="cle mb10"></div>
    </div>
    <div id="nav">
    	<span class="fl">Sprache:</span>
        <ul>
           
            
            <li class="nav-def" id="menu_jp"><a href="http://my.jp.toocle.com/">japanisch</a></li>
            <li class="nav-def" id="menu_kr"><a href="http://my.kr.toocle.com/">koreanisch</a></li>
            <li class="nav-def" id="menu_ru"><a href="http://my.ru.toocle.com/"> russisch</a></li>
            <li class="nav-def" id="menu_ru"><a href="http://my.vn.toocle.com/">vietnamesische</a></li>
            <li class="nav-def" id="menu_fr"><a href="http://my.fr.toocle.com/">französisch</a></li>	
            <li class="nav-def" id="menu_ru"><a href="http://my.es.toocle.com/">spanisch</a></li>
            <li class="nav-def" id="menu_ru"><a href="http://my.in.toocle.com/">hindi</a></li>
            <li class="nav-act" id="menu_de"><a href="http://my.de.toocle.com/">Deutsch</a></li>
            <li class="nav-def" id="menu_de"><a href="http://my.it.toocle.com/">Italien</a></li>
            <li class="nav-def" id="menu_ar"><a href="http://my.ar.toocle.com/">argentinische</a></li> 	
           
            
            
            
          
        </ul>
    </div>
	<div>
		<div class="signleft fl">
			<div class="left-top"></div>
			<div class="left-mid">
				<div class="join mb13" style="border:none;">I'm a Toocler</div>
				<form id="frm_login" name="frm_login" method="post" action="">
				<input type="hidden" name="f" value="check_login">
				<input type="hidden" name="_d" value="<?php echo $this->_tpl_vars['_d']; ?>
">
				<input type="hidden" name="_a" value="<?php echo $this->_tpl_vars['_a']; ?>
">
				<input type="hidden" name="reurl" value="<?php echo $this->_tpl_vars['reurl']; ?>
">
				<?php if ($this->_tpl_vars['E_not_login']): ?>
				 <div class="red"> </div>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['E_incorrect']): ?>
				  <div class="red">Accountnumber oder das Passwort ist nicht richtig!</div>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['E_inactive']): ?>
				 <div class="red">Account ist nicht aktiviert!</div>
				<?php endif; ?>
				<div class="h30"><span class="fl">Accountnumber：</span><input name="login" type="text" class="fl" /></div>
				<div class="h30"><span class="fl">Passwort：</span><input name="passwd"  class="fl" type="password" /></div>
				<div class="h30"><span class="fl">&nbsp;&nbsp;</span><input name="" type="image" src="<?php echo $this->_tpl_vars['_url_ui']; ?>
/images/de/signbtn.jpg" class="fl" style="width:71px; border:none; height:30px; margin-top:5px;" /><a href="http://de.toocle.com/my/index.php?_d=my&_a=main&f=forget" target="_blank" class="ml10 fl blue">Passwort vergessen?</a></div>
				</form>
				
				<div class="notes">
					<ul>
						<li>Will ein Mitglied sein? <a class="blue" href="http://de.toocle.com/my/">Eintragen</a></li>
						<li>Probleme über Toocle? <a class="blue" href="http://www.toocle.com/help_center/" target="_blank">Klicken Sie hier</a></li>
					</ul>
				</div>
			</div>
			<div class="left-bottom"></div>
		</div>
		<div class="signright fl"><img src="<?php echo $this->_tpl_vars['_url_ui']; ?>
/images/de/signpic.jpg" width="470" height="280" /></div>
		<div class="cle"></div>
    </div>	
		<div class="cle"></div>
</div>
<div id="footer">
<a href="http://my.de.toocle.com/" target="_blank"> Anmelden</a> | <a href="http://de.toocle.com/my/" target="_blank">Eintragen</a> | <a href="http://de.toocle.com/about_us/" target="_blank">über toocle</a> | <a href="http://de.toocle.com/about_us/partners.html" target="_blank">Partner</a> | <a href="http://de.toocle.com/about_us/help.html" target="_blank">Hilfszentrum</a> | <a href="http://de.toocle.com/about_us/custom_service.html" target="_blank">Kundenservice</a><br>Copyright &copy; Toocle(002095) alle Rechte vorbehalten

<br>Copyright &copy; Toocle(002095) alle Rechte vorbehalten

		
</div>
</body>
<script  language="javascript" type="text/javascript">
  $(function() {

		var url = location.href; 
		reg = /^http:\/\/my.(.*?).toocle.com\//;  
		
		action=url.match(reg)[1];

    if (action != '') {
      var $menu = $('#menu_' + action);
      $menu.removeClass('nav-def');
      $menu.addClass('nav-act');
      menu_show($menu, true);
    }

  });
</script>

</html>