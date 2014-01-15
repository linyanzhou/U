<?php

    class L_Uri extends Library
    {
        public function __construct( $setup, $opts = null )
        {
            parent::__construct($setup);
        }


        public function redirect( $action, $params = null )
        {
            is_string($action)
                or exit('Action required to do redirect!');

            is_array($params)
                or $params = array();

            if ( preg_match('/^([^?]*)\?(.*)/', $action, $matches) ) {
                $action = $matches[1];
                $query  = $matches[2];
                $querys = preg_split('/&|;/', $query);

                foreach ($querys as $query) {
                    $vals = preg_split('/=/', $query);
                    $k = $vals[0];
                    $v = $vals[1];

                    if ( $k && ! isset($params[$k]) )
                        $params[$k] = $v;
                }
            }
             
            $querys = array();
            foreach ($params as $k=>$v) {
                if ($k != '' && $v != '')
                    $querys[] = "$k=" . $v;
                    //$querys[] = "$k=" . rawurlencode($v);
            }

            if ( count($querys) > 0 )
                $action .= '?' . join('&', $querys);
    
            Header("Location:$action");
            exit;
        }

        public function make_url($inputs, $fields)
        {
            $query = $this->_http_build_query($inputs, $fields);

            $relative = $_SERVER['PHP_SELF'];
            

            return join( '?', array($relative, $query) );
        }

        private function _http_build_query($inputs, $fields)
        {
            foreach ($fields as $field) {
                $res[$field] = isset($inputs[$field]) ? $inputs[$field] : null;
            }

            return http_build_query($res);
        }
    }

?>