<?php /* Smarty version 2.6.26, created on 2014-01-15 08:02:23
         compiled from actions/detail-tmpl.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>actions</title>
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
        <h4>功能信息</h4>
        <div class="inc-section">
          <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actions/inc-section-buttons.html", 'smarty_include_vars' => array()));
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
                <th>功能代码：</th>
                <td>
                  <input type="text" name="action_code" value="<?php echo $this->_tpl_vars['action_code']; ?>
" class="required">
                  <span class="tip">3-20位数字，字母或下划线！</span>
                </td>
              </tr>
              <tr>
                <th>功能函数：</th>
                <td>
                  <input type="text" name="action_func" value="<?php echo $this->_tpl_vars['action_func']; ?>
">
                </td>
              </tr>
              <tr>
                <th>功能授权：</th>
                <td>
                  <input type="radio" name="access_type" value="OPEN">OPEN
                  <input type="radio" name="access_type" value="MEMBER">MEMBER
                  <input type="radio" name="access_type" value="GRANT">GRANT
                </td>
              </tr>
              <tr>
                <th>名称：</th>
                <td><input type="text" name="name" value="<?php echo $this->_tpl_vars['name']; ?>
" class="required"></td>
              </tr>
              <tr>
                <th>功能分组：</th>
                <td>
                  <select id="type_id" name="type_id">
                    <?php unset($this->_sections['sec']);
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['list_types']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                      <option value="<?php echo $this->_tpl_vars['list_types'][$this->_sections['sec']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['list_types'][$this->_sections['sec']['index']]['name']; ?>
</option>
                    <?php endfor; endif; ?>
                  </select>
                </td>
              </tr>
              <tr>
                <th>菜单显示：</th>
                <td>
                  <input type="radio" name="in_menu" value="1">是
                  <input type="radio" name="in_menu" value="0">否
                </td>
              </tr>
              <tr>
                <th>新窗口打开：</th>
                <td>
                  <input type="radio" name="blank" value="1">是
                  <input type="radio" name="blank" value="0">否
                </td>
              </tr>
              <tr>
                <th>命名空间：</th>
                <td>
                  <input type="radio" name="namespace" value="c">
                  <span class="tip">区分不同栏目的功能列表</span>
                </td>
              </tr>
              <tr>
                <th>自定义链接：</th>
                <td>
                  <input type="text" name="link" value="<?php echo $this->_tpl_vars['link']; ?>
" class="url" size=65>
                  <span class="tip">当有自定义链接是跳转到该链接</span>
                </td>
              </tr>
              <tr>
                <th>排序：</th>
                <td><input type="text" name="rank" value="<?php if ($this->_tpl_vars['rank']): ?><?php echo $this->_tpl_vars['rank']; ?>
<?php else: ?>0<?php endif; ?>" class="required digits"></td>
              </tr>
              <tr>
                <th>备注：</th>
                <td><textarea id="intro" name="intro"><?php echo $this->_tpl_vars['intro']; ?>
</textarea></td>
              </tr>
              <tr>
                <th></th>
                <td>
                  <?php if ($this->_tpl_vars['E_action_not_standard']): ?>
                    <span class="error">功能代码只能是数字，字母或下划线(3-20位)！</span>
                  <?php endif; ?>
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

    setSelect('type_id', '<?php echo $this->_tpl_vars['type_id']; ?>
');

    setRadio('access_type', '<?php echo $this->_tpl_vars['access_type']; ?>
', true);
    setRadio('in_menu', '<?php echo $this->_tpl_vars['in_menu']; ?>
', true);
    setRadio('blank', '<?php echo $this->_tpl_vars['blank']; ?>
', true);
    setRadio('namespace', '<?php echo $this->_tpl_vars['namespace']; ?>
', true);

  });
</script>

</html>