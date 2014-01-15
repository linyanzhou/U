<?php

    class C_Authorize extends Controller
    {
        public function __construct( $setup, $opts = null )
        {
            parent::__construct($setup);
        }


        public function authorize()
        {
            if ( $this->_is_authorized_for_action() )
                return;

            if ( $this->_is_valid_member() )
                return;

            $exp   = 'not_login';
            $reurl = self::$l_input->request('reurl');
            
            $reurl
                or $reurl =  $_SERVER['REQUEST_URI'] ;
             
            $res = array(
                'reurl' => $reurl,
                'exp'   => $exp
            );
            $this->prompt_login($res);
        }

        private function _is_authorized_for_action()
        {
            return $this->action == 'login' ? TRUE : FALSE;
        }

        private function _is_valid_member()
        {
            $login    = $this->get_login_user_id( $this->domain );
            $password = $this->get_login_password( $this->domain );

            if ($login) {
                $db_admin = $this->setup->get_model_handler('auth/admin');

                $opts = array(
                    'login' => $login
                );
                $rv = $db_admin->get_profile($opts, $this->cache);
                $passwd = $rv['passwd'];
                $passwd = $this->passwd_encrypt($passwd);

                return ($password == $passwd);
            }

            return FALSE;
        }
    }

?>