<?php

    class C_Authorize extends Controller
    {
        public function __construct( $setup, $opts = null )
        {
            parent::__construct($setup);
        }


        public function authorize()
        {
            $login = $this->get_login_user_id();
           
            
            $login_cookie = $this->get_cookie_login_user_id();
            
            if($login != $login_cookie)  
               $login="";
               
            $list_types = $this->get_main_menu_text($login);
             
            
            self::$Global['AUTH_MENU'] = $list_types;
         
            foreach ($list_types as $lt) {
   
                    $action_code = $lt['action_code'];
                                      
                    $action_func = $lt['action_func'];
                    
                   if ($this->action == $action_code && ($this->function == $action_func || ! $action_func))         
                   return ;  
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
                    or $reurl =  $_SERVER['REQUEST_URI'];
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
            
            $login_cookie =$this->get_cookie_login_user_id($this->domain);
             
            if ($login && $login == $login_cookie)
                return TRUE;

            return FALSE;
        }

        public function get_main_menu_text($user_id)
        {
            $user_id   = $this->get_login_user_id();
            $db_member   = $this->setup->get_model_handler('auth/member');
            $db_type   = $this->setup->get_model_handler('auth/type');
            $db_action = $this->setup->get_model_handler('auth/action');
            $memcached = $this->setup->get_library_handler('memcached');

            $list_actions = array();
            $cache_id = $user_id . '_fr_main_menu_text'; //echo md5($cache_id);
            list($cache_id, $cache_obj) = $memcached->get_cache($cache_id);

            if ($cache_obj) {            	
                $list_actions = json_decode($cache_obj, true);  
            }
            else {            	              	  
            	 
                //list_types
                $opts = array(
                    'fields'  => 'id,name,open',
                    'status'  => 1,
                    'orderby' => 'rank'
                );
                $list_types = $db_type->get_list($opts, 0);   

                //open_actions
                $opts = array(
                    'fields'  => 'id,action_code,action_func,access_type,namespace,name,type_id,status',
                    'status'  => 1,
                    'groupby' => 'action_id',
                    'access_type' => 'OPEN',
                    'namespace'   => 'c'
                );
                
                $open_actions = $db_action->get_list($opts, 0);
                
                $member_actions = array();
                $grant_actions  = array();
                $base_types = array("id"=>"0","name"=>"base");                
                 
                if ($user_id) {                	  
                    //member_actions
                    $opts = array(
                        'fields'  => 'id,action_code,action_func,access_type,namespace,name,type_id,status',
                        'status'  => 1,
                        'groupby' => 'action_id',
                        'access_type' => 'MEMBER',
                        'namespace'   => 'c'
                    );
                   
                    $member_actions = $db_action->get_list($opts, 0);
                     
                    //grant_actions
                    $opts = array(
                        'login'     => $user_id,
                        'status'    => 1,
                        'groupby'   => 'action_id',
                        'namespace' => 'c'
                    );
                    $grant_actions = $db_action->get_actions_of_grant($opts, 0);
                     
                    
                }

                $list_actions = array_merge($open_actions, $member_actions, $grant_actions);
                
            
                     $cache =60;
                    $cache_obj = json_encode($list_actions);
                    
                    $memcached->set_cache($cache_id, $cache_obj, $cache);
           }
            return $list_actions;
        
        
         
    }
}
?>