<?php

    class C_Mkpage extends Controller
    {
                    
        public function __construct($setup)
        {
            parent::__construct($setup);

            $this->cache   =0;
            $this->expires = 1;

        }


        public function do_main()
        {
            $inputs  = self::$l_input->argv('', FALSE);
            $func = isset($inputs[1]) ? $inputs[1] : null;
	          if($func == 'build_de_index'){
							$this->do_build_de_index();
						}
						if($func == 'build_de_product'){
							$this->do_build_de_product();
						}
            else{
               exit;
            }
        }
        public function do_build_de_index()
				{
			
					$db_mkpage = $this->setup->get_model_handler('tmp/mkpage');
	
					 $db_category = $this->setup->get_model_handler('cate/category_de');
            $db_regional = $this->setup->get_model_handler('cate/regional_toocle');
            $db_company = $this->setup->get_model_handler('de/company_de');
            $db_product_show = $this->setup->get_model_handler('de/product_show');
          
           $db_product_de_featured = $this->setup->get_model_handler('de/product_de_featured');
            
            
            
            $db_product = $this->setup->get_model_handler('de/product_de');
            $db_buy = $this->setup->get_model_handler('de/buy_de');
            $db_sell = $this->setup->get_model_handler('de/sell_de');
            $db_index = $this->setup->get_model_handler('cate/index_de');
            $db_partners = $this->setup->get_model_handler('cate/partners');
            $res = array();
            
            $IndexConfig_pic = $db_index->get_profile(array('item' => 'IndexConfig_pic' ), $this->cache);
            $note = json_decode($IndexConfig_pic['note'],true);

            $res['pic']=$note['pic'];
            $res['counts']=$note['counts'];
          
            $opts=array('dbh' => 'show','len' => 2,'orderby' => 'cat_id','limit' => 30);
            $category = $db_category->get_list($opts,$this->cache);
            foreach($category as &$c){
            	$c['category'] = self::$l_string->substring($c['category'], 25);
            	$opts=array('dbh' => 'show','len' => 4,'cat_id' => $c['cat_id'],'orderby' => 'cat_id','limit' => 5);
            	$category_sub = $db_category->get_list($opts,$this->cache);
            	$i=1;
            	foreach($category_sub as &$cs){
            		$matches = explode('/',$cs['category']);
            		$cs['category'] = $matches[1];
            		if($i == 1){$cs['class'] = "first-sub-li";}
            		else{$cs['class'] = "";}
            		$i++;
            		
            	}
            	$c['list_sub'] = $category_sub;
            	
            }
            
            $res['list_category'] = $category;

            
            $opts=array('dbh' => 'show','fields' => 'id,company','limit' => 24);
            
            $company = $db_company->get_list($opts);
            
            $res['list_company'] = $company;
            
            
       
        
     
          
              $opts = array(
                'dbh' => 'list', 
                'fields' => 'p.id as pid, p.pic_name1,c.company,c.id as cid,c.rank_date,pf.id,pf.product,pf.status,pf.rank',          
            );

           $res1 = $db_product_de_featured->get_page_list($opts,$this->cache);
           $show = $res1['pw_rec_list'];
           
           foreach($show as &$s){
		            	$s['product1'] = self::$l_string->substring($s['product'], 13);
		            }
           $res['list_product_featured_de'] = $show;               
          
  //    print_r($show);
  //    exit;
           
          	

            $opts=array('dbh' => 'list','orderby' =>'post_date' ,'limit' => 11);
            $buy = $db_buy->get_list($opts,$this->cache);
            foreach($buy as &$b){
            	$opts = array('dbh' => 'show','poster' => $b['poster']);
            	$b_company = $db_company->get_profile($opts);

            	$opts1 = array('dbh' => 'show','cat_id' => $b_company['cate1']);
            	$regional = $db_regional->get_profile($opts1);
            	$b['regional'] = $regional['category_de'];
            	
            	$b['product'] = self::$l_string->substring($b['product'], 32);

            }
            $res['list_buy'] = $buy;
  
            $opts=array('dbh' => 'list','orderby' =>'post_date' , 'limit' => 11);
            $sell = $db_sell->get_list($opts,$this->cache);
            foreach($sell as &$s){
            	$opts = array('dbh' => 'show','poster' => $s['poster']);
            	$s_company = $db_company->get_profile($opts);
            	
            	$opts1 = array('dbh' => 'show','cat_id' => $s_company['cate1']);
            	$regional = $db_regional->get_profile($opts1);
            	$s['regional'] = $regional['category_de'];
            	$s['product'] = self::$l_string->substring($s['product'], 32);
            		
            }
            $res['list_sell'] = $sell;
            
            
            
            
             $opts=array('dbh' => 'show' ,'category' => 'de', 'orderby' => 'rank','status' => 1,'home' => 1);
            $partners = $db_partners->get_list($opts,$this->cache);
            $res['list_partners'] = $partners;
            $res['partners'] = 1;
            
			
					$res['_url_ui'] = $this->url_ui;
					$res['_url_img'] = $this->url_img;
				  $res['_url_base']=$this->url_base;
					$res['domain'] = "de";
			
					$template = "$this->deploy_root/UI/template/index/index-tmpl.html";
					$htmls = self::$l_output->fetch($template, $res, $this->expires);
					
					if(preg_match("/<\/html>/",$htmls)){
						$inputs = array('domain'=>'de','dir'=>'de/index.html','val'=>$htmls);
						$db_mkpage->mkpage(array('inputs' => $inputs));
					}
				}
			
			
				public function do_build_de_product()
				{
			
			
					$db_mkpage = $this->setup->get_model_handler('tmp/mkpage');
			
					$db_category = $this->setup->get_model_handler('cate/category_de');
					$db_regional = $this->setup->get_model_handler('cate/regional_de');
					$db_product = $this->setup->get_model_handler('de/product_de');
					$db_company = $this->setup->get_model_handler('de/company_de');
					$db_show = $this->setup->get_model_handler('de/product_show');
					$db_show_total = $this->setup->get_model_handler('de/product_show_total');
					$db_regional_toocle = $this->setup->get_model_handler('cate/regional_toocle');
			
					$inputs = self::$l_input->get();
					$c = isset($inputs['c']) ? $inputs['c'] : null;
					$v = isset($inputs['v']) ? $inputs['v'] : 11;
					//  $r = isset($inputs['r']) ? $inputs['r'] : '00';
					$page   = isset($inputs['p']) ? $inputs['p'] : null;
					$order   = isset($inputs['order']) ? $inputs['order'] : null;
					$addition   = isset($inputs['addition']) ? $inputs['addition'] : null;
					$page_record   = isset($inputs['pr']) ? $inputs['pr'] : null;
					if($page_record){
						$page_record= array('11' => $page_record,'12' => $page_record,'13' => $page_record);
					}
					else{
						$page_record= array('11' => 10,'12' => 16,'13' => 10);
					}
					// echo  $order.'--'.$c.'---'.$page.'----'.$addition;
			
				//	if($page > 100 or $page < 1)  $page = 1;
					$set_total = 20000;
					

			
					$c_cur=array();
					$r_cur=array();
					$category=array();
					$regional=array();
			
					$url_prefix = "";
					if(!$c) {$c = "00";$url_prefix.= "00/";}
					$url_prefix.= "Products-";
					//  if($r and $r <>'00') $url_prefix.=$r."-";
					$url_prefix.=$v."-";
					$url_suffix = '.html';
			
					if($c){
						$c_profile = $db_category->get_profile(array('dbh' => 'show','cat_id' => $c));
			
						$c_profile_all = $db_category->get_list(array('dbh' => 'show','cat_id' => $c,'len' => strlen($c)+2));
			//print_r($c_profile_all);
		//	exit;
						$cnames = explode("/",$c_profile['category']);
						$i=0;
						foreach($cnames as $cname){
							$arr= array();
							$arr['name'] = $cname;
							$arr['cat_id'] = substr($c,0,($i+1)*2);
							$i++;
							if($i == count($cnames)) $arr['is_last'] = 1;
							$c_cur[] = $arr;
						}
						$title = $cnames[$i-1];
			
			
			
					}
			
					$len_c=strlen($c);
					//   $len_r=strlen($r);
			
					if($len_c==2 and $c == "00" ){
						$opts = array(
						'dbh' => 'show',
						'cat_id' => '%',
						'lenmax'   => $len_c,
			
						);
						$categorys = $db_show_total->get_list($opts);
					//	print_r($categorys);
		//	exit;
						foreach($categorys as &$cate){
							$cate['cname'] = preg_replace("/.*?\//","",$cate['cname']);
							$category[] = $cate;
						}
			
					}
			
			
			
					if($c != "00" and  ($len_c==2 or $len_c==4)){
						$opts = array(
						'dbh' => 'show',
						'cat_id' => $c,
						'lenmax'   => $len_c+2,
						//   'regional' => $r,
						//   'lenmax_r' => $len_r
						);
						$categorys = $db_show_total->get_list($opts);
					//	print_r($categorys);
					//	exit;
						foreach($categorys as &$cate){
							$cate['cname'] = preg_replace("/.*?\//","",$cate['cname']);
							$category[] = $cate;
						}
			
					}
			
			
					///////////////对应类别下产品总数
					$field   = "";
					$cat_id = "";
			
					if($len_c >= 2 and $c != "00"){
			
						$field   = "c".$len_c;
						$cat_id = $c;
			
					}
					if($len_c == 2 and $c == "00"){
						$field   = "c2";
						$cat_id = "%";
					}
			
			
					$opts =array(
					'dbh' => 'show',
					'category' => $cat_id,
					'regional' => $r
					);
					$st = $db_show_total->get_profile($opts);
				//	var_dump($st);
				//	exit;
					if($st['total'] < $set_total ) $set_total = $st['total'];
			
			
			
					/////////////////右侧新产品
					$opts1 = array(
					'dbh'  => 'show',
					'order'     => 'pubDate',
					'field'  => $field,
					'curr_page'  => 1,
					'page_record' => 30
					);
			
					$new_products = $db_show->get_page_list($opts1,$this->cache);
					$list_news = $new_products['pw_rec_list'];
			
			
					foreach($list_news as &$l){
						$l['product1'] = self::$l_string->substring($l['product'], 24);
					}
			
			
			
			
					///////////////////对应类别下的产品
					$opts = array(
			
					'dbh' => 'show',
					'field'  => $field,
					'cat_id' => $cat_id,
					'order'   => $order,
					'is_pic_name1' => 1,
					'addition'   => $addition,
					'set_total' => $set_total,
					'curr_page'  => $page,
					'url_prefix' => $url_prefix,
					'url_suffix' => $url_suffix,
					'page_record' => $page_record[$v]
					);
			
					$res = $db_show->get_page_list($opts,$this->cache);
			
	 
			
			
			
			
					// echo "<br>2<br>";  var_dump($res['pw_rec_list']);exit;
					$list = $res['pw_rec_list'];//var_dump($list);
					foreach($list as &$l){
						$l['intro'] = self::$l_string->replace_html($l['intro']);
						$l['intro'] = self::$l_string->substring($l['intro'], 200);
						$l['product1'] = self::$l_string->substring($l['product'], 24);
						$l['company'] = $db_company->get_profile(array('dbh' => 'show','id' => $l['asid'],'fields' => 'company,rank_date,cate1'));
						$l['company']['company1'] = self::$l_string->substring($l['company']['company'], 24);
			
						$opts1 = array('dbh'  => 'show','cat_id'=> $l['company']['cate1']);
						$regional_toocle = $db_regional_toocle->get_profile($opts1,$this->cache);
						$l['company']['cate1'] = $regional_toocle['category_de'];
			
			
						if(!preg_match("/^(29|30)/",$l['company']['rank_date'])) $l['is_vip'] = 1;
						if(preg_match("/toocle\/album/",$l['pic_name1'])) $l['is_album'] = 1;
					}
					$res['listing'] = $list;
					$res['listing_news'] = $list_news;
					$pre = $page-1 ? $page-1 : 0;
					$next = $page+1 <= $res['pw_page_total'] ? $page+1 : 0;
					$res['pre'] = $pre;
					$res['next'] = $next;
					$res['title'] = $title;
					$res['c_cur'] = $c_cur;
					$res['r_cur'] = $r_cur;
					$res['v'] = $v;
					$res['c'] = $c;
					if($c == "00") $res['c_if'] = 1;
			
					$res['order'] = $order;
					$res['addition'] = $addition;
					$res['p'] = $page;
					if($r<>'00') $res['r'] = $r;
					$res['category'] = $category;
			
					$res['regional'] = $regional;
					$res['domain'] ="product";
					$res['total_no_display'] = 1;
			
			
			
			
					$res['_url_ui'] = $this->url_ui;
					$res['_url_img'] = $this->url_img;
				  $res['_url_base']=$this->url_base;
					$res['domain'] = "de/product";
			
					$template = "$this->deploy_root/UI/template/product/list.html";
					$htmls = self::$l_output->fetch($template, $res, $this->expires);
					if(preg_match("/<\/html>/",$htmls)){
						$inputs = array('domain'=>'de/product','dir'=>'de/product/list.html','val'=>$htmls);
						$db_mkpage->mkpage(array('inputs' => $inputs));
					}
				}

        
    }

?>