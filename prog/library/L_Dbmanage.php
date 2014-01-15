<?php

    class L_Dbmanage extends Library
    {
        public function __construct( $setup, $opts = null )
        {
            parent::__construct($setup);
        }


        public function set_pdodb($pdodb)
        {
            $this->_pdodb = $pdodb;
        }

        public function set_memcached($memcached)
        {
            $this->_memcached = $memcached;
        }

        public function set_log4php($log4php)
        {
            $this->_log4php = $log4php;
        }

        public function get_connect( $dbh = null, $sql = null )
        {
            $conn = "DB_CONNECT_HANDLE_$dbh";

            if ( isset($this->$conn) )
                return $this->$conn;

            $this->$conn = $this->_pdodb->get_connect($dbh);

            return $this->$conn;
        }

        public function get_row($conn, $sql, $cache)
        {
            if ($cache > 0 && $this->_memcached) {
                list($cache_id, $cache_obj) = $this->_memcached->get_cache($sql);

                if ($cache_obj)
                
               
                    return $cache_obj;
            }

            $rs = $conn->query($sql);

            if ($conn->errorCode() != '00000'){
                $error = $conn->errorInfo();
                error_log($error[2]. ' Error: ' . $sql, 0);
                return;
            }

            $rs->setFetchMode(PDO::FETCH_ASSOC);
            $res = $rs->fetch();
            if ($cache > 0 && $this->_memcached)
                $this->_memcached->set_cache($cache_id, $res, $cache);

            return $res;
        }

        public function get_list($conn, $sql, $cache)
        {
            if ($cache > 0 && $this->_memcached) {
            	
            	 
                list($cache_id, $cache_obj) = $this->_memcached->get_cache($sql);

                if ($cache_obj)
                  //print_r($cache_obj);exit;
                    return $cache_obj;
            }

            $rs = $conn->query($sql);

            if ($conn->errorCode() != '00000'){
                $error = $conn->errorInfo();
                error_log($error[2]. ' Error: ' . $sql, 0);
                return;
            }

            $rs->setFetchMode(PDO::FETCH_ASSOC);
            $res = $rs->fetchAll();

            if ($cache > 0 && $this->_memcached)
                $this->_memcached->set_cache($cache_id, $res, $cache);

            return $res;
        }

        public function execute($conn, $sql, $sql_log = null)
        {
            if ($sql_log)
                $list = $this->get_list($conn, $sql_log, 0);

            $rv = $conn->exec($sql);

            if ($conn->errorCode() != '00000'){
                $error = $conn->errorInfo();
                error_log($error[2]. ' Error: ' . $sql, 0);
                return false;
            }

            if ( $rv && preg_match('/^(\s*)insert/i', $sql) )
                return $conn->lastInsertId();

            if ($rv) {
                $post_ip = $this->setup->get_request_ip();

                $sql .= ' ' . $post_ip;

                //$this->_log4php->debug($sql);
            }
            return true;
        }

        public function get_execute_fields($inputs, $fields)
        {
            $p_fields = array();

            foreach ($fields as $k) {
                $v = isset( $inputs[$k] ) ? $inputs[$k] : '';
                $v = $this->add_sql_slashes($v);
                $p_fields[] = "`$k` = '$v'";
            }

            return $p_fields;
        }

        // 取分页数据
        public function get_page_list($conn, $sql, $sql_count, $res, $cache)
        {
            $list = $this->get_list($conn, $sql, $cache);
            $row  = $this->get_row($conn, $sql_count, $cache);

            $this->_fill_pager($res, $row['total'], $list);

            return $res;
        }

        private function _fill_pager(&$res, $rec_total, $list) 
        {
            $curr_page  = isset($res['curr_page']) ? $res['curr_page'] : null;
            $page_rec   = isset($res['page_record']) ? $res['page_record'] : null;
            $page_width = isset($res['page_width']) ? $res['page_width'] : null;
            $url_prefix = isset($res['url_prefix']) ? $res['url_prefix'] : null;
            $url_suffix = isset($res['url_suffix']) ? $res['url_suffix'] : null;
            $prefix     = isset($res['prefix']) ? $res['prefix'] : null;

         

            $curr_page > 0
                or $curr_page = 1;

            $page_rec > 0
                or $page_rec = 20;

            $page_width > 0
                or $page_width = 10;

            $prefix
                or $prefix = 'pw_';

            $res[$prefix.'curr_page'] = $curr_page;
            $res[$prefix.'rec_total'] = $rec_total;

            is_array($list)
                or $list = array();

            $res[$prefix.'rec_list'] = $list;

            $page_cnt = ceil($rec_total/$page_rec);
            $res[$prefix.'page_total'] = $page_cnt;

            $page_start = ceil($curr_page/$page_width - 1) * $page_width + 1;
            $res[$prefix.'page_start'] = $page_start;

            $page_end = $page_start + $page_width - 1;
            if ($page_end > $page_cnt)
                $page_end = $page_cnt;
            $res[$prefix.'page_end'] = $page_end;

            $prev_win = $page_start - 1;
            $res[$prefix.'prev_win'] = $prev_win;

            $next_win = $page_start + $page_width;
            if ($next_win > $page_cnt)
                $next_win = 0;
            $res[$prefix.'next_win'] = $next_win;

            $first = 1;   
            if ($page_cnt < $page_width || $page_start == 1)
                $first = 0;

            $last  = $page_cnt;
            if (($page_start + $page_width) > $page_cnt)
                $last  = 0;

            $res[$prefix.'prev'] = $curr_page-1;
            $res[$prefix.'next'] = $curr_page+1 > $page_cnt ? 0 : $curr_page+1;

            $res[$prefix.'rec_first']  = $first;
            $res[$prefix.'rec_last']   = $last;
            $res[$prefix.'url_prefix'] = $url_prefix;
            $res[$prefix.'url_suffix'] = $url_suffix;
           //$res[$prefix.'page_loop']  = $this->_make_page_loop2($page_start, $page_end, $curr_page);
            $res[$prefix.'page_loop']  = $this->_make_page_loop($page_width,$curr_page, $page_cnt);
            $res[$prefix.'escape_url_prefix'] = rawurlencode($url_prefix);
        
        
        }

        private function _make_page_loop($page_width, $curr, $lastpage) 
        {
            $res = array();
            $pb = max($curr - floor($page_width / 2), 1);
			      $pe = min($pb + $page_width, $lastpage+1);
			      do
			      {
				      $param['is_curr']  = ($pb == $curr);
              $param['page_idx'] = $pb;
              $res[] = $param;               
			      }while (++$pb < $pe);
            return $res;
        }
        
        private function _make_page_loop2($begin, $end, $curr) 
        {
            $res = array();

            for ($i=0; $begin <= $end; $begin++, $i++) {
                $param['is_curr']  = ($begin == $curr);
                $param['page_idx'] = $begin;
                $res[$i] = $param;
            }

            return $res;
        }
        
        public function add_sql_slashes($string)
        {
            return mysql_escape_string($string);
        }

    }

?>