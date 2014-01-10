<?php

    class L_Pdodb extends Library
    {
        public function __construct( $setup, $opts = null )
        {
            parent::__construct($setup);

            $this->_opts = $this->extend($opts, 'adodb');
        }


        public function get_connect($dbh)
        {
            $opts = isset($this->_opts[$dbh]) ? $this->_opts[$dbh] : null;
            is_array($opts)
                or $opts = $this->_opts['default'];

            $dbh = null;
            $driver = $opts['driver'];
            $db     = $opts['db'];
            $host   = $opts['host'];
            $names  = $opts['names'];
            $uname  = $opts['uname'];
            $pword  = $opts['pword'];
            $dsn    = "$driver:host=$host;dbname=$db";

            ($driver && $host && $uname)
                or exit('Driver, host and username must be provide!');

            try {
                $dbh = new PDO($dsn, $uname, $pword);
            }
            catch (PDOException $e) {
                error_log($e->getMessage(), 0);
                //exit($e->getMessage());
                exit("Access denied!");
            }

            $dbh->exec("set NAMES $names");
            return $dbh;
        }

    }

?>