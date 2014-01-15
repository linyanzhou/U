<?php /* Smarty version 2.6.26, created on 2014-01-15 07:58:57
         compiled from actions/list-tmpl.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>功能列表</title>
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
       <span><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actions/inc-section-buttons.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></span>
       
       

        <form id="frm_list" name="frm_list" action="" method="POST" ENCTYPE="multipart/form-data">
          <input type="hidden" name="f" value="delete">
          <input type="hidden" name="url_prefix" value="<?php echo $this->_tpl_vars['pw_url_prefix']; ?>
<?php echo $this->_tpl_vars['pw_curr_page']; ?>
">
          <div class="data-list">
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <th>代码</th>
                <th>名称</th>
                <th>查看</th>
                <th>复制</th>
                <th>状态 <input type="checkbox" id="chk_all_able_status" name="chk_all_able_status" value=""></th>
              </tr>
              <?php unset($this->_sections['sec']);
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['list_actions']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                  <td>
                    <?php echo $this->_tpl_vars['list_actions'][$this->_sections['sec']['index']]['action_code']; ?>

                    <?php if ($this->_tpl_vars['list_actions'][$this->_sections['sec']['index']]['action_func']): ?>:<?php echo $this->_tpl_vars['list_actions'][$this->_sections['sec']['index']]['action_func']; ?>
<?php endif; ?>
                    (<?php echo $this->_tpl_vars['list_actions'][$this->_sections['sec']['index']]['namespace']; ?>
<?php echo $this->_tpl_vars['list_actions'][$this->_sections['sec']['index']]['rank']; ?>
)
                  </td>
                  <td title="<?php echo $this->_tpl_vars['list_actions'][$this->_sections['sec']['index']]['name']; ?>
"><?php echo $this->_tpl_vars['list_actions'][$this->_sections['sec']['index']]['name1']; ?>
</td>
                  <td class="center">
                    <a href="?_d=<?php echo $this->_tpl_vars['_d']; ?>
&_a=<?php echo $this->_tpl_vars['_a']; ?>
&f=detail&id=<?php echo $this->_tpl_vars['list_actions'][$this->_sections['sec']['index']]['id']; ?>
">
                     <img src="/U/UI/img/btn_edit.gif" alt="edit">
                    </a>
                  </td>
                  <td class="center">
                    <a href="?_d=<?php echo $this->_tpl_vars['_d']; ?>
&_a=<?php echo $this->_tpl_vars['_a']; ?>
&f=copy&id=<?php echo $this->_tpl_vars['list_actions'][$this->_sections['sec']['index']]['id']; ?>
">
                     <img src="/U/UI/img/btn_copy.png" alt="copy">
                    </a>
                  </td>
                  <td class="center">
                    <span id="wrap_able_status<?php echo $this->_tpl_vars['list_actions'][$this->_sections['sec']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['list_actions'][$this->_sections['sec']['index']]['status']; ?>
</span>
                    <a href="javascript:void(<?php echo $this->_tpl_vars['list_actions'][$this->_sections['sec']['index']]['id']; ?>
)" rel="<?php echo $this->_tpl_vars['list_actions'][$this->_sections['sec']['index']]['id']; ?>
" id="btn_able_status">改变</a>
                    <input type="checkbox" id="able_status_ids" name="able_status_ids" value="<?php echo $this->_tpl_vars['list_actions'][$this->_sections['sec']['index']]['id']; ?>
">
                  </td>
                </tr>
              <?php endfor; endif; ?>
            </table>
          </div>

          <div class="center">
            <input class="input" type="button" id="btn_all_able_status" name="btn_all_able_status" value="改 变">
          </div>
        </form>

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

<script>
  $(function() {
    //status
    var url = "?_a=<?php echo $this->_tpl_vars['_a']; ?>
&_w=false&f=able";
    var ableStatus = new Able();
    ableStatus.able('btn_able_status', 'wrap_able_status', url);
    ableStatus.ables('btn_all_able_status', 'wrap_able_status', 'able_status_ids', url);
    checkAll('chk_all_able_status', 'able_status_ids');
  });
</script>

</html>