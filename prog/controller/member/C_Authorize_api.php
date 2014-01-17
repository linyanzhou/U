<?php

    class C_Authorize_api extends Controller
    {
        public function __construct( $setup, $opts = null )
        {
            parent::__construct($setup);
        }


        public function authorize()
        {
            $login_cookie = $this->get_cookie_login_user_id();     
            $list_types = $this->get_main_menu_text($login_cookie);
            
            if(is_array($list_types) && $login_cookie){ 
                 if($this->get_login_user_id() != $login_cookie)
                     $this->set_login_user_id($login_cookie);
                 $login = $login_cookie;
             
            }else{
            	 $retparam = "index.php?_a=main&f=jump&returl=".rawurlencode("$this->url_my/index.php?_a=$this->action&f=$this->function");
            	 $returl = $this->url_intl_my."/index.php?exp=not_login&_d=member&_a=login&reurl=".rawurlencode($retparam);

            	 self::$l_uri->redirect($returl);
            }             
            self::$Global['AUTH_MENU'] = $list_types;

            foreach ($list_types as $lt) {
                $list_actions = $lt['list_actions'];
                foreach ($list_actions as $la) {
                    $action_code = $la['action_code'];
                    $action_func = $la['action_func'];

                    if ($this->action == $action_code && ($this->function == $action_func || ! $action_func))
                        return;
                }
            }

            if ( $this->_is_valid_member() ) {
                $res['exp']  = 'unauthorized';
                $res['tmpl'] = 'Share';
                $res['_url_ui'] = $this->_config['url_ui'];

                $this->prompt_exception($res);
            }
            else {
                $exp   = 'not_login';
                $reurl = self::$l_input->request('reurl');
                $reurl
                    or $reurl = rawurlencode( $_SERVER['REQUEST_URI'] );

                $res = array(
                    'reurl' => $reurl,
                    'exp'   => $exp
                );
                $this->prompt_login($res);
            }

            return FALSE;
        }

        private function _is_valid_member()
        {
            $login = $this->get_login_user_id();
            $login_cookie = $this->get_cookie_login_user_id();
            
            if ($login && $login == $login_cookie)
                return TRUE;

            return FALSE;
        }
       
        private function get_main_menu_text($user_id)
        {
            $sess_id =  $this->get_session_id();
            $memcached = $this->setup->get_library_handler('memcached');

            $list_types_ = array();
            $cache_id = $user_id . '_m_'. $sess_id;
            list($cache_id, $cache_obj) = $memcached->get_cache($cache_id);

            if ($cache_obj) {            	
                $list_types_ = json_decode($cache_obj, true);
                return $list_types_;
            }
            else {            	  
                $url = $this->url_intl_api."/index.php?_a=auth&f=sync_auth&poster=$user_id&sess_id=$sess_id";
                $content = file_get_contents($url); 
                $list_types_ = json_decode($content, true);
            }    
            if (is_array($list_types_)) {
                    $cache = 36000;
                    $cache_obj = json_encode($list_types_);
                    $memcached->set_cache($cache_id, $cache_obj, $cache);                    
            }
            //print_r($list_types_);

            return $list_types_;
        }
        
    }

?>