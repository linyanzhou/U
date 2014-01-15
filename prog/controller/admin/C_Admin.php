<?php 

    class C_Admin extends Controller
    {
        public function do_main()
        {
            $this->do_detail();
        }

        public function do_detail( $act = null, $res = array() )
        {
            $inputs   = self::$l_input->get();
            $user_id  = $this->get_login_user_id( $this->domain );
            $db_admin = $this->setup->get_model_handler('auth/admin');

            $exp = isset($inputs['exp']) ? $inputs['exp'] : null;

            if ($act == 'change_failed') {
                $exp = $res['exp'];
            }
            else {
                $opts = array(
                    'login' => $user_id
                );
                $res = $db_admin->get_profile($opts, $this->cache);
            }

            $res["E_$exp"] = 1;
            $res = self::$l_output->escape($res);

            $template = "$this->action/detail-tmpl.html";
            self::$l_output->display($template, $res, $this->expires);
        }

        public function do_change()
        {
            $inputs   = self::$l_input->post('', TRUE);
            $user_id  = $this->get_login_user_id( $this->domain );
            $post_ip  = $this->setup->get_request_ip();
            $db_admin = $this->setup->get_model_handler('auth/admin');

            $inputs['poster_id'] = $user_id;
            $inputs['post_ip']   = $post_ip;
            $inputs['login']     = $user_id;

            $exp   = 'change_successful';
            $id    = isset($inputs['id']) ? $inputs['id'] : null;
            $email = isset($inputs['email']) ? $inputs['email'] : null;

            if ( ! self::$l_validate->is_email($email) ) {
                $exp = 'email_not_standard';
            }
            else {
                $opts = array(
                    'login'  => $user_id,
                    'inputs' => $inputs
                );

                $rv = $db_admin->change($opts);
                if (! $rv)
                    $exp = 'change_failed';
            }

            if ( ! preg_match('/successful$/', $exp) ) {
                $inputs['exp'] = $exp;
                $this->do_detail('change_failed', $inputs);
            }
            else {
                $res['exp'] = $exp;
                $action = "?_d=$this->domain&_a=$this->action&f=detail";
                self::$l_uri->redirect($action, $res);
            }
        }

        public function do_change_passwd()
        {
            $inputs   = self::$l_input->post('', TRUE);
            $user_id  = $this->get_login_user_id( $this->domain );
            $post_ip  = $this->setup->get_request_ip();
            $db_admin = $this->setup->get_model_handler('auth/admin');

            $inputs['poster_id'] = $user_id;
            $inputs['post_ip']   = $post_ip;
            $inputs['login']     = $user_id;

            $exp     = 'change_passwd_successful';
            $opasswd = isset($inputs['opasswd']) ? $inputs['opasswd'] : null;
            $npasswd = isset($inputs['npasswd']) ? $inputs['npasswd'] : null;
            $cpasswd = isset($inputs['cpasswd']) ? $inputs['cpasswd'] : null;

            if ($npasswd == '') {
                $exp = 'passwd_not_standard';
            }
            else if ($cpasswd != $npasswd) {
                $exp = 'passwd_inconsistent';
            }
            else {
                $opts = array(
                    'login' => $user_id
                );
                $rv = $db_admin->get_profile($opts, $this->cache);
                $passwd = $rv['passwd'];

                if ($passwd != $opasswd) {
                    $exp = 'passwd_incorrect';
                }
                else {
                    $opts = array(
                        'login'  => $user_id,
                        'fields' => array('passwd', 'post_ip', 'poster_id'),
                        'inputs' => array(
                            'passwd'    => $npasswd,
                            'post_ip'   => $post_ip,
                            'poster_id' => $user_id
                        )
                    );

                    $rv = $db_admin->change($opts);
                    if (! $rv)
                        $exp = 'change_passwd_failed';
                }
            }

            $res['exp'] = $exp;
            $action = "?_d=$this->domain&_a=$this->action&f=detail";
            self::$l_uri->redirect($action, $res);
        }

    }
?>