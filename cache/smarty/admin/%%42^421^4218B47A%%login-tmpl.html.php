<?php /* Smarty version 2.6.26, created on 2014-01-15 05:13:46
         compiled from login/login-tmpl.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>admin</title>
 <meta name="keywords" content="Der Welthandel, Hersteller, Lieferanten, Exporteure, Importeure, Produktkatalog, Gesch?ftsinformationen, Informationen über die Exposition">
 <link rel="stylesheet" type="text/css" href="/U/UI/css/bootstrap.min.css" />
 <link rel="stylesheet" type="text/css" href="/U/UI/css/bootstrap-responsive.css"/>
 <link rel="stylesheet" type="text/css" href="/U/UI/css/style.css" />
 <link rel="stylesheet" type="text/css" href="/U/UI/css/validate.css" />
 <script type="text/javascript" src="/U/UI/js/jquery.js"></script>  
 <script type="text/javascript" src="/U/UI/js/bootstrap.js"></script> 
 <script type="text/javascript" src="/U/UI/js/jquery.validate.js"></script>
 <script type="text/javascript" src="/U/UI/js/default.js"></script> 
</head>

<body>
  <table class="table table-bordered table-hover definewidth m10">
  <form id="frm_login" name="frm_login" method="post" action="">
      <input type="hidden" name="f" value="check_login">
      <input type="hidden" name="_d" value="<?php echo $this->_tpl_vars['_d']; ?>
">
      <input type="hidden" name="_a" value="<?php echo $this->_tpl_vars['_a']; ?>
">
      <input type="hidden" name="reurl" value="<?php echo $this->_tpl_vars['reurl']; ?>
">

      <h1>&nbsp;&nbsp;&nbsp;Login</h1>
        <tr>
        <td>
          帐号：<input type="text" name="login" value="" class="required">
        </td>
      </tr>
       <tr>
        <td>
          密码：<input type="password" name="passwd" value="" class="required">
        <?php if ($this->_tpl_vars['E_incorrect']): ?>
          <span class="error">帐号或密码有误！</span>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['E_not_login']): ?>
          <span class="error">请先登录！</span>
        <?php endif; ?>
        </td>
        </tr>
        <tr>
        <td>
          <input  type="submit" name="btn_submit" class="btn btn-primary" value="提 交">
          <input  type="reset" name="btn_reset"  class="btn btn-success"  value="重 置">
        </td> 
      </tr>
    </form>
  </table>

</body>

<script>
  $(function() {

    validate('frm_login');

  });
</script>

</html>


