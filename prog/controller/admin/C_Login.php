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
            $action=isset($inputs['_a']) ? $inputs['_a'] : null;
            $domain=isset($inputs['_d']) ? $inputs['_d'] : null;
            $res = array(
                'login' => $login,
                'reurl' => $reurl,
                "E_$exp" => 1,
                '_a' => $action,
                '_d' => $domain,
            );

            $template = "$this->action/login-tmpl.html";
            self::$l_output->display($template, $res, $this->expires);
        }

        public function do_check_login()
        {
        	
         
            $inputs   = self::$l_input->post();
            $db_admin = $this->setup->get_model_handler('auth/admin');
 
            $exp    = 'incorrect';
            $login  = isset($inputs['login']) ? $inputs['login'] : null;
            $passwd = isset($inputs['passwd']) ? $inputs['passwd'] : null;
            $reurl  = isset($inputs['reurl']) ? $inputs['reurl'] : null;

            if ($login && $passwd) {
                $opts = array(
                    'login'  => $login,
                    'passwd' => $passwd,
                    'status' => 1
                );
                
                
                $rv = $db_admin->get_profile($opts, $this->cache);

                $user_id = isset($rv['login']) ? $rv['login'] : null;
                $passwd  = isset($rv['passwd']) ? $rv['passwd'] : null;
                $passwd  = $this->passwd_encrypt($passwd);

                if ($user_id) {
                    $this->set_login_user_id($user_id, $this->domain);
                    $this->set_login_password($passwd, $this->domain);

                    if ($reurl)
                        self::$l_uri->redirect($reurl);

                    $this->prompt_main();
                }
            }

            $res = array(
                'login' => $login,
                'reurl' => rawurlencode($reurl),
                'exp'   => $exp
            );
            $this->prompt_login($res);
        }

        public function do_logout()
        {
            $this->set_login_user_id('', $this->domain);
            $this->set_login_password('', $this->domain);
            $this->prompt_login();
        }

    }

?>