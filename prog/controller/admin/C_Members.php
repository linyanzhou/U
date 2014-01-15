<?php 

    class C_Members extends Controller
    {
        public function do_main()
        {
            $this->do_list();
        }

        public function do_list()
        {
            $inputs    = self::$l_input->request();
            $user_id   = $this->get_login_user_id( $this->domain );
            $db_member = $this->setup->get_model_handler('auth/member');
            $db_group  = $this->setup->get_model_handler('auth/group');

            $exp   = isset($inputs['exp']) ? $inputs['exp'] : null;
            $page  = isset($inputs['p']) ? $inputs['p'] : null;
            $terms = isset($inputs['terms']) ? $inputs['terms'] : null;
            $group_id = isset($inputs['group_id']) ? $inputs['group_id'] : null;

            $page > 0
                or $page = 1;
            $terms = trim($terms);

            $url_prefix  = self::$l_uri->make_url($inputs, array('_d', '_a', 'f', 'terms', 'group_id'));
            $url_prefix .= '&p=';

            $opts = array(
                'terms'      => $terms,
                'group_id'   => $group_id,
                'curr_page'  => $page,
                'url_prefix' => $url_prefix
            );

            $res  = $db_member->get_page_list($opts, $this->cache);
            $list = $res['pw_rec_list'];

            foreach ($list as &$l) {
                if ($terms)
                    $l['login'] = self::$l_string->highlight($l['login'], $terms);
            }

            //list_groups
            $opts = array();
            $res['list_groups'] = $db_group->get_list($opts, $this->cache);

            $res['list_members'] = $list;
            $res["E_$exp"] = 1;
   
            $template = "$this->action/list-tmpl.html";
            self::$l_output->display($template, $res, $this->expires);
        }

        public function do_detail( $act = null, $res = array() )
        {
            $inputs    = self::$l_input->request();
            $user_id   = $this->get_login_user_id( $this->domain );
            $db_member = $this->setup->get_model_handler('auth/member');
            $db_member_to_group  = $this->setup->get_model_handler('auth/member_to_group');

            $exp = isset($inputs['exp']) ? $inputs['exp'] : null;
            $id  = isset($inputs['id']) ? $inputs['id'] : null;

            if ($act == 'change_failed') {
                $exp = $res['exp'];
            }
            else {
                $opts = array(
                    'id' => $id
                );
                $res = $db_member->get_profile($opts, $this->cache);

                if ( $act == 'copy' )
                    $res['id'] = null;
            }

            $opts = array(
                'member_id' => $id
            );
            $list_groups = $db_member_to_group->get_list($opts);
            $res['list_groups'] = $list_groups;

            $res["E_$exp"] = 1;
            $res = self::$l_output->escape($res);

            $template = "$this->action/detail-tmpl.html";
            self::$l_output->display($template, $res, $this->expires);
        }

        public function do_change()
        {
            $inputs    = self::$l_input->post();
            $user_id   = $this->get_login_user_id( $this->domain );
            $post_ip   = $this->setup->get_request_ip();
            $db_member = $this->setup->get_model_handler('auth/member');
            $db_member_to_group = $this->setup->get_model_handler('auth/member_to_group');

            $inputs['poster_id'] = $user_id;
            $inputs['post_ip']   = $post_ip;

            $exp = 'change_successful';
            $id  = isset($inputs['id']) ? $inputs['id'] : null;

            //member2group
            if ($id > 0) {
                //del_groups_of_member
                $opts = array(
                    'member_id' => $id
                );
                $rv = $db_member_to_group->delete($opts);

                if ($rv) {
                    $inputs['member_id'] = $id;
                    $group_ids = isset($inputs['group_id']) ? $inputs['group_id'] : null;

                    if (is_array($group_ids)) {
                        foreach ($group_ids as $group_id) {
                            if ($group_id > 0) {
                                $inputs['group_id'] = $group_id;
                                $opts = array(
                                    'inputs' => $inputs
                                );
                                $db_member_to_group->create($opts);
                            }
                        }
                    }
                }
            }

            if ( ! preg_match('/successful$/', $exp) ) {
                $inputs['exp'] = $exp;
                $this->do_detail('change_failed', $inputs);
            }
            else {
                $res['exp'] = $exp;
                $action = "?_d=$this->domain&_a=$this->action&f=detail&id=" . $id;
                self::$l_uri->redirect($action, $res);
            }
        }

    }

?>