<?php
   class C_Upload extends Controller
    {
        public function __construct($setup)
        {
            parent::__construct($setup);

            $this->cache   = 0;//memcache
            $this->expires = 0;//ä¯ÀÀÆ÷»º´æ
        }
        
           public function do_upload_product()
        {
        	  $inputs  = self::$l_input->request();   
         
        	  $fileElementName="product_img";
        	 
        	  $res=self::$l_upload->upload_file($fileElementName);
        	  $list['picname']=$res['path'];
        	  $list['img_error']=$res['error'];
		        $list= json_encode($list);
		        echo $list;  
        	      	
        }
        
        
        
      
       
      
      
    }
?>
