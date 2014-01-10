<?php

    class L_Output extends Library
    {
        public function __construct( $setup, $opts = null )
        {
            parent::__construct($setup);

            $this->_set_smarty_handler();
        }


        private function _set_smarty_handler()
        {
            $class = "$this->libs_folder/smarty/Smarty.class.php";
            $file  = "$this->deploy_root/$class";

            is_file($file)
                or exit("Failed to load Smarty($class)!");
            require_once($file);

            $smarty = new Smarty(); 
            $smarty->template_dir = "$this->deploy_root/$this->tmpl_folder/$this->domain";
            $smarty->compile_dir  = "$this->deploy_root/$this->cache_folder/smarty/$this->domain";
           
            
            $lang = isset($_COOKIE['intl_LANG']) ? $_COOKIE['intl_LANG'] : "en" ;   
            $smarty->config_dir   = "$this->deploy_root/UI/conf/$lang";
            $smarty->cache_dir    = "$this->deploy_root/$this->cache_folder";  //templates_c文件夹
            $smarty->caching      = FALSE;
            $smarty->left_delimiter  = '<{';
            $smarty->right_delimiter = '}>';

            $this->_smarty  = $smarty;
             
        }


        public function set_welcome_info($wel)
        {
            $this->_welcome_info = $wel;
        }

        public function display( $tmpl, $res, $expires = null, $status = null )
        {
            $this->_set_header($expires, $status);

            if ( $this->_welcome_info )
                $this->_smarty->assign( $this->_welcome_info );
            
            $this->_smarty->assign($res);
            $this->_smarty->display($tmpl);
        }

        public function fetch( $tmpl, $res = array() )
        {
            $this->_smarty->assign($res);

            return $this->_smarty->fetch($tmpl);
        }

        public function show( $html, $expires = null, $status = null )
        {
            $this->_set_header($expires, $status);

            echo($html);
        }

        public function escape( $res = array() )
        {
            $array = array();

            foreach ($res as $k => $v) {
                $v = ( is_array($v) || is_object($v) )
                    ? $this->escape($v) : htmlspecialchars($v);

                $array[$k] = $v;
            }

            return $array;
        }

        private function _set_header( $expires, $status = null )
        {
            if ($status > 0)
                $this->_set_status_header($status);

            header("Content-Type: text/html; charset=$this->charset;");

            if ($expires > 0) {
                $expires = $this->_get_expires_time($expires);
                header("Expires: $expires GMT");
            }
        }

        private function _set_status_header($status = 200)
        {
            $stati = array(
                200  => 'OK',
                201  => 'Created',
                202  => 'Accepted',
                203  => 'Non-Authoritative Information',
                204  => 'No Content',
                205  => 'Reset Content',
                206  => 'Partial Content',

                300  => 'Multiple Choices',
                301  => 'Moved Permanently',
                302  => 'Found',
                304  => 'Not Modified',
                305  => 'Use Proxy',
                307  => 'Temporary Redirect',

                400  => 'Bad Request',
                401  => 'Unauthorized',
                403  => 'Forbidden',
                404  => 'Not Found',
                405  => 'Method Not Allowed',
                406  => 'Not Acceptable',
                407  => 'Proxy Authentication Required',
                408  => 'Request Timeout',
                409  => 'Conflict',
                410  => 'Gone',
                411  => 'Length Required',
                412  => 'Precondition Failed',
                413  => 'Request Entity Too Large',
                414  => 'Request-URI Too Long',
                415  => 'Unsupported Media Type',
                416  => 'Requested Range Not Satisfiable',
                417  => 'Expectation Failed',

                500  => 'Internal Server Error',
                501  => 'Not Implemented',
                502  => 'Bad Gateway',
                503  => 'Service Unavailable',
                504  => 'Gateway Timeout',
                505  => 'HTTP Version Not Supported'
            );

            if ( isset($stati[$status]) ) {
                $text = $stati[$status];
                $server_protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : FALSE;

                if ( substr(php_sapi_name(), 0, 3) == 'cgi' ) {
                    header("Status: {$status} {$text}", TRUE);
                }
                else if ($server_protocol == 'HTTP/1.1' || $server_protocol == 'HTTP/1.0') {
                    header($server_protocol . " {$status} {$text}", TRUE, $status);
                }
                else {
                    header("HTTP/1.1 {$status} {$text}", TRUE, $status);
                }
            }
        }

        private function _get_expires_time($expires)
        {
            $expires %= 24;
            $time = time();
            $time -= 8*3600;   // 缓存服务器与本地时间差8个小时 //
            $i = 0;
            while (1) {
                $time  += 3600;
                $hour   = date('H', $time);
                $mktime = mktime($hour, 0, 0, date('m', $time), date('d', $time), date('Y', $time));

                if ($expires < 2 || $hour%$expires == 0)
                    break;
            }

            return date('D, d M Y H:i:s', $mktime);
        }

    }

?>