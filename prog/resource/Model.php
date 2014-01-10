<?php

    class Model extends Base
    {
        public static $DB  = null;
        public static $DBM = null;

        public function __construct($setup)
        {
            parent::__construct($setup);

            if ( isset($this->main_config['model']) )
                $this->_config = $this->main_config['model'];

            if ( is_array($this->_config) ) {
                foreach ($this->_config as $k => $v) {
                    $this->$k = $v;
                }
            }

            $this->_set_datebase_config();
            $this->_set_dbmanage_handler();
        }


        public function get_datebase_config($t)
        {
            if ( isset(self::$DB[$t]) )
                return self::$DB[$t];

            exit("Table($t) is not in the configuration file!");
        }

        public function get_extend_datebase_config($class_dir)
        {                       
            $file  = "$class_dir/DataBase.php";
            $key   = "ext_".md5($file);
            if ( isset(self::$DB[$key]))
                return self::$DB[$key];
               
            is_file($file)
                or exit("Failed to load DataBase Config($file)!");
            require_once($file);
            
            ( isset($config) && is_array($config) )
                  or exit("DateBase Config($class) does not appear to contain a valid configuration array!");
                  
           self::$DB[$key] = $config;
           return $config;          
        }
        
        private function _set_datebase_config()   //config目录下 总的项目 database 配置
        {
            if ( isset(self::$DB) && self::$DB !== null )
                return;

            $class = "$this->conf_folder/DataBase.php";
            $file  = "$this->deploy_root/$class";

            is_file($file)
                or exit("Failed to load DataBase Config($class)!");
            require_once($file);

            ( isset($config) && is_array($config) )
                or exit("DateBase Config($class) does not appear to contain a valid configuration array!");

            self::$DB = $config;
        }

        private function _set_dbmanage_handler()
        {
            if ( isset(self::$DBM) && self::$DBM !== null )
                return;

            $dbmanage  = $this->setup->get_library_handler('dbmanage');
            $pdodb     = $this->setup->get_library_handler('pdodb');
            $memcached = $this->setup->get_library_handler('memcached');
           // $log4php   = $this->setup->get_library_handler('log4php', null, TRUE);   
            $dbmanage->set_pdodb($pdodb);
            $dbmanage->set_memcached($memcached);
           // $dbmanage->set_log4php($log4php);

            self::$DBM = $dbmanage;
        }

    }

?>