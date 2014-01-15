<?php /* Smarty version 2.6.26, created on 2014-01-15 05:26:02
         compiled from Share/inc-page-jump.html */ ?>
总数: <?php echo $this->_tpl_vars['pw_rec_total']; ?>
&nbsp;&nbsp;
页次: <span><?php echo $this->_tpl_vars['pw_curr_page']; ?>
</span>/<?php echo $this->_tpl_vars['pw_page_total']; ?>
&nbsp;&nbsp;

<?php if ($this->_tpl_vars['pw_rec_first']): ?><a href='<?php echo $this->_tpl_vars['pw_url_prefix']; ?>
<?php echo $this->_tpl_vars['pw_rec_first']; ?>
<?php echo $this->_tpl_vars['pw_url_suffix']; ?>
'>|&lsaquo;</a><?php endif; ?>
<?php if ($this->_tpl_vars['pw_prev_win']): ?><a href='<?php echo $this->_tpl_vars['pw_url_prefix']; ?>
<?php echo $this->_tpl_vars['pw_prev_win']; ?>
<?php echo $this->_tpl_vars['pw_url_suffix']; ?>
'>&lsaquo;&lsaquo;</a><?php endif; ?>

<?php unset($this->_sections['sec']);
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['pw_page_loop']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
  <?php if ($this->_tpl_vars['pw_page_loop'][$this->_sections['sec']['index']]['is_curr']): ?>
    <span title="<?php echo $this->_tpl_vars['pw_url_prefix']; ?>
<?php echo $this->_tpl_vars['pw_page_loop'][$this->_sections['sec']['index']]['page_idx']; ?>
<?php echo $this->_tpl_vars['pw_url_suffix']; ?>
"><?php echo $this->_tpl_vars['pw_page_loop'][$this->_sections['sec']['index']]['page_idx']; ?>
</span>
  <?php else: ?>
    <a href='<?php echo $this->_tpl_vars['pw_url_prefix']; ?>
<?php echo $this->_tpl_vars['pw_page_loop'][$this->_sections['sec']['index']]['page_idx']; ?>
<?php echo $this->_tpl_vars['pw_url_suffix']; ?>
'><?php echo $this->_tpl_vars['pw_page_loop'][$this->_sections['sec']['index']]['page_idx']; ?>
</a>
  <?php endif; ?>
<?php endfor; endif; ?>

<?php if ($this->_tpl_vars['pw_next_win']): ?><a href='<?php echo $this->_tpl_vars['pw_url_prefix']; ?>
<?php echo $this->_tpl_vars['pw_next_win']; ?>
<?php echo $this->_tpl_vars['pw_url_suffix']; ?>
'>&rsaquo;&rsaquo;</a><?php endif; ?>
<?php if ($this->_tpl_vars['pw_rec_last']): ?><a href='<?php echo $this->_tpl_vars['pw_url_prefix']; ?>
<?php echo $this->_tpl_vars['pw_rec_last']; ?>
<?php echo $this->_tpl_vars['pw_url_suffix']; ?>
'>&rsaquo;|</a><?php endif; ?>