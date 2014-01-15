<?php

    // toocle_auth
    $config['admin'] = array(
        'table'  => 'u_auth.admin',
        'fields' => array('email', 'intro', 'poster_id')
    );

    $config['group'] = array(
        'table'  => 'u_auth.member_group',
        'fields' => array('name', 'intro', 'poster_id')
    );

    $config['member'] = array(
        'table'  => 'u_auth.member',
        'fields' => array('login', 'email', 'intro', 'poster_id', 'company','address','tel','fax',),
         );

    $config['member_to_group'] = array(
        'table'  => 'u_auth.member_to_group',
        'fields' => array('member_id', 'group_id', 'poster_id')
    );

   
    $config['type'] = array(
        'table'  => 'u_auth.action_type',
        'fields' => array('name', 'intro', 'open', 'poster_id')
    );

    $config['action'] = array(
        'table'  => 'u_auth.action',
        'fields' => array(
            'action_code', 'action_func', 'access_type', 'namespace', 'name', 'type_id','poster_id'
        )
    );

    $config['action_to_group'] = array(
        'table'  => 'u_auth.action_to_mgroup',
        'fields' => array('action_id', 'group_id', 'poster_id')
    );

 

?>
