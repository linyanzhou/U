<?php

    class M_Admin extends Model
    {
        public function __construct( $setup, $opts = null )
        {
            parent::__construct($setup);

            $config = $this->get_datebase_config('admin');

            $this->_table  = isset($config['table']) ? $config['table'] : null;
            $this->_fields = isset($config['fields']) ? $config['fields'] : null;
        }


        public function get_profile($opts, $cache = 0)
        {
            $dbh    = isset($opts['dbh']) ? $opts['dbh'] : null;
            $id     = isset($opts['id']) ? $opts['id'] : null;
            $login  = isset($opts['login']) ? $opts['login'] : null;
            $passwd = isset($opts['passwd']) ? $opts['passwd'] : null;
            $status = isset($opts['status']) ? $opts['status'] : null;

            if ($id <= 0 && ! $login)
                return array();

            $table = $this->_table;
            $cond  = 1;

            if ( is_numeric($id) && ($id) > 0)
                $cond .= " and id = $id ";

            if ($login) {
                $login = self::$DBM->add_sql_slashes($login);
                $cond .= " and login = '$login' ";
            }

            if ($passwd) {
                $passwd = self::$DBM->add_sql_slashes($passwd);
                $cond .= " and passwd = '$passwd' ";
            }

            if ( is_numeric($status) )
                $cond .= " and status = $status ";

            $sql = " SELECT * FROM $table WHERE $cond limit 1 ";
            //echo $sql;
            //exit;

            $conn = self::$DBM->get_connect($dbh);

            return self::$DBM->get_row($conn, $sql, $cache);
        }

        public function change($opts)
        {
            $unpost = isset($opts['unpost']) ? $opts['unpost'] : null;
            $id     = isset($opts['id']) ? $opts['id'] : null;
            $login  = isset($opts['login']) ? $opts['login'] : null;
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

                if (is_numeric($id) && ($id) > 0 || $login ) {
                    if ( is_numeric($id) && ($id) > 0)
                        $sql.= " and id = $id ";
 
                    if ($login) {
                        $login = self::$DBM->add_sql_slashes($login);
                        $sql.= " and login = '$login' ";
                    }
                    //echo $sql;
                    //exit;

                    $conn = self::$DBM->get_connect();
                    return self::$DBM->execute($conn, $sql);
                }
            }
        }

    }

?>