<?php

    // toocle_auth
    $config['admin'] = array(
        'table'  => 'toocle_de_auth.admin',
        'fields' => array('email', 'intro', 'poster_id', 'post_ip')
    );

    $config['group'] = array(
        'table'  => 'toocle_de_auth.member_group',
        'fields' => array('name', 'intro', 'poster_id', 'post_ip')
    );

    $config['member'] = array(
        'table'  => 'toocle_de_auth.member',
        'fields' => array('login', 'email', 'intro', 'poster_id', 'post_ip','firstname','company','position','regional','address','tel','fax','mobile','im_type','im_account'),
        'select_position' => array('普通职员'=>11,'工程师'=>12,'总经理、董事长，CxO'=>13,'市场部经理'=>14,'销售部经理'=>15,'行政主管'=>16,'人事主管'=>17,'财务主管'=>18,'技术主管'=>19,'退休'=>20,'其他'=>99)
    );

    $config['member_to_group'] = array(
        'table'  => 'toocle_de_auth.member_to_group',
        'fields' => array('member_id', 'group_id', 'poster_id', 'post_ip')
    );

    $config['member_log'] = array(
        'table'  => 'toocle_de_tmp.member_log',
        'fields' => array(
            'domain', 'poster','post_ip'
        )
    );
    $config['type'] = array(
        'table'  => 'toocle_de_auth.action_type',
        'fields' => array('name', 'intro', 'open', 'rank', 'poster_id', 'post_ip')
    );

    $config['action'] = array(
        'table'  => 'toocle_de_auth.action',
        'fields' => array(
            'action_code', 'action_func', 'access_type', 'namespace', 'name', 'type_id',
            'in_menu', 'blank', 'link', 'intro', 'rank', 'poster_id', 'post_ip'
        )
    );

    $config['action_to_group'] = array(
        'table'  => 'toocle_de_auth.action_to_mgroup',
        'fields' => array('action_id', 'group_id', 'poster_id', 'post_ip')
    );

 

?>
