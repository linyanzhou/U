<?php /* Smarty version 2.6.26, created on 2014-01-15 07:09:15
         compiled from members/list-tmpl.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>members</title>
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

    <div style="float:right;width:88%;text-align:left;">
    	
    	
      <div class="block">
        
         
        <div class="data-list">
          <table width="100%" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <th>序号</th>
              <th>帐号</th>
              <th>密码</th>
              <th>邮箱</th>
              <th>查看</th>
            </tr>
            <?php unset($this->_sections['sec']);
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['list_members']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
              <tr>
                <td><?php echo $this->_tpl_vars['list_members'][$this->_sections['sec']['index']]['id']; ?>
</td>
                <td><?php echo $this->_tpl_vars['list_members'][$this->_sections['sec']['index']]['login']; ?>
</td>
                <td><?php echo $this->_tpl_vars['list_members'][$this->_sections['sec']['index']]['passwd']; ?>
</td>
                <td><?php echo $this->_tpl_vars['list_members'][$this->_sections['sec']['index']]['email']; ?>
</td>
                <td class="center">
                  <a href="?_d=<?php echo $this->_tpl_vars['_d']; ?>
&_a=<?php echo $this->_tpl_vars['_a']; ?>
&f=detail&id=<?php echo $this->_tpl_vars['list_members'][$this->_sections['sec']['index']]['id']; ?>
">
                    <img src="/U/UI/img/btn_edit.gif" alt="edit">
                  </a>
                </td>
              </tr>
            <?php endfor; endif; ?>
          </table>
        </div>

        <div class="inc-page-jump">
          <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "Share/inc-page-jump.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </div>
      </div><!--block-->
    </div><!--content-->
  </div><!--wrapper-->

  
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./Share/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  
 
</body>

 

</html>