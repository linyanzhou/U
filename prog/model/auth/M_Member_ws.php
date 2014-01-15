<?php

    class M_Member_ws extends Model
    {
        public function __construct($setup)
        {
            parent::__construct($setup);
            $this->_url_ws = 'http://china.toocle.com/ws/server_ajax.php';
        }
        
        public function get_member_ws_profile($opts)
        {
            $http = $this->setup->get_library_handler('http');
            $login= isset($opts['login']) ? $opts['login'] : null;
            $passwd= isset($opts['passwd']) ? $opts['passwd'] : null;
            $md= isset($opts['md']) ? $opts['md'] : 0;
            if(!$login or !$passwd)
               return array();
            $url  = $this->_url_ws."?username=$login&password=$passwd&md=$md";
            $rv   = $http->httpget($url);
            $rv   = json_decode($rv, true);
            //print_r($data);

            return $rv;
        }

    }

?>