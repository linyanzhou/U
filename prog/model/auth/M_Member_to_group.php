<?php

    class M_Member_to_group extends Model
    {
        public function __construct($setup)
        {
            parent::__construct($setup);

            $config = $this->get_datebase_config('member_to_group');
            $config_group = $this->get_datebase_config('group');

            $this->_table  = isset($config['table']) ? $config['table'] : null;
            $this->_fields = isset($config['fields']) ? $config['fields'] : null;

            $this->_table_group = isset($config_group['table']) ? $config_group['table'] : null;
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
                $sql = " INSERT INTO $table SET " . join(',', $p_fields) . ", create_time = now() ";
//                echo $sql;
//                exit;

                $conn = self::$DBM->get_connect();
                return self::$DBM->execute($conn, $sql);
            }
        }

        public function delete($opts)
        {
            $member_id = isset($opts['member_id']) ? $opts['member_id'] : null;
            $is_editor = isset($opts['is_editor']) ? $opts['is_editor'] : null;

            $table = $this->_table;

            if (is_numeric($member_id) && ($member_id) > 0) {
                $sql = " DELETE FROM $table WHERE member_id = $member_id ";
                $sql_log = " SELECT * FROM $table WHERE member_id = $member_id ";
                //echo $sql;
                //exit;
                if (is_numeric($is_editor) && ($is_editor) > 0)
                $sql .= " and group_id > 9";
                
                $conn = self::$DBM->get_connect();
                return self::$DBM->Execute($conn, $sql, $sql_log);
            }

            return TRUE;
        }

         public function get_list($opts, $cache = 0)
        {
            $dbh       = isset($opts['dbh']) ? $opts['dbh'] : null;
            $member_id = isset($opts['member_id']) ? $opts['member_id'] : null;
            $limit     = isset($opts['limit']) ? $opts['limit'] : null;
            $is_editor = isset($opts['is_editor']) ? $opts['is_editor'] : null;

            if ($member_id <= 0)
                return array();

            $table = " $this->_table_group as g ";
            $cond  = 1;

            $table .= " left join $this->_table as m2g on ( g.id = m2g.group_id ";

            if ($member_id > 0)
                $table .= " and member_id = $member_id ";

            $table .= " ) ";

            if ($is_editor > 0)
                $cond .= " and g.id > 9";
            if ($limit > 0)
                $cond .= " limit $limit ";
                
            $sql = " SELECT g.*, m2g.id as m2g_id,m2g.group_id as m2g_gid  FROM $table WHERE $cond ";
            
            //echo $sql;
            //exit;

            $conn = self::$DBM->get_connect($dbh);

            return self::$DBM->get_list($conn, $sql, $cache);
        }

    }

?>