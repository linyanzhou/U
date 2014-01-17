<?php /* Smarty version 2.6.26, created on 2014-01-16 05:44:05
         compiled from Share/main-menu-text.html */ ?>

  <div class="menu">
		 
				<dl id="menu_title">
				 <dt rel="1" class="menu_title">Member Info</dt>
					<dd class="check" id="menu_member"><a href="?_a=member">Account Info </a></dd>
					<dd class="check" id="menu_member-passwd"><a href="?_a=member&f=passwd">Change Password</a></dd>
			    <dd class="check" id="menu_member-passwd"><a href="?_a=login&f=logout">logout</a></dd>
				</dl>	
				
				<dl id="menu_title">
				 <dt rel="1" class="menu_title">Showroom</dt>
					<dd class="check" id="menu_company_cn"><a href="?_a=company_de">My Profile </a></dd>
					<dd class="check" id="menu_product_cn"><a href="?_a=product_de">Product Catalog</a></dd>

					<dd class="check" id="menu_inquiry_en"><a href="?_a=inquiry_de">Inquiries</a></dd>				
				</dl>


				<dl id="menu_title">
				 <dt rel="1" class="menu_title">Offer to Sell</dt>
					<dd class="check" id="menu_company_cn"><a href="?_a=sell_de&f=detail">Post Selling Leads</a></dd>
					<dd class="check" id="menu_product_cn"><a href="?_a=sell_de">Manage Leads</a></dd>				
				</dl>
				
				<dl id="menu_title">
				 <dt rel="1" class="menu_title">Offer to Buy</dt>
					<dd class="check" id="menu_company_cn"><a href="?_a=buy_de&f=detail">Post Buying Leads</a></dd>
					<dd class="check" id="menu_product_cn"><a href="?_a=buy_de">Manage Leads</a></dd>		
				</dl>
				

				
			 
				
 </div>

<script>
  $(function() {

    var menu_slide = function($menu) {
      var $menus = $menu.parent().children('dd');
      $menus.slideToggle('fast');
    };

    var menu_show = function($menu, show) {
      var $menus = $menu.parent().children('dd');

      if (show)
        $menus.show();
      else
        $menus.hide();
    };

    $('[id=menu_title]').each( function() {
      $(this).children('dt')
        .click( function() {
          menu_slide($(this));
        })
        .each(function() {
          var rel = $(this).attr('rel');
          if (rel == '1')
            menu_show($(this), true);
          else
            menu_show($(this));
        });
    });

    var action = '<?php echo $this->_tpl_vars['_a']; ?>
';
    var func   = '<?php echo $this->_tpl_vars['f']; ?>
';

    if (action != '') {
      var $menu = $('#menu_' + action);
      var $menu_func = $('#menu_' + action + '-' + func);

      if ( $menu_func.length > 0 )
        $menu = $menu_func;

      $menu.addClass('active');
      menu_show($menu, true);
    }

  });
</script>