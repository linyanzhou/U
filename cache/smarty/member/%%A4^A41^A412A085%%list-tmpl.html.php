<?php /* Smarty version 2.6.26, created on 2014-01-17 02:02:14
         compiled from sell_de/list-tmpl.html */ ?>
<!DOCTYPE html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="directive,directive" />
<title>会员后台——sell</title>
<meta name="keywords" content="Der Welthandel, Hersteller, Lieferanten, Exporteure, Importeure, Produktkatalog, Gesch?ftsinformationen, Informationen über die Exposition">
 <link rel="stylesheet" type="text/css" href="/U/UI/css/bootstrap.min.css" />
 <link rel="stylesheet" type="text/css" href="/U/UI/css/bootstrap-responsive.css"/>
 <link rel="stylesheet" type="text/css" href="/U/UI/css/style.css" />
 <script type="text/javascript" src="/U/UI/js/jquery.js"></script>  
 <script type="text/javascript" src="/U/UI/js/bootstrap.js"></script> 
</head>

<body>
	<table class="table table-bordered table-hover definewidth m10">
	<p></P>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/U/html/member">返回上级</a>
		 <tr>
        <th>商品编号</th>
        <th>商品分类</th>
        <th>商品名称</th>
        <th>操作</th>
    </tr>
	 <?php unset($this->_sections['sec']);
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['list_product']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
	<td class="tableleft">
	 	<?php echo $this->_tpl_vars['list_product'][$this->_sections['sec']['index']]['id']; ?>

	</td>
  
  
 
	<td class="tableleft">
	 	<?php echo $this->_tpl_vars['list_product'][$this->_sections['sec']['index']]['cate_name']; ?>

	</td>
	
	
	<td class="tableleft">
	 	<?php echo $this->_tpl_vars['list_product'][$this->_sections['sec']['index']]['product_name']; ?>

	</td>
	
	<td>
		<a href="?_d=<?php echo $this->_tpl_vars['_d']; ?>
&_a=<?php echo $this->_tpl_vars['_a']; ?>
&f=edit&id=<?php echo $this->_tpl_vars['list_product'][$this->_sections['sec']['index']]['id']; ?>
">编辑</a>
	  <a href="?_d=<?php echo $this->_tpl_vars['_d']; ?>
&_a=<?php echo $this->_tpl_vars['_a']; ?>
&f=delete&id=<?php echo $this->_tpl_vars['list_product'][$this->_sections['sec']['index']]['id']; ?>
">删除</a>	
	</td>
</tr>
	
		 
	
	<?php endfor; endif; ?>

	<br/>
</table>	

	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="?_d=<?php echo $this->_tpl_vars['_d']; ?>
&_a=<?php echo $this->_tpl_vars['_a']; ?>
&f=detail">添加产品</a>
 
  </br>
	 
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../Share/inc-page-jump.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


</body>
</html> 