<?php

    class M_User extends Model
    {
        public function __construct($setup)
        { 
            parent::__construct($setup);

            $config = $this->get_extend_datebase_config(dirname(__FILE__));

            $this->_table  = isset($config['user']['table']) ? $config['user']['table'] : null;
            $this->_fields = isset($config['user']['fields']) ? $config['user']['fields'] : null;
        }


        public function get_page_list($opts, $cache = 0)
        {
            $dbh     = isset($opts['dbh']) ? $opts['dbh'] : null;
            $terms   = isset($opts['terms']) ? $opts['terms'] : null;          
            $status  = isset($opts['status']) ? $opts['status'] : null;
            $orderby = isset($opts['orderby']) ? $opts['orderby'] : null;
            $curr_page = (isset($opts['curr_page']) && $opts['curr_page'] > 0)
                ? $opts['curr_page'] : 1;
            $page_record = (isset($opts['page_record']) && $opts['page_record'] > 0)
                ? $opts['page_record'] : $this->page_record;

            $offset = ($curr_page - 1) * $page_record;

            $table = $this->_table;
            $cond  = 1;
            if($cdate){$cdate = self::$DBM->add_sql_slashes($cdate);$cond .= " and cdate>'".$cdate."'";}
               
               
            if ($choice == 'poster') {
                if ($terms) {
                    $terms = self::$DBM->add_sql_slashes($terms);
                    $cond .= " and poster like '$terms%' ";
                }
            }
            else if($choice =='id'){
            	if(is_numeric($terms))
               $cond .= " and id = $terms";
            }
            else  {
            	    if($terms){$terms = self::$DBM->add_sql_slashes($terms);$cond .= " and company = '$terms' ";}
                
            }

            if ($regional) {
                $regional = self::$DBM->add_sql_slashes($regional);
                $cond .= " and regional like '$regional%' ";
            }

            if ( is_numeric($status) )
                $cond .= " and status = $status ";

            $sql = " SELECT * FROM $table WHERE $cond ";
            $sql_count = " SELECT count(*) as total FROM $table WHERE $cond ";

            if ( $orderby == 'post_time' )
                $sql .= " ORDER BY post_time desc ";
            else
                $sql .= " ORDER BY id desc ";

            $sql .= " LIMIT $offset, $page_record ";
            //echo $sql_count;
            //echo $sql;
            //exit;

            $conn = self::$DBM->get_connect($dbh);

            return self::$DBM->get_page_list($conn, $sql, $sql_count, $opts, $cache);
        }

        public function get_profile($opts, $cache = 0)
        {
            $dbh = isset($opts['dbh']) ? $opts['dbh'] : null;
            $id  = isset($opts['id']) ? $opts['id'] : null;
            $poster = isset($opts['poster']) ? $opts['poster'] : null;
            $company = isset($opts['company']) ? $opts['company'] : null;
            $status = isset($opts['status']) ? $opts['status'] : null;
            $fields = isset($opts['fields']) ? $opts['fields'] : "*";

            if ($id <= 0 && ! $poster &&! $company)
                return array();

            $table = $this->_table;
            $cond  = 1;

            if (is_numeric($id) && $id > 0)
                $cond .= " and id = $id ";

            if ($poster) {
                $poster = self::$DBM->add_sql_slashes($poster);
                $cond .= " and poster = '$poster' ";
            }

            if ($company) {
                $poster = self::$DBM->add_sql_slashes($company);
                $cond .= " and company = '$company' ";
            }
            
            if ( is_numeric($status) )
                $cond .= " and status = $status ";

            $sql = " SELECT $fields FROM $table WHERE $cond limit 1 ";
           

            $conn = self::$DBM->get_connect($dbh);

            return self::$DBM->get_row($conn, $sql, $cache);
        }

        public function create($opts)
        {
            $unpost = isset($opts['unpost']) ? $opts['unpost'] : null;
            $inputs = isset($opts['inputs']) ? $opts['inputs'] : null;
            $fields = isset($opts['fields']) ? $opts['fields'] : $this->_fields;

            $fields_added = isset($opts['fields_added']) ? $opts['fields_added'] : null;
            if ( is_array($fields_added) )
                $fields = array_merge($fields, $fields_added);

            $table  = $this->_table;

            if ( count($inputs) > 0 && count($fields) > 0 ) {
                $p_fields = self::$DBM->get_execute_fields($inputs, $fields);
                $sql = " INSERT IGNORE INTO $table SET " . join(',', $p_fields);
                if(!$unpost)  $sql .= ", edit_date = now(), post_date = now() ";
          //      echo $sql;
         //     exit;

                $conn = self::$DBM->get_connect();
                return self::$DBM->execute($conn, $sql);
            }
        }

        public function change($opts)
        {
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

                if (! $unpost)
                    $sql .= ", post_date = now() ";
                $sql .= " WHERE 1 ";
                
                if ( is_numeric($id) && $id > 0 || $poster) {
                    if (is_numeric($id) && $id > 0)
                        $sql.= " and id = $id ";

                    if ($poster) {
                        $poster = self::$DBM->add_sql_slashes($poster);
                        $sql .= " and poster = '$poster' ";
                    }
                 //  echo $sql;
                  //  exit;

                    $conn = self::$DBM->get_connect();
                    return self::$DBM->execute($conn, $sql);
                }
            }
        }

        public function delete($opts)
        {
            $id = isset($opts['id']) ? $opts['id'] : null;

            $table = $this->_table;

            if (is_numeric($id) && $id > 0) {
                $sql = " DELETE FROM $table WHERE id = $id ";
                $sql_log = " SELECT * FROM $table WHERE id = $id ";
                //echo $sql;
                //exit;

                $conn = self::$DBM->get_connect();
                return self::$DBM->Execute($conn, $sql, $sql_log);
            }
        }
  
        
        public function get_list($opts, $cache = 0)
        {
            $dbh      = isset($opts['dbh']) ? $opts['dbh'] : null;
            $fields  = isset($opts['fields']) ? $opts['fields'] : "*";
            $id  = isset($opts['id']) ? $opts['id'] : null;
            $cdate  = isset($opts['cdate']) ? $opts['cdate'] : null;
            $orderby  = isset($opts['orderby']) ? $opts['orderby'] : null;
            $limit    = isset($opts['limit']) ? $opts['limit'] : null;
            $maxid=  isset($opts['maxid']) ? $opts['maxid'] : null;
            $table = $this->_table;
            
            
            if($maxid)
            {
            	
            	$cond="id>$maxid";
            	
               $sql = " SELECT $fields FROM $table WHERE $cond ";	
            	
            	
            }
            else
            {
            $cond  = "1";
            
            if($id)
               $cond.=" and id=$id";
            if($cdate)
               $cond .= " and cdate = '$cdate'";
            if ($orderby == 'post_time')
                $cond .= " order by post_time desc ";
            else
                $cond .= " order by id desc ";

            if ($limit > 0 &&  is_numeric($limit))
                $cond .= " limit $limit ";

            $sql = " SELECT $fields FROM $table WHERE $cond ";
            
          }
            

            $conn = self::$DBM->get_connect($dbh);

            return self::$DBM->get_list($conn, $sql, $cache);
        }
        
        public function get_total($opts, $cache = 0)
        {
            $dbh      = isset($opts['dbh']) ? $opts['dbh'] : null;
            $cdate      = isset($opts['cdate']) ? $opts['cdate'] : null;

            $table = $this->_table;
            $cond  = 1;

            if ($cdate){$cdate = self::$DBM->add_sql_slashes($cdate);$cond .= " and cdate = '$cdate' ";}
                

            $sql = " SELECT count(*) as total FROM $table WHERE $cond and status=1";
            //echo $sql;
            //exit;

            $conn = self::$DBM->get_connect($dbh);

            return self::$DBM->get_row($conn, $sql, $cache);
        } 

      
        
        public function get_maxid($opts, $cache = 0)  //获取未更新的最大的id
        {
        	
        $dbh   = isset($opts['dbh']) ? $opts['dbh'] : null;
        $table = $this->_table;
        $cond  = "1";
        $sql = " SELECT max(id) as maxid FROM $table WHERE $cond ";
        
   
        $conn = self::$DBM->get_connect($dbh);

         return self::$DBM->get_list($conn, $sql, $cache);	
        
        }
        
    }

?>