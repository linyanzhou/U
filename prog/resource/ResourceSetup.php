<?php

    class ResourceSetup
    {
        public function __construct($opts) 
        {
            $opts = $this->_extend($opts);

            $this->_function  = $opts['function'];
            $this->_action    = $opts['action'];
            $this->_domain    = $opts['domain'];
            $this->_charset   = $opts['charset'];
            $this->_authorize = $opts['authorize'];       
            $this->_deploy_root  = $opts['deploy_root'];
            $this->_cache_folder = $opts['cache_folder'];
            $this->_conf_folder  = $opts['conf_folder'];
            $this->_ctrl_folder  = $opts['ctrl_folder'];
            $this->_file_folder  = $opts['file_folder'];
            $this->_libs_folder  = $opts['libs_folder'];
            $this->_logs_folder  = $opts['logs_folder'];
            $this->_model_folder = $opts['model_folder'];
            $this->_tmpl_folder  = $opts['tmpl_folder'];

            $this->_domain && $this->_action
                or exit('Domain and Action must be provided!');

            is_dir($this->_deploy_root)
                or exit("Deploy root: not a directory: $this->_deploy_root!");

            $this->_main_config = $this->_get_main_config();
        }


        public function get_function() {
            return $this->_function;
        }

        public function get_action() {
            return $this->_action;
        }

        public function get_domain() {
            return $this->_domain;
        }

        public function get_charset() {
            return $this->_charset;
        }

        public function get_authorize() {
            return ( $this->_authorize != FALSE );
        }

        

        public function get_deploy_root() {
            return $this->_deploy_root;
        }

        public function get_cache_folder() {
            return $this->_cache_folder;
        }

        public function get_config_folder() {
            return $this->_conf_folder;
        }

        public function get_controller_folder() {
            return $this->_ctrl_folder;
        }

        public function get_file_folder() {
            return $this->_file_folder;
        }

        public function get_library_folder() {
            return $this->_libs_folder;
        }

        public function get_logs_folder() {
            return $this->_logs_folder;
        }

        public function get_model_folder() {
            return $this->_model_folder;
        }

        public function get_template_folder() {
            return $this->_tmpl_folder;
        }

        public function get_main_config() {
            return $this->_main_config;
        }

        public function get_request_ip()
        {
            if ($_SERVER) {
                if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }
                else if (isset($_SERVER['HTTP_CLIENT_ip'])) {
                    $ip = $_SERVER['HTTP_CLIENT_ip'];
                }
                else {
                    $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
                }
            }
            else {
                if (getenv('HTTP_X_FORWARDED_FOR')) {
                    $ip = getenv( 'HTTP_X_FORWARDED_FOR' );
                }
                else if (getenv('HTTP_CLIENT_ip')) {
                    $ip = getenv('HTTP_CLIENT_ip');
                }
                else {
                    $ip = getenv('REMOTE_ADDR');
                }
            }

            return $ip; 
        }

        public function get_controller_handler( $ctrl = null, $domain = null, $opts = array(), $reload = FALSE )
        {
            $ctrl
                or $ctrl = $this->_action;

            $domain
                or $domain = $this->_domain;
 
            $class = 'C_' . ucfirst( strtolower($ctrl) );
            

            $folder = "$this->_ctrl_folder/$domain";
           

            return $this->_get_class_handler($folder, $class, $opts, $reload);
        }

        public function get_model_handler( $model, $opts = array(), $reload = FALSE )
        {
            if ( preg_match('/\//', $model) )
                list($dir, $model) = preg_split('/\//', $model);

            $class = 'M_' . ucfirst( strtolower($model) );

            $folder = $this->_model_folder;

            if ($dir)
                $folder .= "/$dir";

            return $this->_get_class_handler($folder, $class, $opts, $reload);
        }

        public function get_library_handler( $library, $opts = array(), $reload = FALSE )
        {
            $dir = null;

            if ( preg_match('/\//', $library) )
                list($dir, $library) = preg_split('/\//', $library);

            $class = 'L_' . ucfirst( strtolower($library) );

            $folder = $this->_libs_folder;

            if ($dir)
                $folder .= "/$dir";

            return $this->_get_class_handler($folder, $class, $opts, $reload);
        }

        private function _get_class_handler( $folder, $class_name, $opts = array(), $reload = FALSE )
        {
            $folder
                or exit('Class folder must be provided!');

            $class_name
                or exit('Class name must be provided!');

            $class = "$folder/$class_name.php";
            $file  = "$this->_deploy_root/$class";
         
            $key   = md5($file);

            if ( isset($this->_CLASS_HANDLER[$key]) && $reload == FALSE )
                return $this->_CLASS_HANDLER[$key];

            is_file($file)
                or exit("Failed to load Class($class)!");
            require_once($file);

            class_exists($class_name)
                or exit("Non-existent class: $class_name!");

            $handler = new $class_name($this, $opts);
            
            is_object($handler)
                or exit("Failed to initialization Class($class)!");

            $this->_CLASS_HANDLER[$key] = $handler;

            return $handler;
        }

        private function _get_main_config()
        {        	  
          
                $class = "$this->_conf_folder/Main.php";
                $file  = "$this->_deploy_root/$class";
                is_file($file)
                   or exit("Failed to load Main Config($class)!");
                require_once($file);
            
            ( isset($config) && is_array($config) )
                or exit("Main Config($class) does not appear to contain a valid configuration array!");

            return $config;
        }

        private function _extend($opts)
        {
            is_array($opts)
                or $opts = array();

            isset( $opts['action'] )
                or $opts['action'] = 'main';

            isset( $opts['charset'] )
                or $opts['charset'] = 'UTF-8';

            isset( $opts['cache_folder'] )
                or $opts['cache_folder'] = 'cache';

            isset( $opts['conf_folder'] )
                or $opts['conf_folder'] = 'prog/config';

            isset( $opts['ctrl_folder'] )
                or $opts['ctrl_folder'] = 'prog/controller';

            isset( $opts['file_folder'] )
                or $opts['file_folder'] = 'Upload';

            isset( $opts['libs_folder'] )
                or $opts['libs_folder'] = 'prog/library';

            isset( $opts['logs_folder'] )
                or $opts['logs_folder'] = 'logs';

            isset( $opts['model_folder'] )
                or $opts['model_folder'] = 'prog/model';

            isset( $opts['tmpl_folder'] )
                or $opts['tmpl_folder'] = 'UI/template';

            return $opts;
        }

    }

?>