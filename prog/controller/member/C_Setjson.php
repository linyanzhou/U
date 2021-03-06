<?php

    class C_Setjson extends Controller
    {		
    		 public function __construct($setup)
        {
            parent::__construct($setup); 

             $this->cache   = 3600*10;
            $this->expires = 2;
        }
        
        public function do_category()
        {
            $inputs = self::$l_input->get();
            $db_category = $this->setup->get_model_handler('cate/category');
            // var_dump($db_category);
            $grade = isset($inputs['grade']) ? $inputs['grade'] : null;
            
            $len_max = $grade * 2;
            
            if ($len_max > 8)
                return;
            
            $opts = array(
                'status'  => 1,
                'len_max' => $len_max,
                'orderby' => 'cat_id'
            );
            $list = $db_category->get_list($opts, $this->cache);
            
            $htmls  = $this->_set_json($list, '');
            
            echo $htmls;
        }
        

        public function do_category_de()
        {
            $inputs = self::$l_input->get();
            $db_category = $this->setup->get_model_handler('cate/category_de');
           // var_dump($db_category);
            $grade = isset($inputs['grade']) ? $inputs['grade'] : null;
            
            $len_max = $grade * 2;
            
            if ($len_max > 4)
                return;
            
            $opts = array(
               // 'status'  => 1,
                'len_max' => $len_max,
                'orderby' => 'cat_id'
            );
            $list = $db_category->get_list($opts, $this->cache);
            
            $htmls  = $this->_set_json_new($list, '');
            
            echo $htmls;
        }
        
        
        
        public function do_category_de_buy()
        {
            $inputs = self::$l_input->get();
            $db_category = $this->setup->get_model_handler('cate/category_de_buy');
           // var_dump($db_category);
            $grade = isset($inputs['grade']) ? $inputs['grade'] : null;
            
            $len_max = $grade * 2;
            
            if ($len_max > 4)
                return;
            
            $opts = array(
               // 'status'  => 1,
                'len_max' => $len_max,
                'orderby' => 'cat_id'
            );
            $list = $db_category->get_list($opts, $this->cache);
            
            $htmls  = $this->_set_json_new($list, '');
            
            echo $htmls;
        }
        
        public function do_regional()
        {
            $inputs = self::$l_input->get();
            $db_regional = $this->setup->get_model_handler('cate/regional');
            
            $grade = isset($inputs['grade']) ? $inputs['grade'] : null;
            
            $len_max = $grade * 2;
            
            if ($len_max > 4)
                return;
            
            $opts = array(
                'status'  => 1,
                'len_max' => $len_max,
                'orderby' => 'cate_id'
            );
            $list = $db_regional->get_list($opts, $this->cache);
            
            $htmls  = $this->_set_json($list, '');
            
            echo $htmls;
        }
        
        
        
        
        public function do_regional_toocle()
        {
            $inputs = self::$l_input->get();
            $db_regional_toocle = $this->setup->get_model_handler('cate/regional_toocle');
            
            $grade = isset($inputs['grade']) ? $inputs['grade'] : null;
            
            $len_max = $grade * 2;
            
            if ($len_max > 4)
                return;
            
            $opts = array(
          //      'status'  => 1,
                'len_max' => $len_max,
                'orderby' => 'cat_id'
            );
            $list = $db_regional_toocle->get_list($opts, $this->cache);
            
            $htmls  = $this->_set_json_new($list, '');
            
            echo $htmls;
        }
        public function do_category_v()
        {
            $inputs = self::$l_input->get();
            $db_regional = $this->setup->get_model_handler('cate/category_v');
            
            $grade = isset($inputs['grade']) ? $inputs['grade'] : null;
            
            $len_max = $grade * 2;
            
            if ($len_max > 4)
                return;
            
            $opts = array(
                'status'  => 1,
                'len_max' => $len_max,
                'orderby' => 'cate_id'
            );
            $list = $db_regional->get_list($opts, $this->cache);
            
            $htmls  = $this->_set_json($list, '');
            
            echo $htmls;
        }
        
        private function _set_json($list, $file)
        {
            foreach ($list as $l)
            {
                $cate_id = $l['cate_id'];
                $name    = $l['name'];
                $url     = isset($l['url']) ? $l['url'] : "";
                $leaf    = isset($l['leaf']) ? $l['leaf'] : "";
                $level   = strlen($cate_id)/2;

                if ( ! is_numeric($cate_id) )
                    continue;

                $cate = substr($cate_id, 0, ($level-1)*2);
                $name = preg_replace('/(.*?)\/([^\/]*)$/', '$2', $name);
                $name = trim($name);
                $url  = trim($url);
                $leaf = trim($leaf);

                $item = array(
                    'id'   => $cate_id,
                    'name' => $name
                );

                if ($leaf)
                    $item['leaf'] = $leaf;

                if ($url)
                    $item['url'] = $url;
                    
                $categorys['items'.$cate][] = $item;
            }

            $htmls  = json_encode($categorys);
            
            return $htmls;
        }
        
        
        private function _set_json_new($list, $file)
        {
            foreach ($list as $l)
            {
                $cate_id = $l['cat_id'];
                $name    = $l['category'];
                $url     = isset($l['url']) ? $l['url'] : "";
                $leaf    = isset($l['leaf']) ? $l['leaf'] : "";
                $level   = strlen($cate_id)/2;

                

                $cate = substr($cate_id, 0, ($level-1)*2);
                $name = preg_replace('/(.*?)\/([^\/]*)$/', '$2', $name);
                $name = trim($name);
                $url  = trim($url);
                $leaf = trim($leaf);

                $item = array(
                    'id'   => $cate_id,
                    'name' => $name
                );

                if ($leaf)
                    $item['leaf'] = $leaf;

                if ($url)
                    $item['url'] = $url;
                    
                $categorys['items'.$cate][] = $item;
            }

            $htmls  = json_encode($categorys);
            
            return $htmls;
        }
        
    }

?>