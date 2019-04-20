<?php
/**
 * Created by PhpStorm.
 * User: Anthony
 * Date: 2019/4/14
 * Time: 17:06
 */


return [

    //php user name and group
    'server_user_name' => [
        'user'       => 'www',
        'user_group' => 'www',
    ],

    //set default_project
    'default_project' => false,
    'default_project_name'  => 'default',

    //projects name and secret which set in github
    'project' => [
        'default' => [
            'dir'       => '/home/www/default',
            'secret'    => '123456',
        ],
        'project1' => [
            'dir'       => '/home/www/api',
            'secret'    => '123456',
        ],
        'project2' => [
            'dir'       => '/home/www/web',
            'secret'    => '123456',
        ],
    ],

    'record_request_data' => true,

    'only_pull_master' => true,

    'logs_dir'   => '../logs',

    'timezone'   => 'PRC',

];