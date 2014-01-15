<?php /* Smarty version 2.6.26, created on 2014-01-15 08:01:38
         compiled from members/detail-tmpl.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>members</title>
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
        <h4>个人信息</h4>
        <div class="inc-section">
          <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "members/inc-section-buttons.html", 'smarty_include_vars' => array()));
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
                <th>帐号：</th>
                <td><span class="tip"><?php echo $this->_tpl_vars['login']; ?>
</span></td>
              </tr>
              <tr>
                <th>邮箱：</th>
                <td><span class="tip"><?php echo $this->_tpl_vars['email']; ?>
</span></td>
              </tr>
              <tr>
                <th>密码：</th>
                <td><span class="tip"><?php echo $this->_tpl_vars['passwd']; ?>
</span></td>
              </tr>
              <tr>
                <th>备注：</th>
                <td><span class="tip"><?php echo $this->_tpl_vars['intro']; ?>
</span></td>
              </tr>
              <?php if ($this->_tpl_vars['list_groups']): ?>
                <tr>
                  <th>会员组列表：</th>
                  <td>
                    <?php unset($this->_sections['sec']);
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['list_groups']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['sec']['show'] = true;
$this->_sections['sec']['max'] = $this->_sections['sec']['loop'];
$this->_sections['sec']['step'] = 1;
$this->_sections['sec']['start'] = $this->_sections['sec']['step'] > 0 ? 0 : $this->_sections['sec']['loop']-1;
if ($this->_sections['sec']['show']) {
    $this->_sections['sec']['total'] = $this->_sections['sec']['loop'];
    if ($this->_sections['sec']['total'] == 0)
        $this->_sections['sec']['show'] = false;
} else
    $this->_sections['sec']['total'] = 0;
if ($this->_sections['sec']['show']):

            for ($this->_sections['sec']['index'] = $this->_sections['sec']['start'], $this->_sections['sec']['iteration'] = 1;
                 $this->_sections['sec']['iteration'] <= $this->_sections['sec']['total'];
                 $this->_sections['sec']['index'] += $this->_sections['sec']['step'], $this->_sections['sec']['iteration']++):
$this->_sections['sec']['rownum'] = $this->_sections['sec']['iteration'];
$this->_sections['sec']['index_prev'] = $this->_sections['sec']['index'] - $this->_sections['sec']['step'];
$this->_sections['sec']['index_next'] = $this->_sections['sec']['index'] + $this->_sections['sec']['step'];
$this->_sections['sec']['first']      = ($this->_sections['sec']['iteration'] == 1);
$this->_sections['sec']['last']       = ($this->_sections['sec']['iteration'] == $this->_sections['sec']['total']);
?>
                      <input type="checkbox" id="group_id_<?php echo $this->_tpl_vars['list_groups'][$this->_sections['sec']['index']]['id']; ?>
" name="group_id[]"
                      value="<?php echo $this->_tpl_vars['list_groups'][$this->_sections['sec']['index']]['id']; ?>
" <?php if ($this->_tpl_vars['list_groups'][$this->_sections['sec']['index']]['m2g_id']): ?>checked<?php endif; ?>><?php echo $this->_tpl_vars['list_groups'][$this->_sections['sec']['index']]['name']; ?>

                    <?php endfor; endif; ?>
                  </td>
                </tr>
              <?php endif; ?>
              <tr>
                <th></th>
                <td>
                  <?php if ($this->_tpl_vars['E_change_successful']): ?>
                    <span class="tip">分组成功！</span>
                  <?php endif; ?>
                  <?php if ($this->_tpl_vars['E_change_failed']): ?>
                    <span class="error">分组失败！</span>
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
//  $(function() {
//  });
</script>

</html>