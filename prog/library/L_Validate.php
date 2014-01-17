<?php

    class L_Validate extends Library
    {
        public function __construct( $setup, $opts = null )
        {
            parent::__construct($setup);
        }


        public function is_action($str)
        {
            return ( preg_match('/^[a-z0-9_]{3,20}$/i', $str) ) ? TRUE : FALSE;
        }
      /*
        public function is_validate_code($str)
        {   
            return (preg_match('/^[0-9]{5}$/i', $str) ) ? TRUE : FALSE;
        }
        
        public function is_login($str)
        {
            return ( preg_match('/^[a-z0-9_]{3,16}$/', $str) ) ? TRUE : FALSE;
        }

        public function is_email($email)
        {
            return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email) )
                ? FALSE : TRUE;
        }

        public function is_english($str)
        {
            if ( ! is_string($str) )
                return false;

            $strs = preg_split('//', $str);

            foreach ($strs as $s) {
                $ascii = ord($s);
                if ($ascii > 127 || $ascii < 0)
                    return false;
            }

            return true;
        }
        */
        
    }

?>