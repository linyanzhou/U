<?php

    class L_String extends Library
    {
        public function __construct( $setup, $opts = null )
        {
            parent::__construct($setup);
        }


        public function substring($str, $length, $suffix = 0 )
        {
            $substr = '';

            if ( strlen($str) > $length ) {
                $isu8 = preg_match("/^utf-8/i", $this->charset) ? true : false; 
                $isu8
                    or $str = iconv($this->charset, 'utf-8', $str);

                for ($i=0, $j=0; $j<$length;) {
                    $s1  = substr($str, $i++, 1);
                    $ord = ord($s1);
                    $j++;

                    if ( $ord <= 127 ) {
                        $substr .= $s1;
                    }
                    else {
                        if (++$j > $length)
                            break;

                        $s2 = substr($str, $i++, 1);
                        $substr .= $s1 . $s2;

                        // utf8字符第一个字节取值在 192 ～ 255 之间 //
                        if ( ($ord & 192) == 192 )
                            $substr .= substr($str, $i++, 1);
                    }
                }

                $isu8
                    or $substr = iconv('utf-8', $this->_charset, $substr);

                $substr = $substr . ($suffix === 0 ? '' : '...');
            }
            else {
                $substr = $str;
            }

            return $substr;
        } //iconv_substr

        public function highlight($str, $terms)
        {
            if ( ! is_string($terms) )
                return $str;

            $terms = trim($terms);

            if ( $terms != '' ) {
                $TERMS = preg_split('/\s+/', $terms);
                foreach ($TERMS as $value) {
                    $str = $this->_replace($str, $value);
                }
            }

            return $str;
        }

        public function replace_html($str)
        {
            $farr = array(
                "/<(\/?)([^>]*?)>/isU",
                "/\s+/U"
            );

            $tarr = array(
                "",
                " "
            );

            return preg_replace($farr, $tarr, $str);
        }

        private function _replace($mainstring, $substring) 
        {
            if (! $mainstring || ! $substring)
                return $mainstring;

            $pos = true;
            $temp = '';
            while ($pos !== false) {
                $pos = stripos($mainstring, $substring, 0);
                if ($pos === false) {
                    $temp = $temp.substr($mainstring,0,strlen($mainstring));
                }
                else {
                    $tmp = substr($mainstring,$pos+strlen($substring),strlen($mainstring));
                    if (stripos($tmp,">",0) === false || stripos($tmp,"<",0) < stripos($tmp,">",0)){
                        $temp = $temp.substr($mainstring,0,$pos)."<font style='color:red'>".substr($mainstring,$pos,strlen($substring))."</font>";
                    }
                    else {
                        $temp = $temp.substr($mainstring,0,$pos+strlen($substring));
                    }
                    $mainstring = substr($mainstring,$pos+strlen($substring),strlen($mainstring));
                }
            };

            return $temp;
        }
        
        //解析xml函数
        public function getXmlData ($strXml) {
	             $pos = strpos($strXml, 'xml');
	             if ($pos) {
	                 $xmlCode=simplexml_load_string($strXml,'SimpleXMLElement', LIBXML_NOCDATA);
	              	 $arrayCode= $this->get_object_vars_final($xmlCode);
	              	 return $arrayCode ;
	             } else {
		               return '';
	             }
         }
	
        private function get_object_vars_final($obj){
	              if(is_object($obj)){
		               $obj=get_object_vars($obj);
	              }
	              if(is_array($obj)){
		                foreach ($obj as $key=>$value){
			                   $obj[$key]=$this->get_object_vars_final($value);
		                }
	              }
	              return $obj;
         }

        public function arrayToXml($data,  $xml=null)
        {
               $rootNodeName = 'root';
               $encoding   = $this->charset;
               // turn off compatibility mode as simple xml throws a wobbly if you don't.
               if (ini_get('zend.ze1_compatibility_mode') == 1)
               {
                   ini_set ('zend.ze1_compatibility_mode', 0);
               }        
               if ($xml == null)
               {
                   $xml = simplexml_load_string("<?xml version='1.0' encoding='$encoding'?><$rootNodeName/>");
               }        
               // loop through the data passed in.
               foreach($data as $key => $value)
               {
                   // no numeric keys in our xml please!
                   if (is_numeric($key))
                   {
                       // make string key...
                       $key = "unknownNode_". (string) $key;
                   }            
                   // replace anything not alpha numeric
                   $key = preg_replace('/[^a-z]/i', '', $key);            
                   // if there is another array found recrusively call this function
                   if (is_array($value))
                   {
                       $node = $xml->addChild($key);
                       // recrusive call.
                       $this->arrayToXml($value, $node);
                   }
                   else 
                   {
                      // add single node.
                       $value = htmlspecialchars($value);
                       $xml->addChild($key,$value);
                   }
            
               }
               // pass back as string. or simple xml object if you want!
               return $xml->asXML();
           }


    }

?>