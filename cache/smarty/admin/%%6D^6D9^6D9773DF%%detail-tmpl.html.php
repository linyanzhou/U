<?php /* Smarty version 2.6.26, created on 2014-01-15 06:26:34
         compiled from admin/detail-tmpl.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>admin</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
     <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./Share/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

 <div style="margin-top:10px;border-top:1px solid #EEEEEE">
     <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./Share/main-menu-text.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
     
     
     
    </div><!--navigation-->
    <div class="content">
      <div class="block">
        <h4>个人信息</h4>
        <div class="data-detail">
          <form id="frm_detail" name="frm_detail" method="post" action="">
            <input type="hidden" name="f" value="change">
            <input type="hidden" name="_d" value="<?php echo $this->_tpl_vars['_d']; ?>
">
            <input type="hidden" name="_a" value="<?php echo $this->_tpl_vars['_a']; ?>
">
            <table>
              <tr>
                <th>账号：</th>
                <td><span class="tip"><?php echo $this->_tpl_vars['login']; ?>
</span></td>
              </tr>
              <tr>
                <th>邮箱：</th>
                <td><input type="text" id="email" name="email" value="<?php echo $this->_tpl_vars['email']; ?>
" class="required email"></td>
              </tr>
              <tr>
                <th>备注：</th>
                <td>
                  <textarea id="intro" name="intro"><?php echo $this->_tpl_vars['intro']; ?>
</textarea>
                </td>
              </tr>
              <tr>
                <th></th>
                <td>
                  <?php if ($this->_tpl_vars['E_email_not_standard']): ?>
                    <span class="error">无效的电子邮件地址！</span>
                  <?php endif; ?>
                  <?php if ($this->_tpl_vars['E_change_successful']): ?>
                    <span class="tip">修改成功！</span>
                  <?php endif; ?>
                  <?php if ($this->_tpl_vars['E_change_failed']): ?>
                    <span class="error">修改失败！</span>
                  <?php endif; ?>
                </td>
              </tr>
              <tr>
                <th></th>
                <td>
                  <input class="input" type="submit" name="btn_submit" value="提 交">
                  <input class="input" type="reset" name="btn_reset" value="重 置">
                </td>
              </tr>
            </table>
          </form>
        </div>
      </div><!--block-->

      <div class="block">
        <h4>修改密码</h4>
        <div class="data-detail">
          <form id="frm_passwd" name="frm_passwd" method="post" action="">
            <input type="hidden" name="f" value="change_passwd">
            <input type="hidden" name="_d" value="<?php echo $this->_tpl_vars['_d']; ?>
">
            <input type="hidden" name="_a" value="<?php echo $this->_tpl_vars['_a']; ?>
">
            <table>
              <tr>
                <th>原始密码：</th>
                <td><input type="password" id="opasswd" name="opasswd" value="" class="required"></td>
              </tr>
              <tr>
                <th>新密码：</th> 
                <td>
                  <input type="password" id="npasswd" name="npasswd" value="" class="required">
                </td>
              </tr>
              <tr>
                <th>确认密码：</th>
                <td><input type="password" id="cpasswd" name="cpasswd" value="" class="required"></td>
              </tr>
              <tr>
                <th></th>
                <td>
                  <?php if ($this->_tpl_vars['E_change_passwd_successful']): ?>
                    <span class="tip">修改成功！</span>
                  <?php endif; ?>
                  <?php if ($this->_tpl_vars['E_change_passwd_failed']): ?>
                    <span class="error">修改失败！</span>
                  <?php endif; ?>
                  <?php if ($this->_tpl_vars['E_passwd_not_standard']): ?>
                    <span class="error">新密码格式不正确！</span>
                  <?php endif; ?>
                  <?php if ($this->_tpl_vars['E_passwd_inconsistent']): ?>
                    <span class="error">新密码与确认密码不一致！</span>
                  <?php endif; ?>
                  <?php if ($this->_tpl_vars['E_passwd_incorrect']): ?>
                    <span class="error">原始密码有误！</span>
                  <?php endif; ?>
                </td>
              </tr>
              <tr>
                <th></th>
                <td><span class="tip">密码可使用任何英文字母及阿拉伯数字组合，不得少于4个字符，并区分英文字母大小写。例如：JohN123DoLe。</span></td>
              </tr>  
              <tr>
                <th></th>
                <td>
                  <input class="input" type="submit" name="btn_submit1" value="提 交">
                  <input class="input" type="reset" name="btn_reset1" value="重 置">
                </td>
              </tr>
            </table>
          </form>
        </div>
      </div><!--block-->
    </div><!--content-->
  </div><!--wrapper-->

  <div class="footer">
    <?php echo $this->_tpl_vars['Footer']; ?>

  </div>
</body>

<script>
  $(function() {

    validate('frm_detail');
    var rules = {
      opasswd: {
        equalTo: "#npasswd"
      }
    };
    validate('frm_passwd', rules);

  });
</script>

</html>