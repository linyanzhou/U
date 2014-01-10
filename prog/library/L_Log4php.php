<?php

    class L_Log4php extends Library
    {
        public function __construct( $setup, $opts = null )
        {
            parent::__construct($setup);

            $this->_opts = $this->extend($opts, 'log4php');
            $this->_set_log4php();
        }


        private function _set_log4php()
        {
            $name = isset($this->_opts['name']) ? $this->_opts['name'] : 'log4php';
            $properties = $this->_opts[$name];

            $conf   = "$this->conf_folder/$properties";
            $config = "$this->deploy_root/$conf";

            is_file($config)
                or exit("Config for log4php($conf) not exists!");

            $class = "$this->libs_folder/log4php/Logger.php";
            $file  = "$this->deploy_root/$class";

            is_file($file)
                or exit("Failed to load Log4php($class)!");
            require_once($file);

            Logger::resetConfiguration();
            Logger::configure($config);
            $this->_Logger = Logger::getLogger($name);
        }

        public function debug($log)
        {
            if ( $log && $this->_Logger )
                $this->_Logger->debug($log);

//            $log4php = $this->setup->get_library_handler('log4php');
//            $log4php->debug('testsadasdad');
//
//            $opts = array(
//                'name' => 'sql'
//            );
//            $log4php = $this->setup->get_library_handler('log4php', $opts, TRUE);
//            $log4php->debug('test sqlasdasdsad');

//            %c 输出日志信息所属的类的全名 
//            %d 输出日志时间点的日期或时间，默认格式为ISO8601 
//            %f 输出日志信息所属的类的类名 
//            %l 输出日志事件的发生位置，即输出日志信息的语句处于它所在的类的第几行 
//            %m 输出代码中指定的信息，如log(message)中的message 
//            %n 输出一个回车换行符，Windows平台为“rn”，Unix平台为“n” 
//            %p 输出优先级，即DEBUG，INFO，WARN，ERROR，FATAL。如果是调用debug()输出的，则为DEBUG，依此类推 
//            %r 输出自应用启动到输出该日志信息所耗费的毫秒数 
//            %t 输出产生该日志事件的线程名
        }

    }

?>