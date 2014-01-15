<?php
    function main()
    {
        $debug     = False;
        $authorize = False;
        $domain    = 'upload';
        $function  = isset($_REQUEST['f']) ? strip_tags($_REQUEST['f']) : null;
        $action    = isset($_REQUEST['_a']) ? strip_tags($_REQUEST['_a']) : null;
        
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
            'deploy_root' => $deploy_root
        );

        initialize($opts);
    }


    main();
?>
