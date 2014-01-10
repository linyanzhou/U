<?php

    class Base
    {
        public function __construct($setup)
        {
         
            $this->setup=$setup;
            $this->function  = $setup->get_function();
            $this->action    = $setup->get_action();
            $this->domain    = $setup->get_domain();
            $this->charset   = $setup->get_charset();
            $this->authorize = $setup->get_authorize();           

            $this->deploy_root  = $setup->get_deploy_root();
            $this->cache_folder = $setup->get_cache_folder();
            $this->conf_folder  = $setup->get_config_folder();
            $this->ctrl_folder  = $setup->get_controller_folder();
            $this->file_folder  = $setup->get_file_folder();
            $this->libs_folder  = $setup->get_library_folder();
            $this->logs_folder  = $setup->get_logs_folder();
            $this->model_folder = $setup->get_model_folder();
            $this->tmpl_folder  = $setup->get_template_folder();
            $this->main_config  = $setup->get_main_config();
            
            
            //把这些属性  传递给Controller  Model  Library
        }

    }

?>