<?php /* Smarty version 2.6.26, created on 2014-01-16 11:20:11
         compiled from Share/exception-tmpl.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>exception</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['_url_ui']; ?>
/css/member/default.css" media="all" />
  <script src='<?php echo $this->_tpl_vars['_url_ui']; ?>
/js/member/default.js' language="javascript"></script>
</head>

<body>
  <div class="wrapper-exception">
    <?php if ($this->_tpl_vars['E_unauthorized']): ?>
      <h1>Unauthorized!</h1>
      <p>You do not have permission to use this function!</p>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['E_register_successful']): ?>
      <h1>Successful registration</h1>
      <p><a href="http://my.en.toocle.com/">click here to sign in</a></p>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['E_verification_code_no_match']): ?>
      <h1>Verification code error</h1>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['E_match_in_blacklist']): ?>
      <h1>Contain unhealthy character!</h1>
      <p>Please remove unhealthy character!</p>
    <?php endif; ?>
    <p>You'll back in <span id="leavetime">10</span> seconds,or you can <a href="javascript:void(0)" onclick="go_back()">click here</a>to back</p>

  </div>
</body>

<script LANGUAGE="javascript">
  var E_unauthorized = '<?php echo $this->_tpl_vars['E_unauthorized']; ?>
';

  var time  = document.getElementById('leavetime').innerHTML;
  var timerID = null;
  timerID = setTimeout("showtime()", 1000);

  function showtime()
  {
    if (time > 0) {
      time--;

      document.getElementById('leavetime').innerHTML = time;  
      timerID = setTimeout("showtime()", 1000);
    } 
    else {
      timerID = null;
      go_back();
    } 
  }

  function go_back()
  {
    if (E_unauthorized == 1) {
//      parent.location.href = "/";
    }

　　window.history.back(-1);

  }
</script>

</html>


