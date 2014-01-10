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

//            %c �����־��Ϣ���������ȫ�� 
//            %d �����־ʱ�������ڻ�ʱ�䣬Ĭ�ϸ�ʽΪISO8601 
//            %f �����־��Ϣ������������� 
//            %l �����־�¼��ķ���λ�ã��������־��Ϣ����䴦�������ڵ���ĵڼ��� 
//            %m ���������ָ������Ϣ����log(message)�е�message 
//            %n ���һ���س����з���Windowsƽ̨Ϊ��rn����Unixƽ̨Ϊ��n�� 
//            %p ������ȼ�����DEBUG��INFO��WARN��ERROR��FATAL������ǵ���debug()����ģ���ΪDEBUG���������� 
//            %r �����Ӧ���������������־��Ϣ���ķѵĺ����� 
//            %t �����������־�¼����߳���
        }

    }

?>