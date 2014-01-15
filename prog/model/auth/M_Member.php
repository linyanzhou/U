<?php

class M_Member extends Model
{
	public function __construct($setup)
	{
		parent::__construct($setup);

		$config = $this->get_datebase_config('member');
		$config_m2g = $this->get_datebase_config('member_to_group');
		 
		$this->_table  = isset($config['table']) ? $config['table'] : null;
		$this->_fields = isset($config['fields']) ? $config['fields'] : null;
		$this->_select_position = isset($config['select_position']) ? $config['select_position'] : null;

		$this->_table_m2g = isset($config_m2g['table']) ? $config_m2g['table'] : null;
	 
	}


	public function get_page_list($opts, $cache = 0)
	{
		$dbh      = isset($opts['dbh']) ? $opts['dbh'] : null;
		$terms    = isset($opts['terms']) ? $opts['terms'] : null;
		$group_id = isset($opts['group_id']) ? $opts['group_id'] : null;
		$choice   = isset($opts['choice']) ? $opts['choice'] : null;
		$orderby  = isset($opts['orderby']) ? $opts['orderby'] : null;

		$curr_page = (isset($opts['curr_page']) && $opts['curr_page'] > 0)
		? $opts['curr_page'] : 1;
		$page_record = (isset($opts['page_record']) && $opts['page_record'] > 0)
		? $opts['page_record'] : $this->page_record;

		$offset = ($curr_page - 1) * $page_record;

		$table = " $this->_table as m ";
		$cond  = 1;

		if (is_numeric($group_id) && ($group_id) > 0) {
			$table .= " left join $this->_table_m2g as m2g on (m.id = m2g.member_id) ";
			$cond .= " and m2g.group_id = $group_id ";
		}

		if ($terms) {
			$terms = self::$DBM->add_sql_slashes($terms);

			if ($choice == 'email'){
				$choice = self::$DBM->add_sql_slashes($choice);
			$cond .= " and m.email like '$terms%' ";
		}else{
			$choice = self::$DBM->add_sql_slashes($choice);
			$cond .= " and m.login like '$terms%' ";
		}
}
		$sql = " SELECT m.* FROM $table WHERE $cond ";
		$sql_count = " SELECT count(*) as total FROM $table WHERE $cond ";

		if ( $orderby == 'post_time' )
		$sql .= " ORDER BY m.post_time desc ";
		else
		$sql .= " ORDER BY m.id desc ";

		$sql .= " LIMIT $offset, $page_record ";
		//echo $sql_count;
		//echo $sql;
		//exit;

		$conn = self::$DBM->get_connect($dbh);

		return self::$DBM->get_page_list($conn, $sql, $sql_count, $opts, $cache);
	}

	public function get_profile($opts, $cache = 0)
	{
		$dbh    = isset($opts['dbh']) ? $opts['dbh'] : null;
		$id     = isset($opts['id']) ? $opts['id'] : null;
		$login  = isset($opts['login']) ? $opts['login'] : null;
		$passwd = isset($opts['passwd']) ? $opts['passwd'] : null;
		$email  = isset($opts['email']) ? $opts['email'] : null;
		$status = isset($opts['status']) ? $opts['status'] : null;

		if ($id <= 0 && ! $login && ! $email)
		return array();

		$table = $this->_table;
		$cond  = 1;

		if (is_numeric($id) && ($id) > 0)
		$cond .= " and id = $id ";

		if ($login) {
			$login = self::$DBM->add_sql_slashes($login);
			$cond .= " and login = '$login' ";
		}

		if ($passwd) {
			$passwd = self::$DBM->add_sql_slashes($passwd);
			$cond .= " and passwd = '$passwd' ";
		}

		if ($email) {
			$email = self::$DBM->add_sql_slashes($email);
			$cond .= " and email = '$email' ";
		}

		if ( is_numeric($status) )
		$cond .= " and status = $status ";

		$sql = " SELECT * FROM $table WHERE $cond limit 1 ";
		//error_log('Error: ' . $sql, 0);
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
			$sql = " INSERT INTO $table SET " . join(',', $p_fields) . ", create_time = now() ";
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
			$sql .= ", create_time = now() ";
			$sql .= " WHERE 1 ";

			if ( is_numeric($id) && ($id) > 0 || $login ) {
				if (is_numeric($id) && ($id) > 0)
				$sql.= " and id = $id ";

				if ($login) {
					$login = self::$DBM->add_sql_slashes($login);
					$sql.= " and login = '$login' ";
				}
				//                    echo $sql;
				//                    exit;

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

 

	public function get_member_group($opts, $cache = 0)
	{
		$dbh   = isset($opts['dbh']) ? $opts['dbh'] : null;
		$login = isset($opts['login']) ? $opts['login'] : null;
		$member_id = isset($opts['member_id']) ? $opts['member_id'] : null;
		if (!$login && !$member_id)
		return array();

		$table = " $this->_table as m ";
		$cond  = " m.id = m2g.member_id";

		$table .= " ,$this->_table_m2g as m2g ";

		if ($login) {
			$login = self::$DBM->add_sql_slashes($login);
			$cond .= " and m.login = '$login' ";
		}

		$sql = " SELECT member_id, GROUP_CONCAT(group_id) AS groups FROM $table WHERE $cond limit 1 ";
		//echo $sql;
		//exit;

		$conn = self::$DBM->get_connect($dbh);

		return self::$DBM->get_row($conn, $sql, $cache);
	}

	public function get_count($opts, $cache = 0)
	{
		$dbh      = isset($opts['dbh']) ? $opts['dbh'] : null;

		$table = " $this->_table as m ";
		$cond  = 1;

		$sql_count = " SELECT count(m.id) as total FROM $table WHERE $cond ";
		//echo $sql_count;
		//exit;

		$conn = self::$DBM->get_connect($dbh);
		return self::$DBM->get_row($conn,$sql_count, $cache);
	}
	
}

?>