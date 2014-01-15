<?php

    class M_Action extends Model
    {
        public function __construct($setup)
        {
            parent::__construct($setup);

            $config = $this->get_datebase_config('action');
            $config_member = $this->get_datebase_config('member');
            $config_group  = $this->get_datebase_config('group');
            $config_m2g    = $this->get_datebase_config('member_to_group');
            $config_a2g    = $this->get_datebase_config('action_to_group');

            $this->_table  = isset($config['table']) ? $config['table'] : null;
            $this->_fields = isset($config['fields']) ? $config['fields'] : null;

            $this->_table_member = isset($config_member['table']) ? $config_member['table'] : null;
            $this->_table_group  = isset($config_group['table']) ? $config_group['table'] : null;
            $this->_table_m2g    = isset($config_m2g['table']) ? $config_m2g['table'] : null;
            $this->_table_a2g    = isset($config_a2g['table']) ? $config_a2g['table'] : null;
        }


        public function get_page_list($opts, $cache = 0)
        {
            $dbh       = isset($opts['dbh']) ? $opts['dbh'] : null;
            $terms     = isset($opts['terms']) ? $opts['terms'] : null;
            $type_id   = isset($opts['type_id']) ? $opts['type_id'] : null;
            $namespace = isset($opts['namespace']) ? $opts['namespace'] : null;
            $orderby   = isset($opts['orderby']) ? $opts['orderby'] : null;

            $curr_page = (isset($opts['curr_page']) && $opts['curr_page'] > 0)
                ? $opts['curr_page'] : 1;
            $page_record = (isset($opts['page_record']) && $opts['page_record'] > 0)
                ? $opts['page_record'] : $this->page_record;

            $offset = ($curr_page - 1) * $page_record;

            $table = $this->_table;
            $cond  = 1;

            if ( is_numeric($type_id) && ($type_id) > 0 ) {
                $cond .= " and type_id = $type_id ";
            }

            if ($namespace) {
                $namespace = self::$DBM->add_sql_slashes($namespace);
                $cond .= " and namespace = '$namespace' ";
            }

            if ($terms) {
                $terms = self::$DBM->add_sql_slashes($terms);
                $cond .= " and (name like '%$terms%' or action_code like '%$terms%') ";
            }

            $sql = " SELECT * FROM $table WHERE $cond ";
            $sql_count = " SELECT count(*) as total FROM $table WHERE $cond ";

            if ( $orderby == 'action_code' )
                $sql .= " ORDER BY action_code, id desc ";
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
            $action_code = isset($opts['action_code']) ? $opts['action_code'] : null;
            $action_func = isset($opts['action_func']) ? $opts['action_func'] : null;

            if ( $id <= 0 && ! $action_code )
                return array();

            $table = $this->_table;
            $cond  = 1;

            if (is_numeric($id)&&($id) > 0)
                $cond .= " and id = $id ";

            if ($action_code) {
                $action_code = self::$DBM->add_sql_slashes($action_code);
                $cond .= " and action_code = '$action_code' ";
            }

            if ($action_func) {
                $action_func = self::$DBM->add_sql_slashes($action_func);
                $cond .= " and action_func = '$action_func' ";
            }

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
                $sql = " INSERT INTO $table SET " . join(',', $p_fields) . ", create_time = now()";
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
                    $sql .= ", create_time = now() ";
                $sql .= " WHERE 1 ";

                if (is_numeric($id) && ($id) > 0) {
                    if (is_numeric($id) > 0)
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

            if (is_numeric($id)&& ($id) > 0) {
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
            $type_id = isset($opts['type_id']) ? $opts['type_id'] : null;
            $status  = isset($opts['status']) ? $opts['status'] : null;
            $in_menu = isset($opts['in_menu']) ? $opts['in_menu'] : null;
            $groupby = isset($opts['groupby']) ? $opts['groupby'] : null;
            $orderby = isset($opts['orderby']) ? $opts['orderby'] : null;
            $limit   = isset($opts['limit']) ? $opts['limit'] : null;
            $access_type = isset($opts['access_type']) ? $opts['access_type'] : null;
            $_access_type= isset($opts['_access_type']) ? $opts['_access_type'] : null;
            $action_code = isset($opts['action_code']) ? $opts['action_code'] : null;
            $action_func = isset($opts['action_func']) ? $opts['action_func'] : null;
            $namespace   = isset($opts['namespace']) ? $opts['namespace'] : null;
            $fields   = isset($opts['fields']) ? $opts['fields'] : "*";
            $table = $this->_table;
            $cond  = 1;

            if ( is_numeric($type_id) && ($type_id) > 0)
                $cond .= " and type_id = $type_id ";

            if ( is_numeric($status) )
                $cond .= " and status = $status ";

            if ( is_numeric($in_menu) )
                $cond .= " and in_menu = $in_menu ";

            if ($access_type) {
                $access_type = self::$DBM->add_sql_slashes($access_type);
                $cond .= " and access_type = '$access_type' ";
            }

            if ($_access_type) {
                $_access_type = self::$DBM->add_sql_slashes($_access_type);
                $cond .= " and access_type <> '$_access_type' ";
            }

            if ($action_code) {
                $action_code = self::$DBM->add_sql_slashes($action_code);
                $cond .= " and action_code = '$action_code' ";
            }

            if ($action_func) {
                $action_func = self::$DBM->add_sql_slashes($action_func);
                $cond .= " and action_func = '$action_func' ";
            }

            if ($namespace) {
                $namespace = self::$DBM->add_sql_slashes($namespace);
                $cond .= " and namespace = '$namespace' ";
            }

            if ($groupby == 'action_id')
                $cond .= " group by id ";

            if ($orderby == 'rank')
                $cond .= " order by rank desc, id ";
            else
                $cond .= " order by id desc ";

            if ( is_numeric($limit) && ($limit) > 0)
                $cond .= " limit $limit ";

            $sql = " SELECT $fields FROM $table WHERE $cond ";
            //echo $sql;
            //exit;

            $conn = self::$DBM->get_connect($dbh);

            return self::$DBM->get_list($conn, $sql, $cache);
        }

        public function get_actions_of_grant($opts, $cache = 0)
        {
            $dbh     = isset($opts['dbh']) ? $opts['dbh'] : null;
            $login   = isset($opts['login']) ? $opts['login'] : null;
            $status  = isset($opts['status']) ? $opts['status'] : null;
            $in_menu = isset($opts['in_menu']) ? $opts['in_menu'] : null;
            $groupby = isset($opts['groupby']) ? $opts['groupby'] : null;
            $orderby = isset($opts['orderby']) ? $opts['orderby'] : null;
            $limit   = isset($opts['limit']) ? $opts['limit'] : null;
            $action_code = isset($opts['action_code']) ? $opts['action_code'] : null;
            $action_func = isset($opts['action_func']) ? $opts['action_func'] : null;
            $namespace   = isset($opts['namespace']) ? $opts['namespace'] : null;
            $fields   = isset($opts['fields']) ? $opts['fields'] : "a.*";

            if ( ! $login )
                return array();

            $table  = " $this->_table_member as m, $this->_table_m2g as m2g, ";
            $table .= " $this->_table_a2g as a2g, $this->_table as a ";
            $cond   = " m.id = m2g.member_id and m2g.group_id = a2g.group_id and a2g.action_id = a.id ";

            if ($login) {
                $login = self::$DBM->add_sql_slashes($login);
                $cond .= " and m.login = '$login' ";
            }

            if ( is_numeric($status) )
                $cond .= " and a.status = $status ";

            if ( is_numeric($in_menu) )
                $cond .= " and a.in_menu = $in_menu ";

            if ($action_code) {
                $action_code = self::$DBM->add_sql_slashes($action_code);
                $cond .= " and a.action_code = '$action_code' ";
            }

            if ($action_func) {
                $action_func = self::$DBM->add_sql_slashes($action_func);
                $cond .= " and a.action_func = '$action_func' ";
            }

            if ($namespace) {
                $namespace = self::$DBM->add_sql_slashes($namespace);
                $cond .= " and a.namespace = '$namespace' ";
            }

            if ($groupby == 'action_id')
                $cond .= " group by a.id ";

            if ($orderby == 'rank')
                $cond .= " order by a.rank desc, a.id ";
            else
                $cond .= " order by a.id desc ";

            if ($limit > 0)
                $cond .= " limit $limit ";

            $sql = " SELECT a.id,a.action_code,a.action_func,a.access_type,a.namespace,a.name,a.type_id,a.in_menu,a.blank,a.link,a.status,a.rank FROM $table WHERE $cond ";
           // echo $sql;
           // exit;

            $conn = self::$DBM->get_connect($dbh);

            return self::$DBM->get_list($conn, $sql, $cache);
        }

    }

?>