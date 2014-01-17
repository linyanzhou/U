<?php

    class C_Main extends Controller
    {
        public function do_main()
        {
            $res = array();  
            $template = "$this->action/main-tmpl.html";
            self::$l_output->display($template, $res, $this->expires);
        }
        
        
        
    }

?>
