<?php

    class L_Memcached extends Library
    {
        public function __construct( $setup, $opts = null )
        {
            parent::__construct($setup);

            $this->_opts = $this->extend($opts, 'memcached');   //Library.phpÀï¼Ì³Ð¶øÀ´
            
            
          // print_r($this->_opts);
          //  exit;
            $this->_set_memcached();
        }
        
        
        
				private function _set_memcached()
        {
            if ( isset($this->_memcached) )
                return;

            $port = $this->_opts['port'];
            $servers = explode(',',$this->_opts['servers']);
 
            $memcache = new Memcache;
            foreach ($servers as $server) {
                $memcache->addServer($server, $port)
                    or exit('Could not connect memcache servers!');
            }
            $this->_memcached = $memcache;
        }



        public function set_cache($cache_id, $res, $cache)
        {
            if ($cache > 0)
                $this->_memcached->set($cache_id, $res, 0, $cache);
        }



        public function get_cache($item)
        {
            $cache_id  = md5($item);
            $cache_obj = $this->_memcached->get($cache_id);

            return array($cache_id, $cache_obj);
        }


        public function get_cache_by_id($cache_id)
        {
            $cache_obj = $this->_memcached->get($cache_id);

            return array($cache_id, $cache_obj);
        }
        
        
        
        public function delete_cache($cache_id)
        {            
                $this->_memcached->delete($cache_id);
        }
        
        
        
        public function flush_cache($cache_id)
        {            
                $this->_memcached->flush();
        }
        
        

    }

?>