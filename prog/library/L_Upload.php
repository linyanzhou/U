<?php

    class L_Upload extends Library
    {
        public function __construct( $setup, $opts = null )
        {
            parent::__construct($setup);

            $this->_opts = $this->extend($opts, 'upload');
        }


        public function upload($field = 'userfile', $output_file, $type = null)
        {
            if ( ! $this->_set_input_file_properties($field) )  {
                return FALSE;
            }

            if ( ! $this->_validate_input_file($type) ) {
                return FALSE;
            }

            if ( ! $this->_set_output_file_properties($output_file) )  {
                return FALSE;
            }

            if ( ! $this->_validate_output_file() ) {
                return FALSE;
            }

            if ( ! $this->_upload() ) {
                return FALSE;
            }

            if ( $type == 'image' ) {
                if ( ! $this->_zoom() ) {
                    return FALSE;
                }
            }

            return TRUE;
        }

        public function image_crop($input_file, $output_file, $x, $y, $w, $h, $width, $height)
        {
            if ($x < 0 || $y < 0 || $w <= 0 || $h <= 0) {
                $this->_error = 'crop_parameter_error';
                return FALSE;
            }

            if ( ! $this->_set_input_file_properties($input_file, FALSE) )  {
                return FALSE;
            }

            if ( ! $this->_set_output_file_properties($output_file) )  {
                return FALSE;
            }

            if ( ! $this->_validate_output_file() ) {
                return FALSE;
            }

            if ( ! $this->_crop($x, $y, $w, $h, $width, $height) ) {
                return FALSE;
            }

            if ( ! $this->_zoom() ) {
                return FALSE;
            }

            return TRUE;
        }

        public function get_format($filename)
        {
            $fmt = explode('.', $filename);

            return strtolower( end($fmt) );
        }

        public function get_error()
        {
            return $this->_error;
        }

        public function get_output_file_properties()
        {
            return array(
                'name'   => $this->_output_file_name,
                'path'   => $this->_output_file_path,
                'size'   => $this->_output_file_size,
                'type'   => $this->_output_file_type,
                'format' => $this->_output_file_format
            );
        }

        public function set_file_path($file)
        {
            $dirs = explode('/', $file);
            $dirs = array_map('trim', $dirs);
            array_pop($dirs);

            $this->_set_output_file_path($dirs);
        }

        //upload
        private function _set_input_file_properties($field, $upload = TRUE)
        {
            if ($upload) {
                if ( ! isset($_FILES[$field]) ) {
                    $this->_error = 'upload_no_file_selected';
                    return FALSE;
                }

                $file = $_FILES[$field];
                $this->_input_file_temp = $file['tmp_name'];
                $this->_input_file_name = $file['name'];
                $this->_input_file_size = $file['size'];
                $this->_input_file_type = preg_replace('/^(.+?);.*$/', '$1', $_FILES[$field]['type']);
                $this->_input_file_type = strtolower($this->_input_file_type);
                $this->_input_file_format = $this->get_format( $this->_input_file_name );
            }
            else {
                if ( ! is_file($field) ) {
                    $this->_error = 'upload_no_file_selected';
                    return FALSE;
                }

                $file = $field;
                $this->_input_file_temp = $file;
                $this->_input_file_name = $file;
                $this->_input_file_format = $this->get_format( $this->_input_file_name );
            }

            return TRUE;
        }

        private function _validate_input_file($type)
        {
            $mimes = $this->_get_mimes_types($this->_input_file_format);

            if ( $this->_input_file_size > $this->_opts['max_size'] ) {
                $this->_error = 'upload_invalid_filesize';
                return FALSE;
            }

            if ( $type == 'image' ) {
                if ( getimagesize($this->_input_file_temp) == FALSE ) {
                    $this->_error = 'upload_invalid_filetype';
                    return FALSE;
                }
            }

            if ( is_array($mimes) ) {
                if ( ! in_array($this->_input_file_type, $mimes, TRUE) ) {
                    $this->_error = 'upload_invalid_filetype';
                    return FALSE;
                }
            }
            else {
                if ( $this->_input_file_type != $mimes ) {
                    $this->_error = 'upload_invalid_filetype';
                    return FALSE;
                }
            }

            return TRUE;
        }

        //output
        private function _set_output_file_properties($file)
        {
            $dirs   = explode('/', $file);
            $dirs   = array_map('trim', $dirs);
            $name   = array_pop($dirs);
            $format = $this->_input_file_format;

            if ( ! $this->_set_output_file_path($dirs) )
                return FALSE;

            $this->_output_file_name   = $name . '.' . $format;
            $this->_output_file_path   = join('/', $dirs);
            $this->_output_file_size   = isset($this->_input_file_size) ? $this->_input_file_size : null;
            $this->_output_file_type   = isset($this->_input_file_type) ? $this->_input_file_type : null;
            $this->_output_file_format = $format;
            $this->_output_file        = "$this->_output_file_path/$this->_output_file_name";

            return TRUE;
        }

        private function _set_output_file_path($dirs)
        {
            $realdir = '';

            foreach ($dirs as $dir) {
                if ( $dir == '' )
                    continue;

                $realdir .= '/' . $dir;

                if ( ! is_dir($realdir) ) {
                   if ( ! mkdir($realdir) ) {
                      $this->_error = 'outputpath_not_writable';
                      return FALSE;
                   }
                    else{
                   `chmod 777 $realdir`;
                  }
                }
            }

            return TRUE;
        }

        private function _validate_output_file()
        {
            if ( $this->_input_file_format != $this->_output_file_format ) {
                $this->_error = 'upload_and_output_format_inconsistent';
                return FALSE;
            }

            return TRUE;
        }

        //upload
        private function _upload()
        {
            if ( ! move_uploaded_file( $this->_input_file_temp, $this->_output_file ) ) {
                $this->_error = 'upload_file_failed';
                return FALSE;
            }

            return TRUE;
        }

        private function _crop($x, $y, $w, $h, $width, $height)
        {
            // 读取源图片信息 //
            list($Width, $Height, $Type) = getimagesize($this->_input_file_temp);

            $width > 0
                or $width = $Width;
            $height > 0
                or $height = $Height;

            // 创建源图片 //
            switch ($Type) {
                case 1 :
                    $Img = imagecreatefromgif($this->_input_file_temp);
                    break;
                case 2 :
                    $Img = imagecreatefromjpeg($this->_input_file_temp);
                    break;
                case 3 :
                    $Img = imagecreatefrompng($this->_input_file_temp);
                    break;
            }

            $scale = max($Width/$width, $Height/$height);
            $x = $x * $scale;
            $y = $y * $scale;
            $w = $w * $scale;
            $h = $h * $scale;

            // 生成新图片 //
            $Image = imagecreatetruecolor($w, $h);
            //list($R, $G, $B) = array(255, 255, 255);
            //$White = imagecolorallocate($Img, $R, $G, $B);
            //imagefill($Image, 0, 0, $White);

            imagecopy($Image, $Img, 0, 0, $x, $y, $w, $h);

            // 输出到文件 //
            switch ($Type) {
                case 1 :
                    $rv = imagegif($Image, $this->_output_file);
                    break;
                case 2 :
                    $rv = imagejpeg($Image, $this->_output_file);
                    break;
                case 3 :
                    $rv = imagepng($Image, $this->_output_file);
                    break;
            }

            if (! $rv) {
                $this->_error = 'crop_image_failed';
                return FALSE;
            }

            return TRUE;
        }

        private function _zoom()
        {
////            $min_width  = $this->_opts['min_width'];
////            $min_height = $this->_opts['min_height'];
////            $max_width  = $this->_opts['max_width'];
////            $max_height = $this->_opts['max_height'];
////
////            if (($min_width > 0 && $min_height > 0) || ($max_width > 0 && $max_height > 0)) {
////                list($Width, $Height, $Type) = getimagesize($this->_output_file);
////
////                if ($Width < $min_width || $Height < $min_height) {
////                    $scale = max($min_width/$Width, $min_height/$Height);
////                    $w = $Width * $scale;
////                    $h = $Height * $scale;
////                }
////
////                if ($Width > $max_width || $Height > $max_height) {
////                    $scale = min($max_width/$Width, $max_height/$Height);
////                    $w = $Width * $scale;
////                    $h = $Height * $scale;
////                }
////
////                if ($w > 0 && $h > 0) {
////                    return TRUE;
////                }
////            }

            return TRUE;
        }

        private function _extend($opts)
        {
            is_array($opts)
                or $opts = array();

            ( isset( $opts['max_size'] ) && $opts['max_size'] > 0 )
                or $opts['max_size'] = $this->main_config['library']['upload']['max_size'];

            ( isset( $opts['min_width'] ) && $opts['min_width'] > 0 )
                or $opts['min_width'] = $this->main_config['library']['upload']['min_width'];

            ( isset( $opts['min_height'] ) && $opts['min_height'] > 0 )
                or $opts['min_height'] = $this->main_config['library']['upload']['min_height'];

            ( isset( $opts['max_width'] ) && $opts['max_width'] > 0 )
                or $opts['max_width'] = $this->main_config['library']['upload']['max_width'];

            ( isset( $opts['max_height'] ) && $opts['max_height'] > 0 )
                or $opts['max_height'] = $this->main_config['library']['upload']['max_height'];

            return $opts;
        }

        private function _get_mimes_types($format)
        {
            $mimes = array(
                'hqx'  =>  'application/mac-binhex40',
                'cpt'  =>  'application/mac-compactpro',
                'csv'  =>  array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel'),
                'bin'  =>  'application/macbinary',
                'dms'  =>  'application/octet-stream',
                'lha'  =>  'application/octet-stream',
                'lzh'  =>  'application/octet-stream',
                'exe'  =>  'application/octet-stream',
                'class'  =>  'application/octet-stream',
                'psd'  =>  'application/x-photoshop',
                'so'  =>  'application/octet-stream',
                'sea'  =>  'application/octet-stream',
                'dll'  =>  'application/octet-stream',
                'oda'  =>  'application/oda',
                'pdf'  =>  array('application/pdf', 'application/x-download'),
                'ai'  =>  'application/postscript',
                'eps'  =>  'application/postscript',
                'ps'  =>  'application/postscript',
                'smi'  =>  'application/smil',
                'smil'  =>  'application/smil',
                'mif'  =>  'application/vnd.mif',
                'xls'  =>  array('application/excel', 'application/vnd.ms-excel', 'application/msexcel'),
                'ppt'  =>  array('application/powerpoint', 'application/vnd.ms-powerpoint'),
                'wbxml'  =>  'application/wbxml',
                'wmlc'  =>  'application/wmlc',
                'dcr'  =>  'application/x-director',
                'dir'  =>  'application/x-director',
                'dxr'  =>  'application/x-director',
                'dvi'  =>  'application/x-dvi',
                'gtar'  =>  'application/x-gtar',
                'gz'  =>  'application/x-gzip',
                'php'  =>  'application/x-httpd-php',
                'php4'  =>  'application/x-httpd-php',
                'php3'  =>  'application/x-httpd-php',
                'phtml'  =>  'application/x-httpd-php',
                'phps'  =>  'application/x-httpd-php-source',
                'js'  =>  'application/x-javascript',
                'swf'  =>  'application/x-shockwave-flash',
                'sit'  =>  'application/x-stuffit',
                'tar'  =>  'application/x-tar',
                'tgz'  =>  'application/x-tar',
                'xhtml'  =>  'application/xhtml+xml',
                'xht'  =>  'application/xhtml+xml',
                'zip'  =>  array('application/x-zip', 'application/zip', 'application/x-zip-compressed'),
                'mid'  =>  'audio/midi',
                'midi'  =>  'audio/midi',
                'mpga'  =>  'audio/mpeg',
                'mp2'  =>  'audio/mpeg',
                'mp3'  =>  array('audio/mpeg', 'audio/mpg'),
                'aif'  =>  'audio/x-aiff',
                'aiff'  =>  'audio/x-aiff',
                'aifc'  =>  'audio/x-aiff',
                'ram'  =>  'audio/x-pn-realaudio',
                'rm'  =>  'audio/x-pn-realaudio',
                'rpm'  =>  'audio/x-pn-realaudio-plugin',
                'ra'  =>  'audio/x-realaudio',
                'rv'  =>  'video/vnd.rn-realvideo',
                'wav'  =>  'audio/x-wav',
                'bmp'  =>  'image/bmp',
                'gif'  =>  'image/gif',
                'jpeg'  =>  array('image/jpeg', 'image/pjpeg'),
                'jpg'  =>  array('image/jpeg', 'image/pjpeg'),
                'jpe'  =>  array('image/jpeg', 'image/pjpeg'),
                'png'  =>  array('image/png',  'image/x-png'),
                'tiff'  =>  'image/tiff',
                'tif'  =>  'image/tiff',
                'css'  =>  'text/css',
                'html'  =>  'text/html',
                'htm'  =>  'text/html',
                'shtml'  =>  'text/html',
                'txt'  =>  'text/plain',
                'text'  =>  'text/plain',
                'log'  =>  array('text/plain', 'text/x-log'),
                'rtx'  =>  'text/richtext',
                'rtf'  =>  'text/rtf',
                'xml'  =>  'text/xml',
                'xsl'  =>  'text/xml',
                'mpeg'  =>  'video/mpeg',
                'mpg'  =>  'video/mpeg',
                'mpe'  =>  'video/mpeg',
                'qt'  =>  'video/quicktime',
                'mov'  =>  'video/quicktime',
                'avi'  =>  'video/x-msvideo',
                'movie'  =>  'video/x-sgi-movie',
                'doc'  =>  'application/msword',
                'docx'  =>  'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'xlsx'  =>  'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'word'  =>  array('application/msword', 'application/octet-stream'),
                'xl'  =>  'application/excel',
                'eml'  =>  'message/rfc822'
            );

            return $mimes[$format];
        }
    }

?>