<?php 

    class C_Register extends Controller
    {
        public function do_main()
        {
            $this->do_detail();
        }

        public function do_detail( $act = null, $res = array() )
        {
            $res = array();
            $action="http://china.toocle.com/member/admin/hub/reg.cgi?t=minfo&f=add&lang=chn";
            self::$l_uri->redirect($action, $res);
            exit;
            
            $inputs = self::$l_input->request();

            $exp = isset($res['exp']) ? $res['exp'] : null;

            $res["E_$exp"] = 1;
            $res = self::$l_output->escape($res);
            $template = "$this->action/register-tmpl.html";
            self::$l_output->display($template, $res, $this->expires);
        }
        
        public function do_validate( $act = null, $res = array() )
        {
            $inputs = self::$l_input->request();
            $ret = "true";
            $a = isset($inputs['a']) ? $inputs['a'] : null;

            if($a == "reg_uname"){
               $str = isset($inputs['login']) ? $inputs['login'] : null;
               $ret = ( preg_match('/^[a-z0-9_]{4,16}$/', $str) ) ? "true" : "false"; 
            }
            if($a == "reg_pass"){
               $str = isset($_GET['passwd']) ? $_GET['passwd'] : null;
               $ret = ( preg_match('/^[a-z0-9_]{6,16}$/', $str) ) ? "true" : "false";  
            }
             
            self::$l_output->show($ret, $this->expires);
        }
        
        public function do_change()
        {
            $inputs    = self::$l_input->post('', TRUE);                               

            $login   = $inputs['login'];
            $passwd  = $inputs['passwd'];
            $cpasswd = $inputs['cpasswd'];
            $name    = $inputs['firstname'];
            $company = $inputs['company'];
            $position= $inputs['position'];
            $regional= $inputs['regional'];
            $address = $inputs['address'];
            $tel     = $inputs['tel'];
            $mobile  = $inputs['mobile'];
            $email   = $inputs['email'];
            $vdate = isset($inputs['vdate']) ? $inputs['vdate'] : null;
            if(!$vdate || ( $vdate!= $this->get_session_value('vdate_reg'))){
            	  $exp = 'verification_code_no_match';
                //$this->prompt_exception(array('exp' => 'verification_code_no_match','tmpl'=>"Share"));
            }    
            else if(self::$l_blacklist->check_in_blacklist('', $inputs)){ 
            	   $exp = 'match_in_blacklist';
            	   $this->prompt_exception(array('exp' => 'match_in_blacklist','tmpl'=>"Share"));            	
            }	
            else if ( ! self::$l_validate->is_login($login) ) {
                $exp = 'login_not_standard';
            }
            else if ($passwd == '') {
                $exp = 'passwd_is_null';
            }
            else if ($passwd != $cpasswd) {
                $exp = 'passwd_not_equal';
            }
            else if ($name == '') {
                $exp = 'name_is_null';
            }
            else if ($position == '') {
                $exp = 'position_is_null';
            }
            else if ($regional == '') {
                $exp = 'regional_is_null';
            }
            else if ($address == '') {
                $exp = 'address_is_null';
            }
            else if ($tel == '') {
                $exp = 'tel_is_null';
            }
            else if ($mobile == '') {
                $exp = 'mobile_is_null';
            }
            else if (!self::$l_validate->is_email($email)) {
                $exp = 'email_not_standard';
            }
            else{
                $db_member = $this->setup->get_model_handler('auth/member');
                $db_member_to_group = $this->setup->get_model_handler('auth/member_to_group');
                $post_ip   = $this->setup->get_request_ip();               
                $inputs['post_ip'] = $post_ip;
                
                $opts = array(
                    'login'=> $login
                );
                $rv = $db_member->get_profile($opts, $this->cache);
                if ( $rv['id'] > 0 ) {
                    $exp = 'login_exists';
                }
                else {
                    $opts = array(
                        'email'=> $email
                    );
                    $rv = $db_member->get_profile($opts, $this->cache);
                    if ($rv['id'] > 0) {
                        $exp = 'email_exists';
                    }
                    else {
                        $opts = array(
                            'inputs' => $inputs
                        );
                        $id = $db_member->create($opts);

                        if ($id > 0) {
                            $opts = array(
                                'id'     => $id,
                                'fields' => array('passwd', 'status'),
                                'inputs' => array(
                                    'passwd' => $passwd,
                                    'status' => 0
                                )
                            );
                            $rv = $db_member->change($opts);

                            if (! $rv) {
                                $exp = 'change_failed';
                            }
                            else {
                                //会员ID：3
                                //member2group
                                if(!in_array($inputs['gid'], array('16','17','19'))) $inputs['gid']=16; //组id
                                $inputs['member_id'] = $id;
                                $inputs['group_id']  = $inputs['gid'];                                
                                $opts = array(
                                    'inputs' => $inputs
                                );
                                $db_member_to_group->create($opts);

                                $this->set_login_user_id($login);
                                
                                //$this->prompt_main();
                                 $res['exp']  = 'register_successful';
                                 $res['tmpl'] = 'register';
                                 $res['_url_ui'] = $this->_config['url_ui'];
                                 $this->prompt_exception($res);
                            }
                        }
                        else{
                             $exp = 'create_failed';
                        }
                    }
                }
            }

            $inputs['exp'] = $exp;
            $this->do_detail( null, $inputs);
        }
  
        public function do_forget()
        {
            $inputs = self::$l_input->request();

            $exp = $inputs['exp'];

            $res["E_$exp"] = 1;
            $res = self::$l_output->escape($res);

            $template = "$this->action/forget-tmpl.html";
            self::$l_output->display($template, $res, $this->expires);
        }

        public function do_post_forget()
        {
            $inputs = self::$l_input->post('', TRUE);
            $db_member  = $this->setup->get_model_handler('auth/member');
            $l_sendmail = $this->setup->get_library_handler('sendmail');

            $exp   = 'post_forget_failed';
            $login = $inputs['login'];

            if ( $login ) {
                $opts=array(
                    'login'=> $login
                );
                $rv = $db_member->get_profile($opts, $this->cache);

                if ( $rv['id'] > 0 ) {
                    $exp = 'post_forget_successful';
                    $to  = $rv['email'];
                    //$to  = "zny@netsun.com";
                    $res['pdate'] = date('Y年m月d日');

                    if ( self::$l_validate->is_email($to) ) {
                        $from  = "生意助手 - 生意宝<admin@netsun.com>";
                        $title = "找回密码";
                        $title = iconv($this->charset, 'GBK', $title);
                        $content  = $rv['contact'] . '您好！您的用户名（' . $rv['login'] . '）密码是：' . $rv['passwd'];
                        $res['content'] = $content;
                        $template = "$this->action/email-tmpl.html";
                        $htmls    = self::$l_output->fetch($template, $res, $this->expires);

                        $l_sendmail->sendmail($to, $from, $title, $htmls, 'HTML');
                    }
                }
            }
            else {
                $exp = 'login_not_exists';
            }

            $res = array();
            $res['exp'] = $exp;
            $action = "?_d=$this->domain&_a=$this->action&f=forget";
            self::$l_uri->redirect($action, $res);
        }

    }
?>