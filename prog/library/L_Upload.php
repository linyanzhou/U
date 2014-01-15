<?php

    class L_Upload extends Library
    {
        public function __construct( $setup, $opts = null )
        {
            parent::__construct($setup);

            $this->_opts = $this->extend($opts, 'upload');
            $this->max_size=$this->_opts['max_size'];
        }

			function upload_file($fileElementName) { 
			$this->upload_error = $_FILES [$fileElementName] ['error'];
			$this->upload_name = $_FILES [$fileElementName] ["name"]; // 取得上传文件名
			$this->upload_filetype = $_FILES [$fileElementName] ["type"] ;			 
			$this->savePath=$_SERVER ["DOCUMENT_ROOT"] . "U/Upload/images/";
			 
		 
			$this->subpath = date ("Y/m/d/");		
			$this->upload_tmp_address = $_FILES [$fileElementName] ["tmp_name"]; // 取得临时地址
			$this->file_type = array (
					"image/gif",
					"image/pjpeg",
					"image/jpeg" 
			); // 允许上传文件的类型
			$this->upload_file_size = $_FILES [$fileElementName] ["size"]; // 上传文件的大小                                                        // $res['name'][]=$this->upload_name;
			if (in_array ( $this->upload_filetype, $this->file_type )) {
				
				if ($this->upload_file_size < $this->max_size) {
					$res ['name']= $this->upload_server_name;	
					$path=array();		
				  $path=explode('/',$this->subpath);
						for($i=0;$i< 3;$i++){
							$this->savePath=$this->savePath.$path[$i]."/";
					    if(is_dir($this->savePath)){   					   
					    continue;
							}else{
																							
							mkdir($this->savePath,0777);
									
							}
						}
						
						
				$ext=strstr($_FILES [$fileElementName] ["name"],".");
				$this->file_server_address=	$this->savePath.uniqid().$ext;	
			
				$str=strstr($this->file_server_address,'images/');	
				$this->upload_server_name=str_replace('images/','',$str);	
				
			    if (move_uploaded_file ( $this->upload_tmp_address, $this->file_server_address )) {	
					$res ['path'] =$this->upload_server_name;
				
					}
				} else {
				
				 $res ['error'] = "picture is too big";
				}
			} else {
				
			   $res ['error'] = "no support for this type";
			}
	
		
		return $res;
	}


    }

?>