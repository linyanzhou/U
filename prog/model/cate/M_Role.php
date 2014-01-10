<?php

    class M_Role extends Model
    {
        public function __construct($setup)
        {
            parent::__construct($setup);

            $config = $this->get_extend_datebase_config(dirname(__FILE__));

            $this->_table  = isset($config['role']['table']) ? $config['role']['table'] : null;
            $this->_fields = isset($config['role']['fields']) ? $config['role']['fields'] : null;
        }


        public function get_page_list($opts, $cache = 0)
        {
            $dbh     = isset($opts['dbh']) ? $opts['dbh'] : null;
            $len     = isset($opts['len']) ? $opts['len'] : null;
            $terms   = isset($opts['terms']) ? $opts['terms'] : null;
            $orderby = isset($opts['orderby']) ? $opts['orderby'] : null;

            $curr_page = (isset($opts['curr_page']) && $opts['curr_page'] > 0)
                ? $opts['curr_page'] : 1;
            $page_record = (isset($opts['page_record']) && $opts['page_record'] > 0)
                ? $opts['page_record'] : $this->page_record;

            $offset = ($curr_page - 1) * $page_record;

            $table = $this->_table;
            $cond  = 1;

            if ( is_numeric($len) ) {
                $cond .= " and length(cat_id) = $len ";
            }

            if ($terms) {
                $terms = self::$DBM->add_sql_slashes($terms);
                $cond .= " and ( category like '%$terms%' or cat_id like '$terms%') ";
            }

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
            $dir  = isset($opts['dir']) ? $opts['dir'] : null;
            $cat_id = isset($opts['cat_id']) ? $opts['cat_id'] : null;
            if ($id <= 0 && ! $cat_id && ! $dir)
            return array();

               

            $table = $this->_table;
            $cond  = 1;

            if ($id > 0)
                $cond .= " and id = $id ";

            if ($cat_id) {
                $cat_id = self::$DBM->add_sql_slashes($cat_id);
                $cond .= " and cat_id = '$cat_id' ";
            }
            if ($dir) {
                $dir = self::$DBM->add_sql_slashes($dir);
                $cond .= " and dir = '$dir' ";
            }

            $sql = " SELECT * FROM $table WHERE $cond limit 1 ";
            
            $conn = self::$DBM->get_connect($dbh);

            return self::$DBM->get_row($conn, $sql, $cache);
        }

        public function create($opts)
        {
            $inputs = isset($opts['inputs']) ? $opts['inputs'] : null;
            $fields = isset($opts['fields']) ? $opts['fields'] : $this->_fields;

            $fields_added = isset($opts['fields_added']) ? $opts['fields_added'] : null;
            if ( is_array($fields_added) )
                $fields = array_merge($fields, $fields_added);

            $table  = $this->_table;

            if ( count($inputs) > 0 && count($fields) > 0 ) {
                $p_fields = self::$DBM->get_execute_fields($inputs, $fields);
                $sql = " INSERT INTO $table SET " . join(',', $p_fields);
              

                $conn = self::$DBM->get_connect();
                return self::$DBM->execute($conn, $sql);
            }
        }

          public function change($opts)
        {
            $unpost = isset($opts['unpost']) ? $opts['unpost'] : null;
            $id     = isset($opts['id']) ? $opts['id'] : null;
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
                if ( $id > 0 ) {
                    if ($id > 0)
                        $sql.= " and id = $id ";
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

            if ($id > 0) {
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
            $dbh     = isset($opts['dbh']) ? $opts['dbh'] : null;
            $cat_id = isset($opts['cat_id']) ? $opts['cat_id'] : null;
            $category = isset($opts['category']) ? $opts['category'] : null;
            $len     = isset($opts['len']) ? $opts['len'] : null;
            $len_max = isset($opts['len_max']) ? $opts['len_max'] : null;
            $leaf    = isset($opts['leaf']) ? $opts['leaf'] : null;
            $status  = isset($opts['status']) ? $opts['status'] : null;
            $orderby = isset($opts['orderby']) ? $opts['orderby'] : null;
            $limit   = isset($opts['limit']) ? $opts['limit'] : null;
            $fields = isset($opts['fields']) ? $opts['fields'] : '*';

            $table = $this->_table;
            $cond  = 1;
 
            if ($cat_id) {
                $cat_id = self::$DBM->add_sql_slashes($cat_id);
                $cond .= " and cat_id like '$cat_id%' ";
            }
            
            if ($category) {
                $cat_id = self::$DBM->add_sql_slashes($cat_id);
                $cond .= " and category like '$category%' ";
            }

            if ($len > 0)
                $cond .= " and length(cat_id) = $len ";

            if ($len_max > 0)
                $cond .= " and length(cat_id) <= $len_max ";

            if ( is_numeric($leaf) )
                $cond .= " and leaf = $leaf ";

            if ( is_numeric($status) )
                $cond .= " and status = $status ";

            if ($orderby == 'cat_id')
                $cond .= " order by cat_id, id desc ";
            else
                $cond .= " order by id desc ";

            if ($limit > 0)
                $cond .= " limit $limit ";

            $sql = " SELECT $fields FROM $table WHERE $cond ";
          //echo $sql;
          //exit;

            $conn = self::$DBM->get_connect($dbh);
 
            return self::$DBM->get_list($conn, $sql, $cache);
        }
    }

?>