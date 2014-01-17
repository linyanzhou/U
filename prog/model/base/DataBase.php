  
  <?php
   $config['user'] = array(
        'table'  => 'u_base.user',
        'fields' => array(
            'g_id','username','password','create_time',
        )
    );
    
    $config['product'] = array(
        'table'  => 'u_base.product',
        'fields' => array(
            'cate_id','product_name','product_img','create_time',
        )
    );
    
    
    $config['buy_de'] = array(
        'table'  => 'u_base.buy_de',
        'fields' => array(
            'cate_id','product_name','product_img','create_time',
        )
    );
    
     $config['sell_de'] = array(
        'table'  => 'u_base.sell_de',
        'fields' => array(
            'cate_id','product_name','product_img','create_time',
        )
    );
    ?>