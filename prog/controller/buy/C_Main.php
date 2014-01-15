<?php

    class C_Main extends Controller
    {
        public function __construct($setup)
        {
            parent::__construct($setup);

            $this->cache   =0;//memcache
            $this->expires = 0;//浏览器缓存
        }
        
          public function do_main(){
        	
        	  $this->do_list();
        	
        	
        }
           public function do_list(){
        	  $inputs  = self::$l_input->request();     
            $db_category = $this->setup->get_model_handler('cate/category');     
      
            $db_product = $this->setup->get_model_handler('base/product');
            
            $page   = isset($inputs['p']) ? $inputs['p'] : null;
   
            $page > 0
                 or $page = 1;
 
            $page_record = 3;
            $page_width  = 10;
           	/*         	 
        	  if($terms){
            		$url_prefix = self::$l_uri->make_url($inputs, array('terms'));
            		$url_prefix .= '&p=';
          	}
          	else{
          			$url = explode('/',$_SERVER["REQUEST_URI"]);
          			$url_rewrite = $url[1]."/".$url[2];
 
		            
		            $url_prefix .= 'Directory-';
		            $url_suffix  = '.html';   //伪静态化
          	}
          	*/       	     	
            $terms = trim($terms);
            $url_prefix  = self::$l_uri->make_url($inputs, array('_d', '_a', 'f', 'terms', 'choice', 'regional'));
            $url_prefix .= "&p=";
            
            $opts = array(
                'terms'  => $terms,
                'choice' => $choice,
                'regional'   => $regional,
                'curr_page'  => $page,
                'url_prefix' => $url_prefix
            );
          	
          	$opts = array(
            'dbh'  => 'default',
                'terms'			=> $terms,            		
                'curr_page'  => $page,
                'page_record' => $page_record,
                'page_width'  => $page_width,
                'url_prefix' => $url_prefix,
                'url_suffix' => $url_suffix
            );
          	
        	  $res=$db_product->get_page_list($opts,$this->cache);
        	  $product = $res['pw_rec_list'];
        	  foreach ($product as &$value){
        	  	
        	  	$cate_id=$value['cate_id'];	 	
        	  	$opts=array(
        	  	'dbh' => 'default',
        	  	'cate_id' => $cate_id,        	  	
        	  	);
        	  $list=$db_category->get_profile($opts,$this->cache);
        	  $value['cate_name']=$list['cate_name'];  	
        	  	
        	  }
        	  $res['list_product']=$product;
        	  
        	   
        	  $template = "offer-to-buy.html";
            self::$l_output->display($template, $res, $this->expires);
       	   	
        	}
        
        
        
        function do_detail(){
      	 $res=array();
      	 $template = "add_product.html";
         self::$l_output->display($template, $res, $this->expires);
      	
     		 }
      
      
      
      
       
      
      
      	function do_add(){
      	
    		$inputs  = self::$l_input->request();    
    		$db_product = $this->setup->get_model_handler('base/product');  	  
      	$product_img=isset($inputs['g_image'])? $inputs['g_image']:null;
      	$product_name=isset($inputs['product_name'])? $inputs['product_name']:null;
      	$category=isset($inputs['category'])? $inputs['category']:null;
      	$create_time=isset($inputs['create_time'])? $inputs['create_time']:null;
      	$opts=array(
      	'dbh'=>'default',
      	'inputs'=> array(
      	'product_name' => $product_name,
      	'cate_id' => $category,
      	'product_img' => $product_img,
      	'create_time' => $create_time
      	)     
      	);
      	
      	$res=$db_product->create($opts);
      
      
        if($res){
        $action="?f=main";
        self::$l_uri->redirect($action, $res);	
        }else{
        	
        echo "新建产品错误。";
        }     	
      	}
      	
      	
      	function do_edit(){
      	$inputs=self::$l_input->request(); 
      	$id=isset($inputs['id'])? $inputs['id']:null;
      	
    
      	$db_product=$this->setup->get_model_handler('base/product');  	
      	$opts=array(
      	'dbh'=>'default',
      	'id' => $id,
      	
      	);
      	$res=$db_product->get_profile($opts,$this->cache);
         	
      	$template = "add_product.html";
        self::$l_output->display($template, $res, $this->expires);
      	}
      	
      	
      	
      	function do_change(){
      	$inputs=self::$l_input->request(); 
      	$id=isset($inputs['id'])? $inputs['id']:null;
      	$product_name=isset($inputs['product_name'])? $inputs['product_name']:null;
      	$category=isset($inputs['category'])? $inputs['category']:null;
      	$product_img=isset($inputs['product_img'])? $inputs['product_img']:null;
      	$create_time=isset($inputs['create_time'])? $inputs['create_time']:null;
 	      $db_product=$this->setup->get_model_handler('base/product');  	
      	$opts=array(
      	'dbh'=>'default',
      	'id' => $id,
      	'inputs'=> array(
      	'product_name' => $product_name,
      	'product_img' => $product_img,
      	'cate_id' => $category,      	
      	'create_time' => $create_time
      	)    
      	);
      	$res=$db_product->change($opts);  
      	if($res){	
      	$action="?f=main";
        self::$l_uri->redirect($action, $res);	      		
      	}else{
      		
      	echo"更新产品错误。";	
      	
      	}	
      	}
      	
      	function do_delete(){
      	$inputs=self::$l_input->request(); 
      	$id=isset($inputs['id'])? $inputs['id']:null;	
      	$db_product=$this->setup->get_model_handler('base/product'); 
      	$opts=array(
      	'dbh'=>'default',
      	'id' => $id,
        );
        
        $res=$db_product->delete($opts); 
        if($res){	
      	$action="?f=main";
        self::$l_uri->redirect($action, $res);	      		
      	}else{
      		
      	echo"删除产品错误。";	
      	}	
        	
      	}
      	
      	 
      
    }

?>