<?php

    class C_Welcomeinfo extends Controller
    {
        public function __construct( $setup, $opts = null )
        {
            parent::__construct($setup);
        }


        private function do_show_header( $res = array() )
        {
            $template = 'Share/header.html';

            return self::$l_output->fetch($template, $res);
        }

        private function do_show_footer( $res = array() )
        {
            $template = 'Share/footer.html';

            return self::$l_output->fetch($template, $res);
        }

        private function do_make_main_menu_text( $res = array() )
        {                        
            $template = 'Share/main-menu-text.html';

            return self::$l_output->fetch($template, $res);
        }        



        private function do_show_header_new( $res = array() )
        {
            $template = 'Share/header_new.html';

            return self::$l_output->fetch($template, $res);
        }

        private function do_show_footer_new( $res = array() )
        {
            $template = 'Share/footer_new.html';

            return self::$l_output->fetch($template, $res);
        }

        private function do_make_main_menu_text_new( $res = array() )
        {                        
            $template = 'Share/main-menu-text_new.html';

            return self::$l_output->fetch($template, $res);
        }  




        public function get_welcome_info()
        {
            $res['_d'] = $this->domain;
            $res['_a'] = $this->action;
            $res['f']  = $this->function;
            $res['_login_user_id'] = $this->get_login_user_id();
            
            $res['list_types'] = self::$Global['AUTH_MENU'];
            $res['base_auth'] = $res['list_types'][0];
             
            $res['Header'] = $this->do_show_header($res);
            $res['Footer'] = $this->do_show_footer($res);
            $res['Main_menu_text'] = $this->do_make_main_menu_text($res);
             $res['Header_new'] = $this->do_show_header_new($res);
            $res['Footer_new'] = $this->do_show_footer_new($res);
            $res['Main_menu_text_new'] = $this->do_make_main_menu_text_new($res);
 
            return $res;
        }
               

    }

?>