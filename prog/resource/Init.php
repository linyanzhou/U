<?php

    function initialize( $opts = array() )
    {
        $debug = $opts['debug'];

        if ( $debug == TRUE ) {
            ini_set('html_errors', 1);
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            Error_reporting(E_ALL & ~E_NOTICE);
            //Error_reporting(E_ALL);
        }

        $setup =  get_local_setup($opts);
        

        $authorize = $setup->get_authorize();
        
        $welcome   = $setup->get_welcome();
        
        $control   = $setup->get_controller_handler();

        $control->set_static_handler();

        if ( $authorize == TRUE ) {
            $authorize = $setup->get_controller_handler('authorize');
            $authorize->authorize();
        }
        $wel = null;
        if ( $welcome == TRUE ) {
            $welcome = $setup->get_controller_handler('welcomeinfo');
            $wel     = $welcome->get_welcome_info();
        }

        $control->set_welcome_info($wel);
        
        

        $control->callback();
    }

    function get_local_setup($opts)
    {
        $deploy_root = $opts['deploy_root'];

        //ResourceSetup
        $class = "prog/resource/ResourceSetup.php";
        $file  = "$deploy_root/$class";

        is_file($file)
            or exit("Failed to load ResourceSetup($class)!");
        require($file);

        $setup = new ResourceSetup($opts);

        is_object($setup)
            or exit('Failed to initialization ResourceSetup!');

       //Base   主要就是把那些属性传递给 Controller Library Model  
        $class = "prog/resource/Base.php";
        $file  = "$deploy_root/$class";

        is_file($file)
            or exit("Failed to load Base($class)!");
        require($file);

        //Controller
        $class = "prog/resource/Controller.php";
        $file  = "$deploy_root/$class";

        is_file($file)
            or exit("Failed to load Controller($class)!");
        require($file);

        //Library
        $class = "prog/resource/Library.php";
        $file  = "$deploy_root/$class";

        is_file($file)
            or exit("Failed to load Library($class)!");
        require($file);

        //Model
        $class = "prog/resource/Model.php";
        $file  = "$deploy_root/$class";

        is_file($file)
            or exit("Failed to load Model($class)!");
        require($file);

        return $setup;
    }

?>