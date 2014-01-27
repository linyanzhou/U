<?php

    class L_Session extends Library
    {
        private static $_sess_conn = null;

        public function __construct( $setup, $opts = null )
        {
            parent::__construct($setup);

            $this->_opts = $this->extend($opts, 'session');

            $this->_module = $this->_opts['module'];
            $this->_domain = $this->_opts['domain'];
            $this->_path   = $this->_opts['path'];
            $this->_expire = $this->_opts['expire'];

            $this->_expire > 0
                or $this->_expire = 3600;

            if ( in_array($this->_module, array('mem', 'db')) )
                $this->init();
        }


        public function init()
        {
            //��ʹ�� GET/POST ������ʽ
            ini_set('session.use_trans_sid', 0);

            //�������������������ʱ��
            ini_set('session.gc_maxlifetime', $this->_expire);

            //ʹ�� COOKIE ���� SESSION ID �ķ�ʽ
            ini_set('session.use_cookies', 1);
            ini_set('session.cookie_path', $this->_path);
            ini_set('session.cookie_domain', $this->_domain);

            //�� session.save_handler ����Ϊ user��������Ĭ�ϵ� files
            session_module_name('user');

            //���� SESSION �����������Ӧ�ķ�������
            $this->_set_save_handler($this->_module);
        }

        private function _set_save_handler($module)
        {
            if ($module == 'db') {
                $this->_driver = $this->_opts['db']['driver'];
                $this->_db     = $this->_opts['db']['db'];
                $this->_host   = $this->_opts['db']['host'];
                $this->_names  = $this->_opts['db']['names'];
                $this->_uname  = $this->_opts['db']['uname'];
                $this->_pword  = $this->_opts['db']['pword'];
                $this->_table  = $this->_opts['db']['table'];

                ( $this->_driver && $this->_host && $this->_uname && $this->_table )
                    or exit("Session driver, host, username and table must be provide!");

                session_set_save_handler(
                    array(&$this, 'open_db'),
                    array(&$this, 'close_db'),
                    array(&$this, 'read_db'),
                    array(&$this, 'write_db'),
                    array(&$this, 'destroy_db'),
                    array(&$this, 'gc_db')
                );
            }
            else if ($module == 'mem') {
                session_set_save_handler(
                    array(&$this, 'open_mem'),
                    array(&$this, 'close_mem'),
                    array(&$this, 'read_mem'),
                    array(&$this, 'write_mem'),
                    array(&$this, 'destroy_mem'),
                    array(&$this, 'gc_mem')
                );
            }
        }

        //Datebase_SaveHandler
        public function open_db($save_path, $session_name)
        {
            if (! self::$_sess_conn)
                self::$_sess_conn = mysql_connect($this->_host, $this->_uname, $this->_pword);

            return true;
        }

        public function close_db()
        {
            //mysql_close(self::$_sess_conn);
            //self::$_sess_conn = null;

            return true;
        }

        public function read_db($sesskey)
        {
            $expiry  = time();
            $sesskey = addslashes($sesskey);

            $sql = "SELECT data FROM $this->_table WHERE sesskey = '$sesskey' AND expiry >= $expiry";
            $res = mysql_query( $sql );
            $rv  = mysql_fetch_assoc( $res );

            return $rv['data'];
        }

        public function write_db($sesskey, $data)
        {
            $expiry  = time() + $this->_expire;
            $sesskey = addslashes($sesskey);
            $expiry  = addslashes($expiry);
            $data    = addslashes($data);

            $sql = "REPLACE INTO $this->_table set sesskey = '$sesskey', expiry = '$expiry', data = '$data'";
            $rv  = mysql_query( $sql );

            return true;
        }

        public function destroy_db($sesskey)
        {
            $sesskey = addslashes($sesskey);

            $sql = "DELETE FROM $this->_table WHERE sesskey= '$sesskey'";
            $rv  = mysql_query( $sql );

            return true;
        }

        public function gc_db($maxlifetime = null)
        {
            $expiry = time();

            $sql = "DELETE FROM $this->_table WHERE expiry < $expiry";
            $rv  = mysql_query( $sql );

            //���ھ����ԵĶԱ� sess ��ɾ�����������ײ�����Ƭ��
            //���������������жԸñ�����Ż�������
            $sql = "OPTIMIZE TABLE $this->_table";
            $rv  = mysql_query( $sql );

            return true;
        }


        //Memcache_SaveHandler to be completion
        public function open_mem($save_path, $session_name)
        {
            return true;
        }

        public function close_mem()
        {
            return true;
        }

        public function read_mem($sesskey)
        {
            return '';
        }

        public function write_mem($sesskey, $data)
        {
            return true;
        }

        public function destroy_mem($sesskey)
        {
            return true;
        }

        public function gc_mem($maxlifetime = null)
        {
            return true;
        }

    }

?>