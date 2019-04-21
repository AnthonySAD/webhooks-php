<?php
/**
 * Created by PhpStorm.
 * User: Anthony
 * Date: 2019/4/14
 * Time: 17:06
 */


return [

    //the logs directory
    //must use absolute path
    'logs_dir'   => '/path/of/this/webhooks/project/logs',

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
    'projects' => [
        'default'   => [
            'dir'       => '/home/www/default',
            'secret'    => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
        ],
//        'project1' => [
//            'dir'       => '/root/path/of/your/project',
//            'secret'    => 'the secret setting in your repository',
//        ],
//        'project2' => [
//            'dir'       => '/root/path/of/your/project',
//            'secret'    => 'the secret setting in your repository',
//        ],
    ],


];