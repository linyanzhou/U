<?php

    class Library extends Base
    {
        public function __construct($setup)
        {
            parent::__construct($setup);

            if ( isset($this->main_config['library']) )
                $this->Config = $this->main_config['library'];
        }


        protected function extend($opts, $lib)
        {
            is_array($opts)
                or $opts = array();

            $config = $this->Config[$lib];

            if ( is_array($config) ) {
                foreach ($config as $k=>$v) {
                    isset( $opts[$k] )
                        or $opts[$k] = $v;
                }
            }

            return $opts;
        }
    }

?>