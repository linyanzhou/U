<?php /* Smarty version 2.6.26, created on 2014-01-16 05:44:05
         compiled from Share/header.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'Share/header.html', 2, false),)), $this); ?>
 
<?php echo smarty_function_config_load(array('file' => "member.conf"), $this);?>
 
	<div class="head">
		<div class="logo fl"><img src="http://ui.s.toocle.com/images/member/logo.jpg" /></div>
		<h1 class="fl">生意助手</h1>
        <span class="fl" style="line-height:28px;"><?php echo $this->_tpl_vars['_login_user_id']; ?>
，您好！欢迎您使用生意助手，如遇问题，请拨打电话0571-88228455！</span>
        <span class="fr"><a href="http://my.intl.toocle.com/index.php?_a=member"><?php echo $this->_config[0]['vars']['account_info']; ?>
</a> <a href="http://my.intl.toocle.com/?_a=login&f=logout"><?php echo $this->_config[0]['vars']['logout']; ?>
</a> </span>
	</div>
 
	<div class="nav">
		<ul>		
 <?php unset($this->_sections['sec']);
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['base_auth']['header_menu']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
 <li><a href="<?php echo $this->_tpl_vars['base_auth']['header_menu'][$this->_sections['sec']['index']]['url']; ?>
" <?php if ($this->_tpl_vars['base_auth']['header_menu'][$this->_sections['sec']['index']]['target']): ?>target="<?php echo $this->_tpl_vars['base_auth']['header_menu'][$this->_sections['sec']['index']]['url']; ?>
"<?php endif; ?> ><img src="<?php echo $this->_tpl_vars['base_auth']['header_menu'][$this->_sections['sec']['index']]['img']; ?>
" /><br><?php echo $this->_tpl_vars['base_auth']['header_menu'][$this->_sections['sec']['index']]['name']; ?>
</a></li>   
 <?php endfor; endif; ?>						
		</ul>
	</div>
 	<!--location-->
	<div class="location">
	<?php if ($this->_tpl_vars['_a'] == 'certified'): ?><img class="fl" src="http://ui.s.toocle.com/images/member/nav/5.gif" width=23 height=23 style="margin-top:2px;"/> <span class="fl"><a href="http://my.hub.toocle.com" style="color: #666;">助手首页 </a>&nbsp;></span><span class="fl" style="font-size:12px;">认证中心</span>
	<?php elseif ($this->_tpl_vars['_a'] == 'service_order'): ?><img class="fl" src="http://ui.s.toocle.com/images/member/nav/6.gif" width=23 height=23 style="margin-top:2px;"/> <span class="fl"><a href="http://my.hub.toocle.com" style="color: #666;">助手首页 </a>&nbsp;></span><span class="fl" style="font-size:12px;">订购服务</span>
	<?php elseif ($this->_tpl_vars['_a'] == 'pim'): ?><img class="fl" src="http://ui.s.toocle.com/images/member/nav/19.gif" width=23 height=23 style="margin-top:2px;"/> <span class="fl"><a href="http://my.hub.toocle.com" style="color: #666;">助手首页 </a>&nbsp;></span><span class="fl" style="font-size:12px;">通讯录</span>
	<?php elseif ($this->_tpl_vars['_a'] == 'pim_group'): ?><img class="fl" src="http://ui.s.toocle.com/images/member/nav/19.gif" width=23 height=23 style="margin-top:2px;"/> <span class="fl"><a href="http://my.hub.toocle.com" style="color: #666;">助手首页 </a>&nbsp;></span><span class="fl" style="font-size:12px;">通讯录</span>
	<?php elseif ($this->_tpl_vars['_a'] == 'conference_call'): ?><img class="fl" src="http://ui.s.toocle.com/images/member/nav/20.gif" width=23 height=23 style="margin-top:2px;"/> <span class="fl"><a href="http://my.hub.toocle.com" style="color: #666;">助手首页 </a>&nbsp;></span><span class="fl" style="font-size:12px;">电话会议</span>
	<?php else: ?><img class="fl" src="http://ui.s.toocle.com/images/member/nav/10.gif" width=23 height=23 style="margin-top:2px;"/><span class="fl"><a href="http://my.hub.toocle.com" style="color: #666;">助手首页 </a></span>&nbsp;&nbsp;> <a href="http://my.hub.toocle.com/index.php?_d=member&_a=member" style="font-size:12px;">会员信息</a>
	<?php endif; ?>
	</div>
 