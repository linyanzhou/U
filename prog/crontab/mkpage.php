<?php

    function main()
    {
        $debug     = False;
        $authorize = False;
        $domain    = 'crontab';
        $function  = isset($_REQUEST['f']) ? $_REQUEST['f'] : null;
        $action    = "mkpage";
        $welcome   = "false";     
        
        $deploy_root  = 'E:/Php/wamp/www/U';

        $class = "prog/resource/Init.php";
        $file  = "$deploy_root/$class";

        is_file($file) 
            or exit ("Failed to load Initialization($class)!");
        require($file);

        $opts = array (
            'debug'     => $debug,
            'authorize' => $authorize,
            'function'  => $function,
            'action'    => $action,
            'domain'    => $domain,
            'welcome'   => $welcome,
            'deploy_root' => $deploy_root
        );

        initialize($opts);
    }


    main();

?>