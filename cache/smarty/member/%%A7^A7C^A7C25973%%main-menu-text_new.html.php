<?php /* Smarty version 2.6.26, created on 2014-01-16 10:59:34
         compiled from Share/main-menu-text_new.html */ ?>
 	<div class="sidebarbjc fl">

    <div class="sidebar">
        <ul>
            <li class="sidelist"><a href="/" class="orange">Startseite</a></li>
            
            
            <li rel="1" class="sidelist" id="menu_title"><a href="" class="father">Angebot Information</a>
                <ul class="mb5" >
                    <li class="def" id="menu_sell_de-detail"><a href="?_a=sell_de&f=detail">Angebotsausgabe</a></li>
                    <li class="def" id="menu_sell_de"><a href="?_a=sell_de">Angebotsliste </a></li>
                </ul>
            </li>
            <li rel="1" class="sidelist" id="menu_title"><a href="" class="father">Einkaufsinformation</a>
                <ul class="mb5">
                    <li class="def" id="menu_buy_de-detail"><a href="?_a=buy_de&f=detail"> Einkaufsausgabe</a></li>
                    <li class="def" id="menu_buy_de"><a href="?_a=buy_de">Einkaufsliste</a></li>
                </ul>
            </li>

                 
         
            
        </ul>
    </div>
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

      $menu.addClass('act');
      menu_show($menu, true);
    }

  });
</script>