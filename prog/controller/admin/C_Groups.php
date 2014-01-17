<?php 

    class C_Groups extends Controller
    {
        public function do_main()
        {
            $this->do_list();
        }

        public function do_list()
        {
            $inputs   = self::$l_input->request();
            $user_id  = $this->get_login_user_id( $this->domain );
            $db_group = $this->setup->get_model_handler('auth/group');
 
            $exp   = isset($inputs['exp']) ? $inputs['exp'] : null;  
            $page  = isset($inputs['p']) ? $inputs['p'] : null;
            $terms = isset($inputs['terms']) ? $inputs['terms'] : null;

            $page > 0
                or $page = 1;
            $terms = trim($terms);

            $url_prefix  = self::$l_uri->make_url($inputs, array('_d', '_a', 'f', 'terms'));
            $url_prefix .= '&p=';

            $opts = array(
                'terms'      => $terms,
                'curr_page'  => $page,
                'url_prefix' => $url_prefix
            );

            $res  = $db_group->get_page_list($opts, $this->cache);
            $list = $res['pw_rec_list'];

            foreach ($list as &$l) {
                $l['name1'] = self::$l_string->substring($l['name'], 20);

                if ($terms) {
                    $l['name1'] = self::$l_string->highlight($l['name1'], $terms);
                }
            }

            $res['list_groups'] = $list;
            $res["E_$exp"] = 1;
             
            $template = "$this->action/list-tmpl.html";
            self::$l_output->display($template, $res, $this->expires);
        }

        public function do_copy()
        {
            $this->do_detail('copy');
        }

        public function do_detail( $act = null, $res = array() )
        {
            $inputs    = self::$l_input->request();
            $user_id   = $this->get_login_user_id( $this->domain );
            $db_group  = $this->setup->get_model_handler('auth/group');
            $db_type   = $this->setup->get_model_handler('auth/type');
            $db_action = $this->setup->get_model_handler('auth/action');
            $db_action_to_group = $this->setup->get_model_handler('auth/action_to_group');

            $exp = isset($inputs['exp']) ? $inputs['exp'] : null;
            $id  = isset($inputs['id']) ? $inputs['id'] : null;

            if ($act == 'change_failed') {
                $exp = $res['exp'];
            }
            else {
                $opts = array(
                    'id' => $id
                );
                $res = $db_group->get_profile($opts, $this->cache);//  detail页面  <{$name}>  <{$intro}>
 
                if ( $act == 'copy' )
                    $res['id'] = null;
            }

            //list_actions         GRANT类型action
            $opts = array();
            $list_types = $db_type->get_list($opts, $this->cache);

            foreach ($list_types as &$lt) {
                $opts = array(
                    'type_id' => $lt['id'],
                    'access_type' => 'GRANT'   //获取grant类型的action
                );
                $list_actions = $db_action->get_list($opts, $this->cache);
                $lt['list_actions'] = $list_actions;
            }
            $res['list_types'] = $list_types;

            //get_actions_of_group
                                                    //js那边set_check
            $opts = array( 
                'group_id' => $id
            );
            $list_actions = $db_action_to_group->get_list($opts);
            $res['list_actions'] = $list_actions;
       
            $res["E_$exp"] = 1;
            $res = self::$l_output->escape($res);

            $template = "$this->action/detail-tmpl.html";
            self::$l_output->display($template, $res, $this->expires);
        }

        public function do_change()
        {
            $inputs   = self::$l_input->post();
            
            $user_id  = $this->get_login_user_id( $this->domain );
            $post_ip  = $this->setup->get_request_ip();
            $db_group = $this->setup->get_model_handler('auth/group');
            $db_action_to_group = $this->setup->get_model_handler('auth/action_to_group');

            $inputs['poster_id'] = $user_id;
            $id   = isset($inputs['id']) ? $inputs['id'] : null;
            $name = isset($inputs['name']) ? $inputs['name'] : null;
 
            if ( trim($name) == '' ) {
                $exp = 'name_is_null';
            }
            else {
                $opts = array(
                    'id'     => $id,
                    'inputs' => $inputs
                );
 
                if ($id > 0) {
                    $exp = 'change_successful';
                     
                    $rv  = $db_group->change($opts);
                   
                    if (! $rv)
                        $exp = 'change_failed';
                }
                else {
                    $exp = 'create_successful';
                    $id  = $db_group->create($opts);
                    if (! $id)
                        $exp = 'create_failed';
                }
            }

            //action2group
            if ($id > 0) {
                //del_actions_of_group
                $opts = array(
                    'group_id' => $id
                );
                $rv = $db_action_to_group->delete($opts);

                if ($rv) {
                    $inputs['group_id'] = $id;
                    $action_ids = isset($inputs['action_id']) ? $inputs['action_id'] : null;
                    
                    if (is_array($action_ids)) {
                        foreach ($action_ids as $action_id) {
                            if ($action_id > 0) {
                                $inputs['action_id'] = $action_id;
                                $opts = array(
                                    'inputs' => $inputs
                                );
                                $db_action_to_group->create($opts);
                                
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

        public function do_able()
        {
            $inputs   = self::$l_input->get();
            $user_id  = $this->get_login_user_id( $this->domain );
            $post_ip  = $this->setup->get_request_ip();
            $db_group = $this->setup->get_model_handler('auth/group');

            $id = isset($inputs['id']) ? $inputs['id'] : null;

            if ($id <= 0)
                return;

            $opts = array(
                'id' => $id
            );
            $rv = $db_group->get_profile($opts, $this->cache);

            if ($rv['id'] <= 0)
                return;

            $status = abs($rv['status'] - 1);
            $opts = array(
                'id' => $id,
                'unpost' => TRUE,
                'fields' => array('status', 'poster_id', 'post_ip'),
                'inputs' => array(
                    'status'    => $status,
                    'poster_id' => $user_id,
                    'post_ip'   => $post_ip
                )
            );
            $db_group->change($opts);

            self::$l_output->show($status);
        }

        public function do_delete()
        {
            $inputs   = self::$l_input->request();
            $user_id  = $this->get_login_user_id( $this->domain );
            $post_ip  = $this->setup->get_request_ip();
            $db_group = $this->setup->get_model_handler('auth/group');

            $inputs['poster_id'] = $user_id;
            $inputs['post_ip']   = $post_ip;

            $id         = isset($inputs['id']) ? $inputs['id'] : null;
            $delete_ids = isset($inputs['delete_ids']) ? $inputs['delete_ids'] : null;
            $url_prefix = isset($inputs['url_prefix']) ? $inputs['url_prefix'] : null;

            is_array($delete_ids)
                or $delete_ids = $del_ids;

            if ($id > 0)
                $delete_ids[] = $id;

            foreach ($delete_ids as $id) {
                if ($id <= 0)
                    continue;

                $opts = array(
                    'id' => $id
                );

                $rv = $db_group->delete($opts);
                if ($rv)
                    $exp = 'delete_successful';
            }

            $res['exp'] = $exp;
            $action = $url_prefix ? $url_prefix : "?_d=$this->domain&_a=$this->action&f=list";
            self::$l_uri->redirect($action, $res);
        }

    }

?>