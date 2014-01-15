<?php

    class C_Setjson extends Controller
    {		
    		 public function __construct($setup)
        {
            parent::__construct($setup); 

             $this->cache   = 60;
            $this->expires = 0;
        }
        
        public function do_category()
        {
            $inputs = self::$l_input->get();
            $db_category = $this->setup->get_model_handler('cate/category');
            
            $grade = isset($inputs['grade']) ? $inputs['grade'] : null;
            
            $len_max = $grade * 2;
            
            if ($len_max > 4)
                return;
            
            $opts = array(
                'dbh'    => 'default',         
                'len_max' => $len_max,
                'orderby' => 'cate_id'
            );
            $list = $db_category->get_list($opts, $this->cache);
            
            $htmls  = $this->_set_json_new($list, '');
            
            echo $htmls;
        }


 		
 	
        
        
        
        
        private function _set_json_new($list, $file)
        {
            foreach ($list as $l)
            {
                $cate_id = $l['cate_id'];
                $name    = $l['cate_name'];
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
        
    }

?>