<?php /* Smarty version 2.6.26, created on 2014-01-15 08:02:09
         compiled from types/detail-tmpl.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>types</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" media="all" href="<?php echo $this->_tpl_vars['_url_ui']; ?>
/css/admin/default.css" />
  <script language="javascript" src='<?php echo $this->_tpl_vars['_url_ui']; ?>
/js/admin/default.js'></script>
</head>

<body>
  <div class="header">
    <?php echo $this->_tpl_vars['Header']; ?>

  </div>

  <div class="wrapper">
    
   
    <div class="content">
      <div class="block">
        <h4>功能组信息</h4>
        <div class="inc-section">
          <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "types/inc-section-buttons.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </div>

        <div class="data-detail">
          <form id="frm_detail" name="frm_detail" method="post" action="">
            <input type="hidden" name="f" value="change">
            <input type="hidden" name="_d" value="<?php echo $this->_tpl_vars['_d']; ?>
">
            <input type="hidden" name="_a" value="<?php echo $this->_tpl_vars['_a']; ?>
">
            <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
">
            <table>
              <tr>
                <th>名称：</th>
                <td><input type="text" name="name" value="<?php echo $this->_tpl_vars['name']; ?>
" class="required"></td>
              </tr>
              <tr>
                <th>排序：</th>
                <td><input type="text" name="rank" value="<?php if ($this->_tpl_vars['rank']): ?><?php echo $this->_tpl_vars['rank']; ?>
<?php else: ?>0<?php endif; ?>" class="required digits"></td>
              </tr>
              <tr>
                <th>展开显示：</th>
                <td>
                  <input type="radio" name="open" value="1">是
                  <input type="radio" name="open" value="0">否
                </td>
              </tr>
              <tr>
                <th>备注：</th>
                <td><textarea id="intro" name="intro"><?php echo $this->_tpl_vars['intro']; ?>
</textarea></td>
              </tr>
              <tr>
                <th></th>
                <td>
                  <?php if ($this->_tpl_vars['E_name_is_null']): ?>
                    <span class="error">名称不能为空！</span>
                  <?php endif; ?>
                  <?php if ($this->_tpl_vars['E_create_successful']): ?>
                    <span class="tip">添加成功！</span>
                  <?php endif; ?>
                  <?php if ($this->_tpl_vars['E_create_failed']): ?>
                    <span class="error">添加失败！</span>
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
    </div><!--content-->
  </div><!--wrapper-->

  <div class="footer">
    <?php echo $this->_tpl_vars['Footer']; ?>

  </div>
</body>

<script>
  $(function() {

    validate('frm_detail');
    setRadio('open', '<?php echo $this->_tpl_vars['open']; ?>
', true);

  });
</script>

</html>