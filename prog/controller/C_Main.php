<?php

    class C_Main extends Controller
    {
        public function __construct($setup)
        {
            parent::__construct($setup);

            $this->cache   =60;//memcache
            $this->expires = 0;//ä¯ÀÀÆ÷»º´æ
        }
        
           public function do_main()
        {
        	  $inputs  = self::$l_input->request();
            $user_id = $this->get_login_user_id();
            $db_role = $this->setup->get_model_handler('cate/role');          
            $db_user = $this->setup->get_model_handler('base/user');
        	  $opts=array('dbh' => 'default');
        	  $role=$db_role->get_list($opts,$this->cache
        	  );
            $user = $db_user->get_list($opts,$this->cache);
        	  $res = $db_user->get_page_list($opts,$this->cache);
        	  $res['user']=$user;
        	  $res['role']=$role;
        	  $template = "index/index-tmpl.html";
            self::$l_output->display($template, $res, $this->expires);
        	
        	
        	
        	
        }
        
        
        
      
       
      
      
    }

?>