<?php /* Smarty version 2.6.26, created on 2014-01-16 06:16:15
         compiled from member/change-tmpl.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>My Toocle&nbsp;&nbsp;<?php echo $this->_tpl_vars['_login_user_id']; ?>
&nbsp;&nbsp; infomation</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $this->_tpl_vars['_url_ui']; ?>
/css/de/all2.css" />
  <script language="javascript" src='<?php echo $this->_tpl_vars['_url_ui']; ?>
/js/member/default.js'></script>
  <link href="<?php echo $this->_tpl_vars['_url_ui']; ?>
/css/de/member.css" type="text/css" rel="stylesheet">
</head>

<body>
<div class="container">
<?php echo $this->_tpl_vars['Header_new']; ?>

<div class="main">
<?php echo $this->_tpl_vars['Main_menu_text_new']; ?>


   
    <div class="content">
			<div class="main-top"><div class="main-top2">Passwortsänderung</div></div>
      		<div class="content_bottom">
				<form id="frm_passwd" name="frm_passwd" method="post" action="">
				<input type="hidden" name="f" value="change_passwd">
				<input type="hidden" name="_d" value="<?php echo $this->_tpl_vars['_d']; ?>
">
				<input type="hidden" name="_a" value="<?php echo $this->_tpl_vars['_a']; ?>
">
				<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
">
						<div class="list mb10"><div class="fl w110"><span class="must">*</span>das alte Passwort:</div><div class="fl mt5"><input type="password" id="opasswd" name="opasswd"  class="w250 required"></div><div class="cle"></div></div>
						<div class="list mb10"><div class="fl w110"><span class="must">*</span>das neue Passwort:</div><div class="fl mt5"><input type="password" id="npasswd" name="npasswd" class="w250 required"></div><div class="cle"></div></div>
						<div class="list mb10"><div class="fl w110"><span class="must">*</span>Bestätigung:</div><div class="fl mt5"><input type="password" id="cpasswd" name="cpasswd" class="w250 required"></div><div class="cle"></div></div>
						<div class="list"><div class="fl w110">&nbsp; </div>
							<div>
							<?php if ($this->_tpl_vars['E_change_passwd_successful']): ?>
								<span class="tip">successful</span>
							  <?php endif; ?>
							  <?php if ($this->_tpl_vars['E_change_passwd_failed']): ?>
								<span class="error">fail to change</span>
							  <?php endif; ?>
							  <?php if ($this->_tpl_vars['E_passwd_not_standard']): ?>
								<span class="error">password error</span>
							  <?php endif; ?>
							  <?php if ($this->_tpl_vars['E_passwd_inconsistent']): ?>
								<span class="error">password error</span>
							  <?php endif; ?>
							  <?php if ($this->_tpl_vars['E_passwd_incorrect']): ?>
								<span class="error">Old password error</span>
							  <?php endif; ?>	
							</div> 
						</div>
						<div class="list" style="margin-top:20px;"><div class="fl w85">&nbsp;&nbsp;</div><div class="fl"><input type="image"  src="<?php echo $this->_tpl_vars['_url_ui']; ?>
/images/de/manage/save.jpg" border="0" /></div><div class="cle"></div></div>
					</div>
					</div>
					</form>
				</div><!--block-->
    </div><!--content-->


  <div class="footer">
  	<div id="footer">
    <?php echo $this->_tpl_vars['Footer_new']; ?>

  </div>
  </div>
</body>

<script>
  $(function() {
    validate('frm_passwd', {
      cpasswd: {
         equalTo: "#npasswd"}
  });
});
</script>

</html>