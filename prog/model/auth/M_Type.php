<?php

    class M_Type extends Model
    {
        public function __construct($setup)
        {
            parent::__construct($setup);

            $config = $this->get_datebase_config('type');

            $this->_table  = isset($config['table']) ? $config['table'] : null;
            $this->_fields = isset($config['fields']) ? $config['fields'] : null;
        }


        public function get_page_list($opts, $cache = 0)
        {
            $dbh     = isset($opts['dbh']) ? $opts['dbh'] : null;
            $del     = isset($opts['del']) ? $opts['del'] : null;
            $terms   = isset($opts['terms']) ? $opts['terms'] : null;
            $orderby = isset($opts['orderby']) ? $opts['orderby'] : null;

            $curr_page = (isset($opts['curr_page']) && $opts['curr_page'] > 0)
                ? $opts['curr_page'] : 1;
            $page_record = (isset($opts['page_record']) && $opts['page_record'] > 0)
                ? $opts['page_record'] : $this->page_record;

            $offset = ($curr_page - 1) * $page_record;

            $table = $this->_table;
            $cond  = 1;

            if ( is_numeric($del) ) 
                $cond .= " and del = $del ";

            if ($terms) {
                $terms = self::$DBM->add_sql_slashes($terms);
                $cond .= " and name like '%$terms%' ";
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

            if ($id <= 0)
                return array();

            $table = $this->_table;
            $cond  = 1;

            if (is_numeric($id) && ($id) > 0)
                $cond .= " and id = $id ";

            $sql = " SELECT * FROM $table WHERE $cond limit 1 ";
            //echo $sql;
            //exit;

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
                $sql = " INSERT INTO $table SET " . join(',', $p_fields) . ", ctime = now(), post_time = now() ";
                //echo $sql;
                //exit;

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

                if (! $unpost)
                    $sql .= ", post_time = now() ";
                $sql .= " WHERE 1 ";

                if ( is_numeric($id) && ($id) > 0 ) {
                    if (is_numeric($id) && ($id) > 0)
                        $sql.= " and id = $id ";
                    //echo $sql;
                    //exit;

                    $conn = self::$DBM->get_connect();
                    return self::$DBM->execute($conn, $sql);
                }
            }
        }

        public function delete($opts)
        {
            return TRUE;

            $id = isset($opts['id']) ? $opts['id'] : null;

            $table = $this->_table;

            if (is_numeric($id) && ($id) > 0) {
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
            $del     = isset($opts['del']) ? $opts['del'] : null;
            $status  = isset($opts['status']) ? $opts['status'] : null;
            $fields  = isset($opts['fields']) ? $opts['fields'] : "*";
            $orderby = isset($opts['orderby']) ? $opts['orderby'] : null;
            $limit   = isset($opts['limit']) ? $opts['limit'] : null;

            $table = $this->_table;
            $cond  = 1;

            if ( is_numeric($del) )
                $cond .= " and del = $del ";

            if ( is_numeric($status) )
                $cond .= " and status = $status ";

            if ($orderby == 'rank')
                $cond .= " order by rank desc, id desc ";
            else
                $cond .= " order by id desc ";

            if (is_numeric($limit) && ($limit) > 0)
                $cond .= " limit $limit ";

            $sql = " SELECT $fields FROM $table WHERE $cond ";
            //echo $sql;
            //exit;

            $conn = self::$DBM->get_connect($dbh);

            return self::$DBM->get_list($conn, $sql, $cache);
        }
    }

?>