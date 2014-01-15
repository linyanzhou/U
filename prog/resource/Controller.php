<?php

    class Controller extends Base
    {
        public static $l_input    = null;
        public static $l_output   = null;
        public static $l_uri      = null;
        public static $l_session  = null;
        public static $l_string   = null;
        public static $l_validate = null;
        public static $l_blacklist = null;

        public static $l_encrypt  = null;
        public static $l_http     = null;
        public static $l_language = null;
        public static $l_log4php  = null;
        public static $l_pscws    = null;
        public static $l_upload   = null;
        public static $Global     = null;

        public function __construct($setup)
        {
            parent::__construct($setup);

            if ( isset($this->main_config['controller']) )
                $this->_config = $this->main_config['controller'];  //在下面的set_welcome_info用到
               
            if ( is_array($this->_config) ) {
                foreach ($this->_config as $k => $v) {
                    $this->$k = $v;
                }
            }
        }


        public function set_static_handler()
        {
            isset(self::$l_input)or self::$l_input = $this->setup->get_library_handler('input');

            isset(self::$l_output)or self::$l_output = $this->setup->get_library_handler('output');

            isset(self::$l_uri) or self::$l_uri = $this->setup->get_library_handler('uri');
                
            isset(self::$l_string)or self::$l_string = $this->setup->get_library_handler('string');
           
            isset(self::$l_upload)or self::$l_upload = $this->setup->get_library_handler('upload');

//            isset(self::$l_encrypt)
//                or self::$l_encrypt  = $this->setup->get_library_handler('encrypt');
//
//            isset(self::$l_http)
//                or self::$l_http = $this->setup->get_library_handler('http');
//
//            isset(self::$l_language)
//                or self::$l_language = $this->setup->get_library_handler('language');
//
//            isset(self::$l_pscws)
//                or self::$l_pscws = $this->setup->get_library_handler('pscws');
//
//            
      
        }
        

        public function set_welcome_info($wel)
        {
            $wel['f']  = $this->function;
            $wel['_a'] = $this->action;
            $wel['_d'] = $this->domain;

            if ( is_array($this->_config) ) {
                foreach ($this->_config as $k => $v) {
                    $wel['_' . $k] = $v;
                }
            }    //这里把config里的配置文件加上  
            
           // return $wel;  ?
             self::$l_output->set_welcome_info( $wel );
        }

        public function callback()
        {
            $func = $this->function;
            $func
                or $func = 'main';
            $func = 'do_' . $func;

            if ( method_exists($this, $func) ) {
                $this->$func();
            }
            else {
                $func = $this->domain . '::' . $this->action . '->' . $this->function . '()';
                exit("Function not exists($func)!");
            }
        }

        public function prompt_login( $res = array() )
        {
            $action = "?_d=$this->domain&_a=login";

            self::$l_uri->redirect($action, $res);
        }

        public function prompt_main( $res = array() )
        {
            $action = "?_d=$this->domain&_a=main";

            self::$l_uri->redirect($action, $res);
        }

        public function prompt_exception( $res = array() )
        {
            $exp  = $res['exp'];
            $tmpl = $res['tmpl'];

            if ($exp)
                $res["E_$exp"] = 1;

            $template = "exception-tmpl.html";
            if ($tmpl)
                $template = "$tmpl/$template";

            self::$l_output->display($template, $res);
            exit;
        }

        public function prompt_submit( $res = array() )
        {
            $exp  = $res['exp'];
            $tmpl = $res['tmpl'];

            if ($exp)
                $res["E_$exp"] = 1;

            $template = "submit-tmpl.html";
            if ($tmpl)
                $template = "$tmpl/$template";

            self::$l_output->display($template, $res);
            exit;
        }
        
        public function passwd_encrypt($passwd)
        {
            return md5($passwd);
        }

        public function get_upload_uniqid($res = array())
        {
            //return uniqid(); 
            $str = "";            
            foreach ($res as $key => $value) {
                 $str .= "&".$key."=".$value; 
            }
            $url = "$this->url_upload/?_a=upload&f=get_uniqid&namespace=".$this->namespace . $str;
            return file_get_contents($url);
        }

        public function get_upload_fields($uniqid, $pics, $inputs)
        {
            $data = $this->_get_upload_session($uniqid);
            $data = json_decode($data, TRUE);

            $fields = array();
            foreach ($pics as $i) {
                $delpic  = isset($inputs["delpic$i"]) ? $inputs["delpic$i"] : null;
                $sesskey = $uniqid . '_' . $i;
                $pic_name = $data[$sesskey];

                if (! $delpic) {
                    $fields[] = "pic_name$i";
                    $inputs["pic_name$i"] = $pic_name;
                    if ($pic_name)
                        $this->_move_uploaded_file($pic_name);
                }
            }

            return array($fields, $inputs);
        }

        private function _get_upload_session($uniqid)
        {
            $url = "$this->url_upload/?_a=upload&f=get_session&uniqid=$uniqid";
            return file_get_contents($url);
        }

        private function _move_uploaded_file($src)
        {
            $url = "$this->url_upload/?_a=upload&f=move_uploaded_file&src=" . urlencode($src);
            return file_get_contents($url);
        }

        //cookie
        public function set_cookie_login_user_id( $user_id, $nonce = 'intl' )
        {
            $expire = NULL;
            if($this->cookie_expire) 
               $expire = time() + $this->cookie_expire;
               
            setcookie($nonce . '_LOGIN_USER_ID', $user_id, $expire, $this->cookie_path, $this->cookie_domain);
        }

        public function get_cookie_login_user_id( $nonce = 'intl' )
        {            
            return isset($_COOKIE[$nonce . '_LOGIN_USER_ID']) ? $_COOKIE[$nonce . '_LOGIN_USER_ID'] : null;
        }
        
        //lang cookie 
        public function set_cookie_lang( $lang, $nonce = 'intl' )
        {
            $expire = NULL;
            if($this->cookie_expire) 
               $expire = time() + $this->cookie_expire;
               
            setcookie($nonce . '_LANG', $lang, $expire, $this->cookie_path, $this->cookie_domain);
        }

        public function get_cookie_lang( $nonce = 'intl' )
        {            
            return isset($_COOKIE[$nonce . '_LANG']) ? $_COOKIE[$nonce . '_LANG'] : null;
        }
        
        //session
        public function set_login_user_id( $user_id, $nonce = 'intl' )
        {
            if (! isset($_SESSION))
                session_start();

            $_SESSION[$nonce . '_LOGIN_USER_ID'] = $user_id;
        }

        public function set_login_password( $password, $nonce = 'intl' )
        {
            if (! isset($_SESSION))
                session_start();

            $_SESSION[$nonce . '_LOGIN_PASSWORD'] = $password;
        }

        public function get_login_user_id( $nonce = 'intl' )
        {
            if (! isset($_SESSION))
                session_start();

            return isset($_SESSION[$nonce . '_LOGIN_USER_ID']) ? $_SESSION[$nonce . '_LOGIN_USER_ID'] : null;
        }

        public function get_login_password( $nonce = 'intl' )
        {
            if (! isset($_SESSION))
                session_start();

            return isset($_SESSION[$nonce . '_LOGIN_PASSWORD']) ? $_SESSION[$nonce . '_LOGIN_PASSWORD'] : null;
        }
        
        public function get_session_id()
        {
            if (! isset($_SESSION))
                session_start();

            return session_id();
        }
        
        public function get_session_value( $key = '')
        {
            if (! isset($_SESSION))
                session_start();
            if (!$key)
                return $_SESSION;
            
             
            return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
        }
        
        //session

//        //cookie
//        public function set_login_user_id( $user_id, $nonce = '' )
//        {
//            $expire = time() + $this->cookie_expire;
//            setcookie($nonce . '_LOGIN_USER_ID', $user_id, $expire, $this->cookie_path, $this->cookie_domain);
//        }
//
//        public function set_login_password( $password, $nonce = '' )
//        {
//            $expire = time() + $this->cookie_expire;
//            setcookie($nonce . '_LOGIN_PASSWORD', $password, $expire, $this->cookie_path, $this->cookie_domain);
//        }
//
//        public function get_login_user_id( $nonce = '' )
//        {
//            return $_COOKIE[$nonce . '_LOGIN_USER_ID'];
//        }
//
//        public function get_login_password( $nonce = '' )
//        {
//            return $_COOKIE[$nonce . '_LOGIN_PASSWORD'];
//        }
//        //cookie

    }

?>
