<?php
/**
 * Created by PhpStorm.
 * User: Anthony
 * Date: 2019/4/14
 * Time: 17:06
 */


return [

    //must use absolute path
    'logs_dir'   => '/path/of/the/logs',


    //php user name and group
    'server_user_name' => [
        'user'       => 'www',
        'user_group' => 'www',
    ],

    'record_request_data'   => false,

    'only_pull_master'  => true,

    'timezone'  => 'PRC',

    //set default_project
    'default_project'       => true,
    'default_project_name'  => 'default',

    //projects name and secret which set in github
    'project' => [
        'default'   => [
            'dir'       => '/home/www/default',
            'secret'    => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
        ],
//        'project1' => [
//            'dir'       => '/home/www/project1',
//            'secret'    => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
//        ],
//        'project2' => [
//            'dir'       => '/home/www/project2',
//            'secret'    => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
//        ],
    ],


];