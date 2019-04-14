<?php
/**
 * Created by PhpStorm.
 * User: 31272
 * Date: 2019/4/14
 * Time: 17:14
 */

class Kernel
{
    private $userName;
    private $project;
    private $projectName;
    private $log;

    public function __construct($config)
    {
        if (!isset($_GET['project'])){
            return false;
        }

        $this->projectName = $_GET['project'];
        if (!isset($config['project'][$this->projectName])){
            return false;
        }
        $this->project = $config['project'][$this->projectName];
        $this->userName = $config['user_name'];

        $this->log = new Log($this->projectName);

        $this->log->writeRequest();
    }

    public function pull()
    {
        if (!$this->projectName){
            return false;
        }


        if (!isset($_SERVER["HTTP_X_HUB_SIGNATURE"])){
            $this->log->write('no signature');
            return false;
        }

        $signature = $_SERVER["HTTP_X_HUB_SIGNATURE"];
        $rawPost = file_get_contents("php://input");

        list($algo, $hash) = explode("=", $signature, 2);

        if ($hash !== hash_hmac($algo, $rawPost, $this->project['secret'])) {
            $this->log->write('invalid signature');
            return false;
        }

        $content = json_decode($rawPost, true);

        $branch = substr($content['ref'], 11);

        $log = 'user [ ' . $content['pusher']['name'] . ' ] pushed [ ' . count($content['commits']) . ' ] commit(s) to the branch [ ' . $branch . ' ], the last commit message is [ ' . $content['head_commit']['message'] . ' ], commit id is [ '. $content['head_commit']['id'] . ' ]';

        $this->log->write($log);

        if ($branch !== 'master'){
            $this->log->write('don\'t pull');
            return false;
        }

        $this->doPull();
        return true;
    }

    private function doPull()
    {
        $command = 'cd ' . $this->project['dir'];
        $command .= '&& unset GIT_DIR';
        $command .= '&& sudo /usr/bin/git pull origin master';
        $command .= '&& chown -R '.$this->userName->web_user.':'.$this->userName->web_usergroup.' '. $this->project['dir'];
        shell_exec($command);

        $this->log->write('pull success');

    }

}