<?php /* Smarty version 2.6.26, created on 2014-01-16 06:16:13
         compiled from member/detail-tmpl.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>My Toocle&nbsp;&nbsp;<?php echo $this->_tpl_vars['_login_user_id']; ?>
&nbsp;&nbsp; infomation</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $this->_tpl_vars['_url_ui']; ?>
/css/de/all2.css" />
  <link href="<?php echo $this->_tpl_vars['_url_ui']; ?>
/css/de/member.css" type="text/css" rel="stylesheet">
  <!--<link href="../css/all.css" type="text/css" rel="stylesheet">-->
  <script language="javascript" src='<?php echo $this->_tpl_vars['_url_ui']; ?>
/js/member/default.js'></script>
</head>

<body>
<div class="container">
<?php echo $this->_tpl_vars['Header_new']; ?>

<div class="main">
<?php echo $this->_tpl_vars['Main_menu_text_new']; ?>


    <div class="content">
      		<div class="main-top"><div class="main-top2">Mitgliedsinformation</div></div>
				<div class="content_bottom">
					
						<input type="hidden" name="f" value="change">
						<input type="hidden" name="_d" value="<?php echo $this->_tpl_vars['_d']; ?>
">
						<input type="hidden" name="_a" value="<?php echo $this->_tpl_vars['_a']; ?>
">
						<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
">
						<div class="list">
						  <div class="fl w85">Account:</div><?php echo $this->_tpl_vars['login']; ?>
</div>
						<div class="list"><div class="fl w85">Mailbox:</div><?php echo $this->_tpl_vars['email']; ?>
</div>
						<div class="list"><div class="fl w85">Passwort:</div><a href="/index.php?_a=member&f=passwd"><font color="#7CCD7C">Passwortsänderung</font></a></div>


				</div>
	  <!--block-->
    </div><!--content-->
  </div><!--wrapper-->
  <div class="footer">
  	<div id="footer">
    <?php echo $this->_tpl_vars['Footer_new']; ?>

  </div>
  </div>
</body>

<script>
  $(function() {
    set_regional(3,1);
    setSelect('position','<?php echo $this->_tpl_vars['position']; ?>
');
    <?php if ($this->_tpl_vars['im_type']): ?>setSelect('im_type','<?php echo $this->_tpl_vars['im_type']; ?>
');<?php endif; ?>
    validate('frm_detail',{
        email:'email'
    });
  });
</script>

</html>