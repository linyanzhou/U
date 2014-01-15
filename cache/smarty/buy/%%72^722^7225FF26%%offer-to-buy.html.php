<?php /* Smarty version 2.6.26, created on 2014-01-13 02:57:59
         compiled from ./offer-to-buy.html */ ?>
<!DOCTYPE html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="directive,directive" />
<title>buy</title>
<meta name="keywords" content="Der Welthandel, Hersteller, Lieferanten, Exporteure, Importeure, Produktkatalog, Gesch?ftsinformationen, Informationen über die Exposition">
<link href="<?php echo $this->_tpl_vars['_url_ui']; ?>
/css/de/style.css" type="text/css" rel="stylesheet" media="screen">
<script src="<?php echo $this->_tpl_vars['_url_ui']; ?>
/js/elements.js"></script>
<script src="<?php echo $this->_tpl_vars['_url_ui']; ?>
/js/jquery163.js"></script>
<!--[if lt IE 9]>
<script src="<?php echo $this->_tpl_vars['_url_ui']; ?>
/js/IE9.js"></script>
<![endif]-->
</head>

<body>
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
	<td>
	 	<?php echo $this->_tpl_vars['list_product'][$this->_sections['sec']['index']]['id']; ?>

	</td>
	
		<td>
	 	<?php echo $this->_tpl_vars['list_product'][$this->_sections['sec']['index']]['cate_name']; ?>

	</td>
	
	
		 
	
	<?php endfor; endif; ?>
	<br/>
	
	
	 
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "./Share/inc-page-jump.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html> 