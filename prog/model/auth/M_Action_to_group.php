<?php

    class M_Action_to_group extends Model
    {
        public function __construct($setup)
        {
            parent::__construct($setup);

            $config = $this->get_datebase_config('action_to_group');

            $this->_table  = isset($config['table']) ? $config['table'] : null;
            $this->_fields = isset($config['fields']) ? $config['fields'] : null;
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
                $sql = " INSERT INTO $table SET " . join(',', $p_fields) . ", ctime = now() ";
                //echo $sql;
                //exit;

                $conn = self::$DBM->get_connect();
                return self::$DBM->execute($conn, $sql);
            }
        }

        public function delete($opts)
        {
            $group_id = isset($opts['group_id']) ? $opts['group_id'] : null;

            $table = $this->_table;

            if ( is_numeric($group_id) && ($group_id) > 0) {
                $sql = " DELETE FROM $table WHERE group_id = $group_id ";
                $sql_log = " SELECT * FROM $table WHERE group_id = $group_id ";
                //echo $sql;
                //exit;

                $conn = self::$DBM->get_connect();
                return self::$DBM->Execute($conn, $sql, $sql_log);
            }

            return TRUE;
        }

        public function get_list($opts, $cache = 0)
        {
            $dbh      = isset($opts['dbh']) ? $opts['dbh'] : null;
            $group_id = isset($opts['group_id']) ? $opts['group_id'] : null;
            $limit    = isset($opts['limit']) ? $opts['limit'] : null;

            if ($group_id <= 0)
                return array();

            $table = $this->_table;
            $cond  = 1;

            if (is_numeric($group_id) && ($group_id) > 0)
                $cond .= " and group_id = $group_id ";

            if ( is_numeric($limit) && ($limit) > 0)
                $cond .= " limit $limit ";

            $sql = " SELECT * FROM $table WHERE $cond ";
            //echo $sql;
            //exit;

            $conn = self::$DBM->get_connect($dbh);

            return self::$DBM->get_list($conn, $sql, $cache);
        }
    }

?>