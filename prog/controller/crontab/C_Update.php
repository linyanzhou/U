<?php

    class C_Update extends Controller
    {
        
        public function __construct($setup)
        {
            parent::__construct($setup);

           $this->cache   = 0;
           $this->expires = 1;

        }


        public function do_main()    //之前版本  先执行company  再执行product   会有bug 国际站如果加测试公司 国际站的maxid就会变大   并且如果国家站相对应的公司有加产品的话  这种写法 国际站产品会更新不上去
        {
            $inputs  = self::$l_input->argv('', FALSE);
            $func = isset($inputs[1]) ? $inputs[1] : null;
            ini_set('memory_limit', '2048M'); //内存限制
            set_time_limit(0);
            
           
						if($func =='company_fr'){
               $this->do_update_company_fr();
            }else if($func =='product_fr'){
               $this->do_update_product_fr();
            }else if($func =='sell_fr'){
               $this->do_update_sell_fr();
            }else if($func =='buy_fr'){
               $this->do_update_buy_fr();
            }else if($func =='company_vn'){
               $this->do_update_company_vn();
            }else if($func =='product_vn'){
               $this->do_update_product_vn();
            }else if($func =='sell_vn'){
               $this->do_update_sell_vn();
            }else if($func =='buy_vn'){
               $this->do_update_buy_vn();
            }else if($func =='company_de'){
               $this->do_update_company_de();
            }else if($func =='product_de'){
               $this->do_update_product_de();
            }else if($func =='sell_de'){
               $this->do_update_sell_de();
            }else if($func =='buy_de'){
               $this->do_update_buy_de();
            }else{
               exit;
            }
        }
        
        
        public function do_update_company_fr()//法国产品列表
        {
       

        
          
         $db_company = $this->setup->get_model_handler('fr/company_fr');
         $db_member = $this->setup->get_model_handler('auth/member');
         $db_member_to_group = $this->setup->get_model_handler('auth/member_to_group');
         $db_commaxid=$this->setup->get_model_handler('fr/company_maxid');
         $opts=array('dbh'=>'list'); 
         $res=$db_commaxid->get_updateid($opts);//国家站上次更新后的maxid
         $maxid=$res[0]['uid'];
        
       
         $maxid  = isset($maxid) ? $maxid : null;
       
          
         $url  = "http://fr.toocle.com/?f=company&maxid=$maxid";
       
     
   	     $data = file_get_contents($url);
   	  
   	     $data =json_decode($data, true);   
   	     
   	      $maxid1  =$data['maxid'][0]['maxid'];//国家站目前的最大id
   	     
   	   if($maxid==$maxid1){
   	   	echo '无更新';
   	   	exit;
   	   	
   	  }else
   	  {
   	  	

   	  
   	  	
   	  	
   	     foreach($data as $key => $l){
   	     	if(!is_numeric($key))	continue;
   	     	
   	     	
   	     $id=$l['id'];
   	     $post_date=$l['post_date'];
   	     $poster=$l['poster'];
   	     $editor=$l['editor'];
   	     $status=$l['status'];
   	     $cate1=$l['cate1'];
   	     $company=$l['company'];
   	     $address=$l['address'];
   	     $zip=$l['zip'];
   	     $company_http=$l['company_http'];
   	     $pic_name1=$l['pic_name1'];
   	     $pic_name2=$l['pic_name2'];
   	     $tel=$l['tel'];
   	     $fax=$l['fax'];
   	     $email=$l['email'];
   	     $mobile=$l['mobile'];
   	     $intro=$l['intro'];
   	     $company_fr=$l['company_fr'];       
   	     $fields_added=array('id', 'pic_name1','pic_name2'); 
   	     $opts=array(
   	     
        'inputs' => array(
        'post_date'  => $post_date,
        'poster' => $poster,
        'editor' => $editor,
        'status' => $status,
         
        'cate1' => $cate1,
        'company' => $company, 
        'address' => $address,
        'zip' => $zip,
        'address'  => $address,
        'company_http'  => $company_http,
        'pic_name1' => $pic_name1,
        'pic_name2' => $pic_name2,
        'tel'=> $tel,
        'fax' => $fax,
        'email' => $email,
        'mobile' => $mobile,
        'intro' => $intro,
        'company_fr' => $company_fr,    
),
        'fields_added' => $fields_added
);
$opts1=array(
'dbh' => 'list' ,'poster' => $poster
);
 $result= $db_company->get_profile($opts1); //判断原先的company表中有么有poster，有的话  说明有重复添加 跳出循环，下一个 	 
if($result==false){
	
 $res= $db_company->create($opts);  
 
 
 
$this->do_wget_pic_to_intl($pic_name1);
$this->do_wget_pic_to_intl($pic_name2);
 
 $url = "http://fr.toocle.com/?f=member&poster=$poster";
 $data= file_get_contents($url);
 $data =json_decode($data, true);   
	
$opts = array(
               'inputs' => $data,
               'fields' => array(
                        'login','passwd','email','intro','status','firstname','company','position',
                        'regional','address','tel','fax','mobile','im_type','im_account','mtype',
                        'mdate','poster_id','post_ip','last_login_time'
                        )
                        );

$new_mid = $db_member->create($opts);
if ($new_mid) {
                    $opts = array(
                        'inputs' => array(
                            'member_id' => $new_mid,
                            'group_id' => 32,
                            'post_ip' => $post_ip
                            ),
                        'fields' => array(
                        'member_id','group_id','post_ip'
                        )
                        );
 $db_member_to_group->create($opts);

}



}
else{
   	continue;
  } 
 }
 
 $opts=array(   	  
   	    'inputs' => array( 
   	    'maxid'=> $maxid1
   	    )
   	    
   	    );
   	     
    $new_id=$db_commaxid->create($opts); 
   	    
   	 var_dump($new_id);
 
 }
}

//-----------------------------------------------------------        
        
        public function do_update_product_fr()
        {
        
         $db_product = $this->setup->get_model_handler('fr/product_fr');
         $db_company = $this->setup->get_model_handler('fr/company_fr');
         $db_promaxid=$this->setup->get_model_handler('fr/product_maxid');
         $opts=array('dbh'=>'list'); 
         $res=$db_promaxid->get_updateid($opts);//国家站上次更新后的maxid
         $maxid=$res[0]['uid'];
        
        
         $url  = "http://fr.toocle.com/?f=product&maxid=$maxid";
    
         
   	     $data = file_get_contents($url);
   	  
   	     $data =json_decode($data, true);
   
   	       $maxid1  =$data['maxid'][0]['maxid'];//国家站目前的最大id
   	   
   	   if($maxid==$maxid1){
   	   	echo '无更新';
   	   	exit;
   	   	
   	  }else
   	  {
         
   	     $fields=array('asid','editor','poster','pubDate','http','status','rank','cate','category','cate1','cate2','cate3','product','tag',
   	     'spec','brief','packing','uses','intro','type','pmin','pmax','quantity','certification','pic_name','pic_name1','quality','shows','ip_address','rid','show_rank','t_rank','searchKeywords','sysAttr','MainMarkets','HSCode','capacity','unit1','cap_per','delivery',
   	     'miniOrder','unit2','price','price_unit','unit3','port','payment');	
   	     
   	     foreach($data as $key => $l){
   	    if(!is_numeric($key))	continue;
   	    
   	    $poster=$l['poster'];
   	    $pic_name1=$l['pic_name1'];
   	    
   	   
   	    $opts=array (
   	    'dbh' => 'show',
   	    'poster' => $poster
   	    ); 
   	    
   	    
   	   $result=$db_company->get_profile($opts);
   	    
   	    	
   	   $asid=$result['id'];
   	   $l['asid']=$asid;
   	   
   	 
   	   $opts=array (
   	     'inputs' => $l,
   	     'fields'=> $fields

   	    );
   	    $res = $db_product->create($opts);   
   	   $this->do_wget_pic_to_intl($pic_name1);
   	    
   	     }
   	     $opts=array(   	  
   	    'inputs' => array( 
   	    'maxid'=> $maxid1
   	    )
   	    
   	    );
   	     
    $new_id=$db_promaxid->create($opts); 
   	    
    var_dump($new_id); 
   	             	
   	    }
        
    }    
 //-------------------------------------------------------    
        public function do_update_sell_fr()
        {
        
         $db_sell =$this->setup->get_model_handler('fr/sell_fr');
        
         $db_sellmaxid=$this->setup->get_model_handler('fr/sell_maxid');
         $opts=array('dbh'=>'list'); 
         $res=$db_sellmaxid->get_updateid($opts);//国家站上次更新后的maxid
         $maxid=$res[0]['uid'];
        
        
         $url  = "http://fr.toocle.com/?f=sell&maxid=$maxid";//maxid是sell的
    
         
   	     $data = file_get_contents($url);
   	  
   	     $data =json_decode($data, true);
   
   	     $maxid1  =$data['maxid'][0]['maxid'];//国家站目前的最大id
   	     
   	   if($maxid==$maxid1){
   	   	echo '无更新';
   	   	exit;
   	   	
   	  }else
   	  {
   	     $fields=array('sid','transaction_code','product','cas_no','specs','category','origin',
   	     'quantity','quantity_unit','price','currency','price_unit','shipping_terms',
   	     'shipping_year','shipping_month','shipping_day','payment',
   	     'expiry_date','additional_detail','pic_name1','userid','company','country','contact',
   	     'tel','fax','email','http','cate','poster','mtype_fr','editor','ip_address',
   	     'status','rank','quality','cate1','cate2','address');
   	     
   	     foreach($data as $key => $l){
   	     	if(!is_numeric($key))	continue;
   	   
   	  
   	    $poster=$l['poster'];
   	    $pic_name1=$l['pic_name1'];
   	    $product=$l['product'];

   	 	  $opts=array (
   	     'inputs' => $l,
   	     'fields'=> $fields
   	    );
   	    
   	    $res = $db_sell->create($opts);
   	    $this->do_wget_pic_to_intl($pic_name1);
   	   
   	    }
   	     $opts=array(   	  
   	    'inputs' => array( 
   	    'maxid'=> $maxid1
   	    )
   	    
   	    );
   	     
   	  $new_id=$db_sellmaxid->create($opts); 
   	    
   	  var_dump($new_id);
   	}
   	             	
   	    } 
   	    
   	    
   	    
   	    
   	    
   	    
   	       public function do_update_buy_fr()
        {
        
         $db_buy =$this->setup->get_model_handler('fr/buy_fr');
        
         $db_buymaxid=$this->setup->get_model_handler('fr/buy_maxid');
         $opts=array('dbh'=>'list'); 
         $res=$db_buymaxid->get_updateid($opts);//国家站上次更新后的maxid
         $maxid=$res[0]['uid'];
        
        
         $url  = "http://fr.toocle.com/?f=buy&maxid=$maxid";//maxid是sell的
    
         
   	     $data = file_get_contents($url);
   	  
   	     $data =json_decode($data, true);
   
   	     $maxid1  =$data['maxid'][0]['maxid'];//国家站目前的最大id
   	     
   	   if($maxid==$maxid1){
   	   	echo '无更新';
   	   	exit;
   	   	
   	  }else
   	  {
   	     $fields=array('sid','transaction_code','product','cas_no','specs','category','origin',
   	     'quantity','quantity_unit','price','currency','price_unit','shipping_terms',
   	     'shipping_year','shipping_month','shipping_day','payment',
   	     'expiry_date','additional_detail','pic_name1','userid','company','country','contact',
   	     'tel','fax','email','http','cate','poster','editor','ip_address','webSite',
   	     'status','rank','quality','cate1','cate2','address');
   	     
   	     foreach($data as $key => $l){
   	     	if(!is_numeric($key))	continue;
   	  
   	  
   	    $poster=$l['poster'];
   	    $pic_name1=$l['pic_name1'];
   	    $product=$l['product'];

   	 	  $opts=array (
   	     'inputs' => $l,
   	     'fields'=> $fields
   	    );
   	    
   	  $res = $db_buy->create($opts);
   	  $this->do_wget_pic_to_intl($pic_name1);
   	   
   	    }
   	     $opts=array(   	  
   	    'inputs' => array( 
   	    'maxid'=> $maxid1
   	    )
   	    
   	    );
   	     
   	 $new_id=$db_buymaxid->create($opts); 
   	    
   	  var_dump($new_id);
   	}
   	             	
   	    }  
   	    
//####################################################################################
        public function do_update_company_vn()//法国产品列表
        {
       

        
          
         $db_company = $this->setup->get_model_handler('vn/company_vn');
         $db_member = $this->setup->get_model_handler('auth/member');
         $db_member_to_group = $this->setup->get_model_handler('auth/member_to_group');
         $db_commaxid=$this->setup->get_model_handler('vn/company_maxid');
         $opts=array('dbh'=>'list'); 
         $res=$db_commaxid->get_updateid($opts);//国家站上次更新后的maxid
         $maxid=$res[0]['uid'];
        
       
         $maxid  = isset($maxid) ? $maxid : null;
       
          
         $url  = "http://vn.toocle.com/?f=company&maxid=$maxid";
       
     
   	     $data = file_get_contents($url);
   	  
   	     $data =json_decode($data, true);   
   	     
   	      $maxid1  =$data['maxid'][0]['maxid'];//国家站目前的最大id
   	     
   	   if($maxid==$maxid1){
   	   	echo '无更新';
   	   	exit;
   	   	
   	  }else
   	  {
   	     foreach($data as $key => $l){
   	     if(!is_numeric($key))	continue;
   	     	
   	     $id=$l['id'];
   	     $post_date=$l['post_date'];
   	     $poster=$l['poster'];
   	     $editor=$l['editor'];
   	     $status=$l['status'];
   	     $cate1=$l['cate1'];
   	     $company=$l['company'];
   	     $address=$l['address'];
   	     $zip=$l['zip'];
   	     $company_http=$l['company_http'];
   	     $pic_name1=$l['pic_name1'];
   	     $pic_name2=$l['pic_name2'];
   	     $tel=$l['tel'];
   	     $fax=$l['fax'];
   	     $email=$l['email'];
   	     $mobile=$l['mobile'];
   	     $intro=$l['intro'];
   	     $company_vn=$l['company_vn'];       
   	     $fields_added=array('id', 'pic_name1','pic_name2'); 
   	     $opts=array(
   	     
        'inputs' => array(
        'post_date'  => $post_date,
        'poster' => $poster,
        'editor' => $editor,
        'status' => $status,
         
        'cate1' => $cate1,
        'company' => $company, 
        'address' => $address,
        'zip' => $zip,
        'address'  => $address,
        'company_http'  => $company_http,
        'pic_name1' => $pic_name1,
        'pic_name2' => $pic_name2,
        'tel'=> $tel,
        'fax' => $fax,
        'email' => $email,
        'mobile' => $mobile,
        'intro' => $intro,
        'company_vn' => $company_vn,    
),
        'fields_added' => $fields_added
);
$opts1=array(
'dbh' => 'list' ,'poster' => $poster
);
 $result= $db_company->get_profile($opts1); //判断原先的company表中有么有poster，有的话  说明有重复添加 跳出循环，下一个 	 
if($result==false){
	
 $res= $db_company->create($opts);  
 
 
 
$this->do_wget_pic_to_intl_vn($pic_name1);
$this->do_wget_pic_to_intl_vn($pic_name2);
 
 $url = "http://vn.toocle.com/?f=member&poster=$poster";
 $data= file_get_contents($url);
 $data =json_decode($data, true);   
	
$opts = array(
               'inputs' => $data,
               'fields' => array(
                        'login','passwd','email','intro','status','firstname','company','position',
                        'regional','address','tel','fax','mobile','im_type','im_account','mtype',
                        'mdate','poster_id','post_ip','last_login_time'
                        )
                        );

$new_mid = $db_member->create($opts);
if ($new_mid) {
                    $opts = array(
                        'inputs' => array(
                            'member_id' => $new_mid,
                            'group_id' => 32,
                            'post_ip' => $post_ip
                            ),
                        'fields' => array(
                        'member_id','group_id','post_ip'
                        )
                        );
 $db_member_to_group->create($opts);

}



}
else{
   	continue;
  } 
 }
 $opts=array(   	  
   	    'inputs' => array( 
   	    'maxid'=> $maxid1
   	    )
   	    
   	    );
   	     
    $new_id=$db_commaxid->create($opts); 
   	    
   	 var_dump($new_id);
 
 }
}

//--------------------------------------------------------
     public function do_update_product_vn()
        {
        
         $db_product = $this->setup->get_model_handler('vn/product_vn');
         $db_company = $this->setup->get_model_handler('vn/company_vn');
         $db_promaxid=$this->setup->get_model_handler('vn/product_maxid');
         $opts=array('dbh'=>'list'); 
         $res=$db_promaxid->get_updateid($opts);//国家站上次更新后的maxid
         $maxid=$res[0]['uid'];
        
        
         $url  = "http://vn.toocle.com/?f=product&maxid=$maxid";
    
         
   	     $data = file_get_contents($url);
   	  
   	     $data =json_decode($data, true);
   
   	       $maxid1  =$data['maxid'][0]['maxid'];//国家站目前的最大id
   	   
   	   if($maxid==$maxid1){
   	   	echo '无更新';
   	   	exit;
   	   	
   	  }else
   	  {
         
   	     $fields=array('asid','editor','poster','pubDate','http','status','rank','cate','category','cate1','cate2','cate3','product','tag',
   	     'spec','brief','packing','uses','intro','type','pmin','pmax','quantity','certification','pic_name','pic_name1','quality','shows','ip_address','rid','show_rank','t_rank','searchKeywords','sysAttr','MainMarkets','HSCode','capacity','unit1','cap_per','delivery',
   	     'miniOrder','unit2','price','price_unit','unit3','port','payment');	
   	     
   	     foreach($data as $key => $l){
   	     	
   	    if(!is_numeric($key))	continue;
   	    $poster=$l['poster'];
   	    $pic_name1=$l['pic_name1'];
   	    
   	   
   	    $opts=array (
   	    'dbh' => 'show',
   	    'poster' => $poster
   	    ); 
   	    
   	    
   	   $result=$db_company->get_profile($opts);
   	    
   	    	
   	   $asid=$result['id'];
   	   $l['asid']=$asid;
   	   
   	 
   	   $opts=array (
   	     'inputs' => $l,
   	     'fields'=> $fields

   	    );
   	    $res = $db_product->create($opts);   
   	   $this->do_wget_pic_to_intl_vn($pic_name1);
   	   
   	     }
   	     $opts=array(   	  
   	    'inputs' => array( 
   	    'maxid'=> $maxid1
   	    )
   	    
   	    );
   	     
    $new_id=$db_promaxid->create($opts); 
   	    
    var_dump($new_id); 
   	             	
   	    }
        
    }  

//--------------------------------------------------------   	    
      	public function do_update_sell_vn()
        {
        
         $db_sell =$this->setup->get_model_handler('vn/sell_vn');
        
         $db_sellmaxid=$this->setup->get_model_handler('vn/sell_maxid');
         $opts=array('dbh'=>'list'); 
         $res=$db_sellmaxid->get_updateid($opts);//国家站上次更新后的maxid
         $maxid=$res[0]['uid'];
        
       
         $url  = "http://vn.toocle.com/?f=sell&maxid=$maxid";//maxid是sell的
    
         
   	     $data = file_get_contents($url);
   	  
   	     $data =json_decode($data, true);
   
   	     $maxid1  =$data['maxid'][0]['maxid'];//国家站目前的最大id
   	     
   	   if($maxid==$maxid1){
   	   	echo '无更新';
   	   	exit;
   	   	
   	  }else
   	  {
   	     $fields=array('sid','transaction_code','product','cas_no','specs','category','origin',
   	     'quantity','quantity_unit','price','currency','price_unit','shipping_terms',
   	     'shipping_year','shipping_month','shipping_day','payment',
   	     'expiry_date','additional_detail','pic_name1','userid','company','country','contact',
   	     'tel','fax','email','http','cate','poster','mtype_vn','editor','ip_address',
   	     'status','rank','quality','cate1','cate2','address');
   	     
   	     foreach($data as $key => $l){
   	     	
   	   
   	    if(!is_numeric($key))	continue;
   	    $poster=$l['poster'];
   	    $pic_name1=$l['pic_name1'];
   	    $product=$l['product'];

   	 	  $opts=array (
   	     'inputs' => $l,
   	     'fields'=> $fields
   	    );
   	    
   	    $res = $db_sell->create($opts);
   	    $this->do_wget_pic_to_intl_vn($pic_name1);
   	   
   	    }
   	     $opts=array(   	  
   	    'inputs' => array( 
   	    'maxid'=> $maxid1
   	    )
   	    
   	    );
   	     
   	  $new_id=$db_sellmaxid->create($opts); 
   	    
   	  var_dump($new_id);
   	}
   	             	
   	    }     
   	    
   	    
   	    
   	    
   	    public function do_update_buy_vn()
        {
        
         $db_buy =$this->setup->get_model_handler('vn/buy_vn');
        
         $db_buymaxid=$this->setup->get_model_handler('vn/buy_maxid');
         $opts=array('dbh'=>'list'); 
         $res=$db_buymaxid->get_updateid($opts);//国家站上次更新后的maxid
         $maxid=$res[0]['uid'];
       
        
         $url  = "http://vn.toocle.com/?f=buy&maxid=$maxid";//maxid是sell的
    
         
   	     $data = file_get_contents($url);
   	  
   	     $data =json_decode($data, true);
   
   	     $maxid1  =$data['maxid'][0]['maxid'];//国家站目前的最大id
   	   
   	   if($maxid==$maxid1){
   	   	echo '无更新';
   	   	exit;
   	   	
   	  }else
   	  {
   	     $fields=array('sid','transaction_code','product','cas_no','specs','category','origin',
   	     'quantity','quantity_unit','price','currency','price_unit','shipping_terms',
   	     'shipping_year','shipping_month','shipping_day','payment',
   	     'expiry_date','additional_detail','pic_name1','userid','company','country','contact',
   	     'tel','fax','email','http','cate','poster','editor','ip_address','webSite',
   	     'status','rank','quality','cate1','cate2','address');
   	     
   	     foreach($data as $key => $l){
   	     	
   	    if(!is_numeric($key))	continue;
   	  
   	    $poster=$l['poster'];
   	    $pic_name1=$l['pic_name1'];
   	    $product=$l['product'];

   	 	  $opts=array (
   	     'inputs' => $l,
   	     'fields'=> $fields
   	    );
   	    
   	  $res = $db_buy->create($opts);
   	  $this->do_wget_pic_to_intl_vn($pic_name1);
   	   
   	    }
   	     $opts=array(   	  
   	    'inputs' => array( 
   	    'maxid'=> $maxid1
   	    )
   	    
   	    );
   	     
   	 $new_id=$db_buymaxid->create($opts); 
   	    
   	  var_dump($new_id);
   	}
   	             	
   	    }   
  ##############################################################333
          public function do_update_company_de()//德国产品列表
        {
       

        
          
         $db_company = $this->setup->get_model_handler('de/company_de');
         $db_member = $this->setup->get_model_handler('auth/member');
         $db_member_to_group = $this->setup->get_model_handler('auth/member_to_group');
         $db_commaxid=$this->setup->get_model_handler('de/company_maxid');
         $opts=array('dbh'=>'list'); 
         $res=$db_commaxid->get_updateid($opts);//国家站上次更新后的maxid
         $maxid=$res[0]['uid'];
        
        
         $maxid  = isset($maxid) ? $maxid : null;
       
          
         $url  = "http://de.toocle.com/?f=company&maxid=$maxid";
        
     
   	     $data = file_get_contents($url);
   	  
   	     $data =json_decode($data, true);   
   	    // print_r($data);
       //  exit;
   	      $maxid1  =$data['maxid'][0]['maxid'];//国家站目前的最大id
   	    
   	   if($maxid==$maxid1){
   	   	echo '无更新';
   	   	exit;
   	   	
   	  }else
   	  {
   	  	

   	  
   	  	
   	  	
   	     foreach($data as $key => $l){
   	     	if(!is_numeric($key))	continue;
   	     	
   	     	
   	     $id=$l['id'];
   	     $post_date=$l['post_date'];
   	     $poster=$l['poster'];
   	     $editor=$l['editor'];
   	     $status=$l['status'];
   	     $cate1=$l['cate1'];
   	     $company=$l['company'];
   	     $address=$l['address'];
   	     $zip=$l['zip'];
   	     $company_http=$l['company_http'];
   	     $pic_name1=$l['pic_name1'];
   	     $pic_name2=$l['pic_name2'];
   	     $tel=$l['tel'];
   	     $fax=$l['fax'];
   	     $email=$l['email'];
   	     $mobile=$l['mobile'];
   	     $intro=$l['intro'];
   	     $company_de=$l['company_de'];       
   	     $fields_added=array('id', 'pic_name1','pic_name2'); 
   	     $opts=array(
   	     
        'inputs' => array(
        'post_date'  => $post_date,
        'poster' => $poster,
        'editor' => $editor,
        'status' => $status,
         
        'cate1' => $cate1,
        'company' => $company, 
        'address' => $address,
        'zip' => $zip,
        'address'  => $address,
        'company_http'  => $company_http,
        'pic_name1' => $pic_name1,
        'pic_name2' => $pic_name2,
        'tel'=> $tel,
        'fax' => $fax,
        'email' => $email,
        'mobile' => $mobile,
        'intro' => $intro,
        'company_de' => $company_de,    
),
        'fields_added' => $fields_added
);
$opts1=array(
'dbh' => 'list' ,'poster' => $poster
);
 $result= $db_company->get_profile($opts1); //判断原先的company表中有么有poster，有的话  说明有重复添加 跳出循环，下一个 	 
if($result==false){
	
 $res= $db_company->create($opts);  
 
 
 
$this->do_wget_pic_to_intl_de($pic_name1);
$this->do_wget_pic_to_intl_de($pic_name2);
 
 $url = "http://de.toocle.com/?f=member&poster=$poster";
 $data= file_get_contents($url);
 $data =json_decode($data, true);   
	
$opts = array(
               'inputs' => $data,
               'fields' => array(
                        'login','passwd','email','intro','status','firstname','company','position',
                        'regional','address','tel','fax','mobile','im_type','im_account','mtype',
                        'mdate','poster_id','post_ip','last_login_time'
                        )
                        );

$new_mid = $db_member->create($opts);
if ($new_mid) {
                    $opts = array(
                        'inputs' => array(
                            'member_id' => $new_mid,
                            'group_id' => 36,
                            'post_ip' => $post_ip
                            ),
                        'fields' => array(
                        'member_id','group_id','post_ip'
                        )
                        );
 $db_member_to_group->create($opts);

}



}
else{
   	continue;
  } 
 }
 
 $opts=array(   	  
   	    'inputs' => array( 
   	    'maxid'=> $maxid1
   	    )
   	    
   	    );
   	     
    $new_id=$db_commaxid->create($opts); 
   	    
   	 var_dump($new_id);
 
 }
}

//-----------------------------------------------------------        
        
        public function do_update_product_de()
        {
        
         $db_product = $this->setup->get_model_handler('de/product_de');
         $db_company = $this->setup->get_model_handler('de/company_de');
         $db_promaxid=$this->setup->get_model_handler('de/product_maxid');
         $opts=array('dbh'=>'list'); 
         $res=$db_promaxid->get_updateid($opts);//国家站上次更新后的maxid
         $maxid=$res[0]['uid'];
        
        
         $url  = "http://de.toocle.com/?f=product&maxid=$maxid";
    
         
   	     $data = file_get_contents($url);
   	  
   	     $data =json_decode($data, true);
   
   	       $maxid1  =$data['maxid'][0]['maxid'];//国家站目前的最大id
   	   
   	   if($maxid==$maxid1){
   	   	echo '无更新';
   	   	exit;
   	   	
   	  }else
   	  {
         
   	     $fields=array('asid','editor','poster','pubDate','http','status','rank','cate','category','cate1','cate2','cate3','product','tag',
   	     'spec','brief','packing','uses','intro','type','pmin','pmax','quantity','certification','pic_name','pic_name1','quality','shows','ip_address','rid','show_rank','t_rank','searchKeywords','sysAttr','MainMarkets','HSCode','capacity','unit1','cap_per','delivery',
   	     'miniOrder','unit2','price','price_unit','unit3','port','payment');	
   	     
   	     foreach($data as $key => $l){
   	    if(!is_numeric($key))	continue;
   	    
   	    $poster=$l['poster'];
   	    $pic_name1=$l['pic_name1'];
   	    
   	   
   	    $opts=array (
   	    'dbh' => 'show',
   	    'poster' => $poster
   	    ); 
   	    
   	    
   	   $result=$db_company->get_profile($opts);
   	    
   	    	
   	   $asid=$result['id'];
   	   $l['asid']=$asid;
   	   
   	 
   	   $opts=array (
   	     'inputs' => $l,
   	     'fields'=> $fields

   	    );
   	    $res = $db_product->create($opts);   
   	   $this->do_wget_pic_to_intl_de($pic_name1);
   	    
   	     }
   	     $opts=array(   	  
   	    'inputs' => array( 
   	    'maxid'=> $maxid1
   	    )
   	    
   	    );
   	     
    $new_id=$db_promaxid->create($opts); 
   	    
    var_dump($new_id); 
   	             	
   	    }
        
    }    
 //-------------------------------------------------------    
        public function do_update_sell_de()
        {
        
         $db_sell =$this->setup->get_model_handler('de/sell_de');
        
         $db_sellmaxid=$this->setup->get_model_handler('de/sell_maxid');
         $opts=array('dbh'=>'list'); 
         $res=$db_sellmaxid->get_updateid($opts);//国家站上次更新后的maxid
         $maxid=$res[0]['uid'];
        
        
         $url  = "http://de.toocle.com/?f=sell&maxid=$maxid";//maxid是sell的
    
         
   	     $data = file_get_contents($url);
   	  
   	     $data =json_decode($data, true);
   
   	     $maxid1  =$data['maxid'][0]['maxid'];//国家站目前的最大id
   	     
   	   if($maxid==$maxid1){
   	   	echo '无更新';
   	   	exit;
   	   	
   	  }else
   	  {
   	     $fields=array('sid','transaction_code','product','cas_no','specs','category','origin',
   	     'quantity','quantity_unit','price','currency','price_unit','shipping_terms',
   	     'shipping_year','shipping_month','shipping_day','payment',
   	     'expiry_date','additional_detail','pic_name1','userid','company','country','contact',
   	     'tel','fax','email','http','cate','poster','mtype_de','editor','ip_address',
   	     'status','rank','quality','cate1','cate2','address');
   	     
   	     foreach($data as $key => $l){
   	     	if(!is_numeric($key))	continue;
   	   
   	  
   	    $poster=$l['poster'];
   	    $pic_name1=$l['pic_name1'];
   	    $product=$l['product'];

   	 	  $opts=array (
   	     'inputs' => $l,
   	     'fields'=> $fields
   	    );
   	    
   	    $res = $db_sell->create($opts);
   	    $this->do_wget_pic_to_intl_de($pic_name1);
   	   
   	    }
   	     $opts=array(   	  
   	    'inputs' => array( 
   	    'maxid'=> $maxid1
   	    )
   	    
   	    );
   	     
   	  $new_id=$db_sellmaxid->create($opts); 
   	    
   	  var_dump($new_id);
   	}
   	             	
   	    } 
   	    
   	    
   	    
   	    
   	    
   	    
   	       public function do_update_buy_de()
        {
        
         $db_buy =$this->setup->get_model_handler('de/buy_de');
        
         $db_buymaxid=$this->setup->get_model_handler('de/buy_maxid');
         $opts=array('dbh'=>'list'); 
         $res=$db_buymaxid->get_updateid($opts);//国家站上次更新后的maxid
         $maxid=$res[0]['uid'];
        
        
         $url  = "http://de.toocle.com/?f=buy&maxid=$maxid";//maxid是sell的
    
         
   	     $data = file_get_contents($url);
   	  
   	     $data =json_decode($data, true);
   
   	     $maxid1  =$data['maxid'][0]['maxid'];//国家站目前的最大id
   	     
   	   if($maxid==$maxid1){
   	   	echo '无更新';
   	   	exit;
   	   	
   	  }else
   	  {
   	     $fields=array('sid','transaction_code','product','cas_no','specs','category','origin',
   	     'quantity','quantity_unit','price','currency','price_unit','shipping_terms',
   	     'shipping_year','shipping_month','shipping_day','payment',
   	     'expiry_date','additional_detail','pic_name1','userid','company','country','contact',
   	     'tel','fax','email','http','cate','poster','editor','ip_address','webSite',
   	     'status','rank','quality','cate1','cate2','address');
   	     
   	     foreach($data as $key => $l){
   	     	if(!is_numeric($key))	continue;
   	  
   	  
   	    $poster=$l['poster'];
   	    $pic_name1=$l['pic_name1'];
   	    $product=$l['product'];

   	 	  $opts=array (
   	     'inputs' => $l,
   	     'fields'=> $fields
   	    );
   	    
   	  $res = $db_buy->create($opts);
   	  $this->do_wget_pic_to_intl_de($pic_name1);
   	   
   	    }
   	     $opts=array(   	  
   	    'inputs' => array( 
   	    'maxid'=> $maxid1
   	    )
   	    
   	    );
   	     
   	 $new_id=$db_buymaxid->create($opts); 
   	    
   	  var_dump($new_id);
   	}
   	             	
   	    }   	        
        
        
   ######################################################################33     
        
          public function do_wget_pic_to_intl($pic = '')
        {
            $deploy = "$this->deploy_root/$this->file_folder/images/";
            $url = 'http://img.fr.toocle.com/0-0-0/'.$pic; //获取图片地址

            $path = $deploy.$pic;  //写入路径
            $path_tmp = $deploy.$pic."_tmp"; //临时写入路径
            
            // 写入路径权限设置
            if($pic){
                $realdir = '';
                $file_dir = explode('/',$path);
                array_pop($file_dir);
                foreach ($file_dir as $dir) {
                    if ( $dir == '' )
                      continue;
                   $realdir .= '/' . $dir;
                    if ( ! is_dir($realdir) ) {
                        if ( ! mkdir($realdir) ) {
                        return '';
                        }else{
                            `chmod 777 $realdir`;
                        }
                    }
                }

                $cmd = `wget -q -x -t3 -T5 -O $path_tmp $url`;

                if(is_file($path_tmp)){
                    if(filesize($path_tmp) > 10){//10 byte
                        `mv $path_tmp $path`;
                        `chmod 777 $path`;                        
                    }else{
                        `rm $path_tmp`;
                    }
                }
            }
            return '';
        }
        
        
        
          public function do_wget_pic_to_intl_vn($pic = '')
        {
            $deploy = "$this->deploy_root/$this->file_folder/images/";
            $url = 'http://img.vn.toocle.com/0-0-0/'.$pic; //获取图片地址

            $path = $deploy.$pic;  //写入路径
            $path_tmp = $deploy.$pic."_tmp"; //临时写入路径
            
            // 写入路径权限设置
            if($pic){
                $realdir = '';
                $file_dir = explode('/',$path);
                array_pop($file_dir);
                foreach ($file_dir as $dir) {
                    if ( $dir == '' )
                      continue;
                   $realdir .= '/' . $dir;
                    if ( ! is_dir($realdir) ) {
                        if ( ! mkdir($realdir) ) {
                        return '';
                        }else{
                            `chmod 777 $realdir`;
                        }
                    }
                }

                $cmd = `wget -q -x -t3 -T5 -O $path_tmp $url`;

                if(is_file($path_tmp)){
                    if(filesize($path_tmp) > 10){//10 byte
                        `mv $path_tmp $path`;
                        `chmod 777 $path`;                        
                    }else{
                        `rm $path_tmp`;
                    }
                }
            }
            return '';
        }
         
     public function do_wget_pic_to_intl_de($pic = '')
        {
            $deploy = "$this->deploy_root/$this->file_folder/images/";
            $url = 'http://img.de.toocle.com/0-0-0/'.$pic; //获取图片地址

            $path = $deploy.$pic;  //写入路径
            $path_tmp = $deploy.$pic."_tmp"; //临时写入路径
            
            // 写入路径权限设置
            if($pic){
                $realdir = '';
                $file_dir = explode('/',$path);
                array_pop($file_dir);
                foreach ($file_dir as $dir) {
                    if ( $dir == '' )
                      continue;
                   $realdir .= '/' . $dir;
                    if ( ! is_dir($realdir) ) {
                        if ( ! mkdir($realdir) ) {
                        return '';
                        }else{
                            `chmod 777 $realdir`;
                        }
                    }
                }

                $cmd = `wget -q -x -t3 -T5 -O $path_tmp $url`;

                if(is_file($path_tmp)){
                    if(filesize($path_tmp) > 10){//10 byte
                        `mv $path_tmp $path`;
                        `chmod 777 $path`;                        
                    }else{
                        `rm $path_tmp`;
                    }
                }
            }
            return '';
        }    
        
      }
        
        ?>