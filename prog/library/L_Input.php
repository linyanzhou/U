<?php

    class L_Input extends Library
    {
        public function __construct( $setup, $opts = null )
        {
            parent::__construct($setup);
        }


        public function get($index = '', $xss_clean = FALSE)
        {
            return $this->_dump_request($_GET, $index, $xss_clean);
        }

        public function post($index = '', $xss_clean = FALSE)
        {
            return $this->_dump_request($_POST, $index, $xss_clean);
        }

       

        public function request($index = '', $xss_clean = FALSE)
        {
            return $this->_dump_request($_REQUEST, $index, $xss_clean);
        }

        public function argv($index = '', $xss_clean = FALSE)
        {
            return $_SERVER["argv"];  //url ? 后面的那一串字符串
        }
        
        private function _dump_request($request, $index, $xss_clean)
        {
            if ( is_string($index) && $index != '' ) {
                if ( array_key_exists($index, $request) )
                    $request = $request[$index];
                else
                    return null;
            }

            if ( $xss_clean == TRUE )
                $request = $this->_xss_clean( $request );

            return $request;
        }

        private function _xss_clean($res)
        {
            if ( is_array($res) || is_object($res) ) {
                while (list($key, $val) = each($res) ) {
                    $res[$key] = $this->_xss_clean( $val );
                }

                return $res;
            }
            else if ($res) {
                $res = trim($res);
                //$naughty = 'alert|applet|audio|basefont|base|behavior|bgsound|blink|body|embed|';
                //$naughty .= 'expression|form|frameset|frame|head|html|ilayer|iframe|input|isindex|';
                //$naughty .= 'layer|link|meta|object|plaintext|style|script|textarea|title|video|xml|xss';
                $naughty = 'script|img|iframe|object';
                $res = preg_replace('/<(\/?)(' . $naughty . ')(.*?)>/i', '&lt;$1$2$3&gt;', $res);
                //$res = preg_replace('/<([\w\W]*?)>/i', '&lt;$1&gt;', $res);

                return $res;
            }

            return null;
        }
    }

?>