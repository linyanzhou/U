<?php /* Smarty version 2.6.26, created on 2014-01-15 05:27:04
         compiled from actions/inc-section-buttons.html */ ?>
<a href="?_d=<?php echo $this->_tpl_vars['_d']; ?>
&_a=<?php echo $this->_tpl_vars['_a']; ?>
&f=list">所有功能</a> - 
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
<a href="?_d=<?php echo $this->_tpl_vars['_d']; ?>
&_a=<?php echo $this->_tpl_vars['_a']; ?>
&f=list&type_id=<?php echo $this->_tpl_vars['list_types'][$this->_sections['sec']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['list_types'][$this->_sections['sec']['index']]['name']; ?>
列表</a> - 
<?php endfor; endif; ?>
<a href="?_d=<?php echo $this->_tpl_vars['_d']; ?>
&_a=<?php echo $this->_tpl_vars['_a']; ?>
&f=detail">添加功能</a>