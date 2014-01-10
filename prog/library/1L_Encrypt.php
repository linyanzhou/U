<?php

    class L_Encrypt extends Library
    {
        public function __construct( $setup, $opts = null )
        {
            parent::__construct($setup);

            $this->_options = $this->_extend($opts);
        }


        private function _extend($opts)
        {
            is_array($opts)
                or $opts = array();

            isset( $opts['key'] )
                or $opts['key'] = $this->_config['encrypt']['key'];

            return $opts;
        }

        public function encrypt($str, $key = null)
        {
            $key
                or $key = $this->_options['key'];

            srand((double) microtime() * 1000000);
            $encrypt_key = md5(rand(0, 32000));
            $ctr = 0;
            $tmp = '';

            for ($i = 0; $i < strlen($str); $i++) {
                if ($ctr == strlen($encrypt_key))
                    $ctr = 0;
                $tmp .= substr($encrypt_key, $ctr, 1) .
                 (substr($str, $i, 1) ^ substr($encrypt_key, $ctr, 1));
                $ctr++;
            }

            return base64_encode($this->_keyED($tmp, $key));
        }

        public function decrypt($str, $key = null)
        {
            $key
                or $key = $this->_options['key'];

            $str = base64_decode($str);
            $str = $this->_keyED($str, $key);
            $tmp = '';

            for ($i = 0; $i < strlen($str); $i++) {
                $md5 = substr($str, $i, 1);
                $i++;
                $tmp .= (substr($str, $i, 1) ^ $md5);
            }

            return $tmp;
        }

        private function _keyED($str, $encrypt_key)
        {
            $encrypt_key = md5($encrypt_key);
            $ctr = 0;
            $tmp = '';

            for ($i = 0; $i < strlen($str); $i++) {
                if ($ctr == strlen($encrypt_key))
                    $ctr = 0;
                $tmp .= substr($str, $i, 1) ^ substr($encrypt_key, $ctr, 1);
                $ctr++;
            }

            return $tmp;
        }

//////        //Encrypt Encode DES
//////        function encrypt($str, $key = null)
//////        {
//////            $key
//////                or $key = $this->_options['key'];
//////
//////            $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
//////
//////            $str = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $str, MCRYPT_MODE_ECB, $iv);
//////
//////            return base64_encode($str);
//////        }
//////
//////        //Decrypt Decode DES
//////        function decrypt($str, $key = null)
//////        {
//////            $key
//////                or $key = $this->_options['key'];
//////
//////            $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
//////
//////            $str = base64_decode($str);
//////
//////            return mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $str, MCRYPT_MODE_ECB, $iv);
//////        }

    }

?>