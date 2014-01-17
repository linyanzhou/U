<?php

    class C_Login extends Controller
    {
        public function __construct( $setup, $opts = null )
        {
            parent::__construct($setup);
        }


        public function do_main()
        {
        	
            $this->do_login_form();
        }

        public function do_login_form()
        {
         
            $inputs = self::$l_input->get();

            $login = isset($inputs['login']) ? $inputs['login'] : null;
            $reurl = isset($inputs['reurl']) ? $inputs['reurl'] : null;
            $exp   = isset($inputs['exp']) ? $inputs['exp'] : null;

            $res = array(
                'login' => $login,
                'reurl' => $reurl,
                "E_$exp" => 1
            );
              
            $template = "$this->action/login-tmpl.html";
            
            self::$l_output->display($template, $res, $this->expires);
        }

        public function do_check_login()
        {
            $inputs    = self::$l_input->post();
            $db_member = $this->setup->get_model_handler('auth/member');

            $exp    = 'incorrect';
            $login  = isset($inputs['login']) ? $inputs['login'] : null;
            $login = preg_replace("/@.*?$/","",$login);
            $login = strtolower($login);
            $passwd = isset($inputs['passwd']) ? $inputs['passwd'] : null;
            $reurl  = isset($inputs['reurl']) ? $inputs['reurl'] : null;
            
           

            if ($login && $passwd) {
                $opts = array(
                    'login'  => $login,
                    'passwd' => $passwd
                );
                $rv = $db_member->get_profile($opts,0);
                
                $user_id = isset($rv['login']) ? $rv['login'] : null;
                $passwd  = isset($rv['passwd']) ? $rv['passwd'] : null;
                $passwd  = $this->passwd_encrypt($passwd);
              
                if ($user_id) {
                
                    $this->set_login_user_id($user_id);
                    $this->set_login_password($passwd);   
                    $this->set_cookie_login_user_id($user_id,$this->domain);
                  $this->prompt_main();
                 
               }               
            }

            $res = array(
                'login' => $login,
                'reurl' => $reurl,
                'exp'   => $exp
            );
            $this->prompt_login($res);  
               
            }

            
         

        public function do_logout()
        {
            $this->set_login_user_id('');
            $this->set_login_password('');
             $this->set_cookie_login_user_id('',$this->domain);
           
            $this->prompt_login();
        }
                
         
    }

?>