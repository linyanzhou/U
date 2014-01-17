<?php

    class M_Buy_de extends Model
    {
        public function __construct($setup)
        { 
            parent::__construct($setup);

            $config = $this->get_extend_datebase_config(dirname(__FILE__));
          //  $config_category = $this->get_datebase_config('category_en');
            $this->_table  = isset($config['buy_de']['table']) ? $config['buy_de']['table'] : null;
            $this->_fields = isset($config['buy_de']['fields']) ? $config['buy_de']['fields'] : null;
            $this->_select_units = isset($config['buy_de']['select_units']) ? $config['buy_de']['select_units'] : null;
            $this->_table_category = isset($config_category['table']) ? $config_category['table'] : null;
        }


        public function get_page_list($opts, $cache = 0)
        {
            $dbh    = isset($opts['dbh']) ? $opts['dbh'] : null;
            $ft     = isset($opts['ft']) ? $opts['ft'] : null;
            $terms  = isset($opts['terms']) ? $opts['terms'] : null;
            $choice  = isset($opts['choice']) ? $opts['choice'] : null;
            $edit_date = isset($opts['edit_date']) ? $opts['edit_date'] : null;
            $poster = isset($opts['poster']) ? $opts['poster'] : null;
            $status = isset($opts['status']) ? $opts['status'] : null;
            $category = isset($opts['category']) ? $opts['category'] : null;
            $orderby  = isset($opts['orderby']) ? $opts['orderby'] : null;
            $set_total  = isset($opts['set_total']) ? $opts['set_total'] : 0;

            $curr_page = (isset($opts['curr_page']) && $opts['curr_page'] > 0)
                ? $opts['curr_page'] : 1;
            $page_record = (isset($opts['page_record']) && $opts['page_record'] > 0)
                ? $opts['page_record'] : $this->page_record;

            $offset = ($curr_page - 1) * $page_record;

            $table = $this->_table;
            $cond  = 1;
            if($choice){
            	
            		if ($choice =='title') {
		                $terms = self::$DBM->add_sql_slashes($terms);
		                $cond .= " and  match(product) against('$terms' in boolean mode)  ";
		              }
		
		              elseif ($choice =='poster') {
		                $poster = self::$DBM->add_sql_slashes($poster);
		                $cond .= " and poster = '$terms' ";
		              }
		
		              elseif ($choice =='id') {
		              	if(is_numeric($terms))
		                $cond .= " and id = '$terms' ";
		              }
            
            
            }
            else{
       
		              if ($terms) {
		                $terms = self::$DBM->add_sql_slashes($terms);
		                $cond .= " and  match(product) against('$terms' in boolean mode)  ";
		              }
		
		              if ($poster) {
		                $poster = self::$DBM->add_sql_slashes($poster);
		                $cond .= " and poster = '$poster' ";
		              }
		
		              if ($category) {
		                $category = self::$DBM->add_sql_slashes($category);
		                $cond .= " and category like '$category%' ";
		              }
		       
		            if($edit_date){
		            	 $edit_date = self::$DBM->add_sql_slashes($edit_date);
		               $cond.= " and edit_date='$edit_date'";
		             }
		            //if ( is_numeric($status) )
		            //    $cond .= " and status = $status ";
						}
            $sql = " SELECT * FROM $table WHERE $cond ";
            $sql_count = " SELECT count(*) as total FROM $table WHERE $cond ";
            if($set_total>0) $sql_count = " SELECT '$set_total' as total";

            if ( $orderby == 'post_date' )
                $sql .= " ORDER BY post_date desc ";
            else
                $sql .= " ORDER BY id desc ";

            $sql .= " LIMIT $offset, $page_record ";
            //echo $sql_count;
            //echo $sql;
//            exit;

            $conn = self::$DBM->get_connect($dbh);

            return self::$DBM->get_page_list($conn, $sql, $sql_count, $opts, $cache);
        }

        public function get_profile($opts, $cache = 0)
        {
            $dbh = isset($opts['dbh']) ? $opts['dbh'] : null;
            $id  = isset($opts['id']) ? $opts['id'] : null;
            $poster = isset($opts['poster']) ? $opts['poster'] : null;
            $fields = isset($opts['fields']) ? $opts['fields'] : "*";
            $status = isset($opts['status']) ? $opts['status'] : null;
            $orderby = isset($opts['orderby']) ? $opts['orderby'] : null;
            if ($id <= 0 and !$orderby)
                return array();

            $table = $this->_table;
            $cond  = 1;

            if (is_numeric($id) && $id > 0)
                $cond .= " and id = $id ";

            if ($poster) {
                $poster = self::$DBM->add_sql_slashes($poster);
                $cond .= " and poster = '$poster' ";
            }
            if($orderby)
               $cond.= " order by id desc";
            //if ( is_numeric($status) )
            //    $cond .= " and status = $status ";

            $sql = " SELECT $fields FROM $table WHERE $cond limit 1 ";
            //echo $sql;
            //exit;

            $conn = self::$DBM->get_connect($dbh);

            return self::$DBM->get_row($conn, $sql, $cache);
        }

        public function create($opts)
        {
        	  $dbh = isset($opts['dbh']) ? $opts['dbh'] : null;
            $inputs = isset($opts['inputs']) ? $opts['inputs'] : null;
            $fields = isset($opts['fields']) ? $opts['fields'] : $this->_fields;

            $fields_added = isset($opts['fields_added']) ? $opts['fields_added'] : null;
            if ( is_array($fields_added) )
                $fields = array_merge($fields, $fields_added);

            $table  = $this->_table;

            if ( count($inputs) > 0 && count($fields) > 0 ) {
                $p_fields = self::$DBM->get_execute_fields($inputs, $fields);
                $sql = " INSERT INTO $table SET " . join(',', $p_fields) ;
                //echo $sql;
                //exit;

                $conn = self::$DBM->get_connect($dbh);
                return self::$DBM->execute($conn, $sql);
            }
        }

        
        
        public function change($opts)
        {   
        	  $dbh = isset($opts['dbh']) ? $opts['dbh'] : null;
            $unpost = isset($opts['unpost']) ? $opts['unpost'] : null;
            $id     = isset($opts['id']) ? $opts['id'] : null;
            $poster = isset($opts['poster']) ? $opts['poster'] : null;
            $inputs = isset($opts['inputs']) ? $opts['inputs'] : null;
            $fields = isset($opts['fields']) ? $opts['fields'] : $this->_fields;

            $fields_added = isset($opts['fields_added']) ? $opts['fields_added'] : null;
            if ( is_array($fields_added) )
                $fields = array_merge($fields, $fields_added);

            $table  = $this->_table;

            if ( count($inputs) > 0 && count($fields) > 0 ) {
                $p_fields = self::$DBM->get_execute_fields($inputs, $fields);
                $sql = " UPDATE $table SET " . join(',', $p_fields);

              
                $sql .= " WHERE 1 ";
                
                if ( is_numeric($id) && $id > 0) {
                    if(is_numeric($id))
                        $sql.= " and id = $id ";

                    if ($poster) {
                        $poster = self::$DBM->add_sql_slashes($poster);
                        $sql .= " and poster = '$poster' ";
                    }
                    //echo $sql;
                    //exit;

                    $conn = self::$DBM->get_connect($dbh);
                    return self::$DBM->execute($conn, $sql);
                }
            }
        }

        public function delete($opts)
        {   
        	  $dbh = isset($opts['dbh']) ? $opts['dbh'] : null;
            $id = isset($opts['id']) ? $opts['id'] : null;
            $poster = isset($opts['poster']) ? $opts['poster'] : null;

            $table = $this->_table;

            if (is_numeric($id) && $id > 0) {
                $sql = " DELETE FROM $table WHERE id = $id ";
                $sql_log = " SELECT * FROM $table WHERE id = $id ";

                if ($poster) {
                    $poster = self::$DBM->add_sql_slashes($poster);
                    $sql .= " and poster = '$poster' ";
                    $sql_log .= " and poster = '$poster' ";
                }
                //echo $sql;
                //exit;

                $conn = self::$DBM->get_connect($dbh);
                return self::$DBM->Execute($conn, $sql, $sql_log);
            }
        }

     public function get_list($opts, $cache = 0)
        {
            $dbh      = isset($opts['dbh']) ? $opts['dbh'] : null;
            $poster   = isset($opts['poster']) ? $opts['poster'] : null;
            $category = isset($opts['category']) ? $opts['category'] : null;
            $orderby  = isset($opts['orderby']) ? $opts['orderby'] : null;
            $limit    = isset($opts['limit']) ? $opts['limit'] : null;
            $fields   = isset($opts['fields']) ? $opts['fields'] : " * ";
            $maxid=  isset($opts['maxid']) ? $opts['maxid'] : null;
            $table = $this->_table;
            
            
            if($maxid)
            {
            	
            	$cond="id>$maxid";
            	
               $sql = " SELECT $fields FROM $table WHERE $cond ";	
            	
            	
            }
            else
            {
            $cond  = 1;
            
//            if(!$poster and !$category)
//               return array();
//            
            if ($poster) {
                $poster = self::$DBM->add_sql_slashes($poster);
                $cond .= " and poster = '$poster' ";
            }

            if ($category) {
                $category = self::$DBM->add_sql_slashes($category);
                $cond .= " and category like '$category%' ";
            }

            if ($orderby == 'post_date'){
                $cond .= " order by post_date desc ";
            }
            elseif($orderby == "id_asc"){
            	  $cond .= " order by id asc ";
            }
            else{
                $cond .= " order by id desc ";
            }
            if ($limit > 0 &&  is_numeric($limit))
                $cond .= " limit $limit ";

            $sql = " SELECT $fields FROM $table WHERE $cond ";
            
          }
          //  echo $sql;
            //exit;

            $conn = self::$DBM->get_connect($dbh);

            return self::$DBM->get_list($conn, $sql, $cache);
        }

        public function get_list_category($opts, $cache = 0)
        {
            $dbh     = isset($opts['dbh']) ? $opts['dbh'] : null;
            $poster  = isset($opts['poster']) ? $opts['poster'] : null;
            $orderby = isset($opts['orderby']) ? $opts['orderby'] : null;
            $limit   = isset($opts['limit']) ? $opts['limit'] : null;

            if (! $poster)
                return array();

            $table = "$this->_table as p ";
            $table .= " left join $this->_table_category as c on (p.category = c.cate_id) ";
            $cond  = 1;

            if ($poster) {
                $poster = self::$DBM->add_sql_slashes($poster);
                $cond .= " and p.poster = '$poster' ";
            }

            $cond .= " group by p.category ";

            if ($orderby == 'category')
                $cond .= " order by p.category ";
            else
                $cond .= " order by p.category ";

            if ($limit > 0 &&  is_numeric($limit))
                $cond .= " limit $limit ";

            $sql = " SELECT c.cate_id, c.name FROM $table WHERE $cond ";
            //echo $sql;
            //exit;

            $conn = self::$DBM->get_connect($dbh);

            return self::$DBM->get_list($conn, $sql, $cache);
        }

        public function get_page_list1($opts, $cache = 0)
        {
            $dbh    = isset($opts['dbh']) ? $opts['dbh'] : null;
            $terms  = isset($opts['terms']) ? $opts['terms'] : null;
            $poster = isset($opts['poster']) ? $opts['poster'] : null;
            $status = isset($opts['status']) ? $opts['status'] : null;
            $category = isset($opts['category']) ? $opts['category'] : null;
            $fields  = isset($opts['fields']) ? $opts['fields'] : " * ";
            $orderby  = isset($opts['orderby']) ? $opts['orderby'] : null;
            $set_total  = isset($opts['set_total']) ? $opts['set_total'] : 0;

            $curr_page = (isset($opts['curr_page']) && $opts['curr_page'] > 0)
                ? $opts['curr_page'] : 1;
            $page_record = (isset($opts['page_record']) && $opts['page_record'] > 0)
                ? $opts['page_record'] : $this->page_record;

            $offset = ($curr_page - 1) * $page_record;

            $table = "$this->_table";
            $cond  = 1;

            if ($terms) {
                $terms = self::$DBM->add_sql_slashes($terms);
                $cond .= " and title like '%$terms%' ";
            }

            if ($poster) {
                $poster = self::$DBM->add_sql_slashes($poster);
                $cond .= " and poster = '$poster' ";
            }

            if ($category) {
                $category = self::$DBM->add_sql_slashes($category);
                $cond .= " and category like '$category%' ";
            }

            $sql = " SELECT $fields FROM $table WHERE $cond ";
            $sql_count = " SELECT count(*) as total FROM $table WHERE $cond ";
            if($set_total>0) $sql_count = " SELECT '$set_total' as total";

            if ( $orderby == 'post_date' )
                $sql .= " ORDER BY post_date desc ";
            else
                $sql .= " ORDER BY id desc ";

            $sql .= " LIMIT $offset, $page_record ";
            //echo $sql_count;
            //echo $sql;
            //exit;

            $conn = self::$DBM->get_connect($dbh);

            return self::$DBM->get_page_list($conn, $sql, $sql_count, $opts, $cache);
        }

        public function get_list_for_show($opts, $cache = 0)
        {
            $dbh     = isset($opts['dbh']) ? $opts['dbh'] : null;
            $minid  = isset($opts['minid']) ? $opts['minid'] : null;
            $maxid = isset($opts['maxid']) ? $opts['maxid'] : null;

            if (!$minid or !$maxid)
                return array();

            $table = $this->_table;
            $cond  = 1;

            if ($maxid and is_numeric($minid) and $minid  and is_numeric($minid)) {
                $cond .= " and id >= $minid and id <= $maxid ";
            }
            //$cond .= " and c.status=1";
            $sql = " SELECT id,category,pic_name1,ctime FROM $table WHERE $cond ";
//            $sql= "SELECT p.id,p.category,p.pic_name1,c.cate1 as regional,c.rank_date as vip_date 
//                   FROM toocle_suppliers_data.product_cn as p 
//                   left join toocle_suppliers_data.company_cn as c on p.asid=c.id
//                   WHERE $cond and c.quality=1"; 
            //echo $sql."\n";
            //exit;

            $conn = self::$DBM->get_connect($dbh);

            return self::$DBM->get_list($conn, $sql, $cache);
        }

        public function get_list_for_cp($opts, $cache = 0)
        {
            $dbh     = isset($opts['dbh']) ? $opts['dbh'] : null;
            $minid  = isset($opts['minid']) ? $opts['minid'] : null;
            $maxid = isset($opts['maxid']) ? $opts['maxid'] : null;

            if (!$minid or !$maxid)
                return array();

            $table = $this->_table;
            $cond  = 1;

            if ($maxid and is_numeric($minid) and $minid  and is_numeric($minid)) {
                $cond .= " and id >= $minid and id <= $maxid ";
            }
            //$cond .= " and c.status=1";
            $sql = " SELECT * FROM $table WHERE $cond ";
            //echo $sql."\n";
            //exit;

            $conn = self::$DBM->get_connect($dbh);

            return self::$DBM->get_list($conn, $sql, $cache);
        }                
    
        public function get_total($opts, $cache = 0)
        {
            $dbh = isset($opts['dbh']) ? $opts['dbh'] : null;
            $poster = isset($opts['poster']) ? $opts['poster'] : null;
            
            if (!$poster)
                return array('total'=>100000);

            $table = $this->_table;
            $poster = self::$DBM->add_sql_slashes($poster);
            $cond = " poster = '$poster' ";

            $sql = " SELECT count(*) as total FROM $table WHERE $cond ";
            //echo $sql;
            //exit;

            $conn = self::$DBM->get_connect($dbh);

            return self::$DBM->get_row($conn, $sql, $cache);
        }
        
          public function get_maxid($opts, $cache = 0)  //获取未更新的最大的id
        {
        	
        $dbh      = isset($opts['dbh']) ? $opts['dbh'] : null;
        $table = $this->_table;
        $cond  = "1";
        $sql = " SELECT max(id) as maxid FROM $table WHERE $cond ";
        
   
        $conn = self::$DBM->get_connect($dbh);

         return self::$DBM->get_list($conn, $sql, $cache);	
        
        }
    
    }

?>