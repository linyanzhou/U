<?php

    $config['controller'] = array(
        'cache'      => 0,
        'expires'    => 0,
        'namespace'  => 'toocle',
        'url_base'   => 'http://de.toocle.com',
        'url_ui'     => 'http://ui.de.toocle.com',
        'url_img'    => 'http://img.de.toocle.com',
        'url_img_my' => 'http://my.de.toocle.com',
        'url_upload' => 'http://upload.de.toocle.com',
        'url_my' => 'http://my.de.toocle.com',
        'url_intl_my' => 'http://my.intl.toocle.com',
        'url_intl_my_en' => 'http://my.en.toocle.com',
        'url_intl_my_jp' => 'http://my.jp.toocle.com',
        'url_intl_my_kr' => 'http://my.kr.toocle.com',
        'url_intl_my_ru' => 'http://my.ru.toocle.com',
        'url_intl_my_vn' => 'http://my.vn.toocle.com',
        'url_intl_my_de' => 'http://my.de.toocle.com',
        'url_intl_api' => 'http://api.de.toocle.com', 
        'cookie_expire' => 0,
        'cookie_path'   => '/',
        'cookie_domain' => '.toocle.com'
    );

    $config['model'] = array(
        'page_record' => 20,
        'page_width ' => 10
    );

    $config['library'] = array(
        'adodb' => array(
            'default' => array(
                'driver' => 'mysql',
                'db'     => 'test',
                'host'   => 'localhost',
                'names'  => 'UTF8',
                'uname'  => 'root',
                'pword'  => ''
            ),

            'list' => array(
                'driver' => 'mysql',
                'db'     => 'test',
                'host'   => 'localhost',
                'names'  => 'UTF8',
                'uname'  => 'root',
                'pword'  => ''
            ),
            
            'show' => array(
                'driver' => 'mysql',
                'db'     => 'test',
                'host'   => 'localhost',
                'names'  => 'UTF8',
                'uname'  => 'root',
                'pword'  => ''
            )
        ),

        'log4php' => array(
            'log4sql' => 'log4php/log4sql.properties',
            'log4php' => 'log4php/log4php.properties'
        ),

        'memcached' => array(
            'port' => '11211',
            'servers' => 'localhost'
        ),
        
        'blacklist' => array(
            'fetch_uri' => 'http://api.intl.toocle.com/mkpage/blacklist',
            'fetch_local' => 'config/blacklist'
        ),
        
        'pscws' => array(
            'charset'     => 'UTF-8',
            'dict_fpath'  => 'dict.xdb',
            'ignore_mark' => TRUE,
            'autodis'     => TRUE,
            'debug'       => FALSE,
            'statistics'  => FALSE
        ),

        'upload' => array(
            'max_size'   => 512*1024,
            'min_width'  => 200,
            'min_height' => 200,
            'max_width'  => 800,
            'max_height' => 800
        ),

        'sendmail' => array(
            'server' => '222.73.238.131',        //SMTP服务器
            'port'   => 25,                 //SMTP服务器端口  
            'auth'   => FALSE,               //是否使用身份验证
            'user'   => '',            //SMTP服务器的用户帐号
            'pass'   => '',           //SMTP服务器的用户密码
            'debug'  => FALSE,
            'relay_host' => '222.73.238.131',
            'time_out'   => 30,
            'log_file'   => '',
            'sock'       => FALSE
        ),

        'sendsms' => array(
            'server' => '122.224.186.30',        //SMS服务器
            'port'   => 8008,                 //SMS服务器端口  
            'sender'   => '240876',                       
            'debug'  => FALSE,           
            'time_out'   => 30,
            'log_file'   => '/var/www/html/toocle/intl/logs/log4php/log4php.log'
        ),
        
        'session' => array(
            'module' => '',//db
            'domain' => '.toocle.com',
            'path'   => '/',
            'expire' => '36000',

            'db' => array(
                'driver' => 'mysql',
                'db'     => 'toocle_intl_tmp',
                'host'   => '172.20.11.33',
                'names'  => 'UTF8',
                'uname'  => 'toocle_intl',
                'pword'  => '12345',
                'table'  => 'toocle_intl_tmp.session_db'
            )
        )
    );

?>
