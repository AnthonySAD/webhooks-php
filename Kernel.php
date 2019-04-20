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
        date_default_timezone_set($config['timezone']);

        $this->initProjectName($config['default_project'], $config['default_project_name']);

        $this->initLog($config['logs_dir']);

        $this->initProject($config['project']);

        $this->initUserName($config['server_user_name']);

        $this->runServer($config['only_pull_master'], $config['record_request_data']);
    }

    private function initLog($dir)
    {
        $this->log = new Log($this->projectName, $dir);
        $this->log->writeRequest();
    }

    private function initProjectName($ifDefault, $name)
    {

        if (isset($_GET['project'])){
            $this->projectName = $_GET['project'];
            return true;
        }

        if ($ifDefault){
            $this->projectName = $name;
            return true;
        }

    }

    private function initProject($projectArr)
    {
        if (!$this->projectName){
            $this->log->writeError('no project name');
            die();
        }

        if (!isset($projectArr[$this->projectName])){
            $this->log->writeError('wrong project name [ '. $this->projectName . ' ]');
            die();
        }

        $this->project = $projectArr[$this->projectName];
    }

    private function initUserName($userName)
    {
        $this->userName = $userName;
    }

    public function checkSignature($rawPost)
    {
        if (!isset($_SERVER['HTTP_X_HUB_SIGNATURE'])){
            $this->log->write('Error: no signature');
            die();
        }

        $signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];

        list($algo, $hash) = explode('=', $signature, 2);

        if ($hash !== hash_hmac($algo, $rawPost, $this->project['secret'])) {
            $this->log->write('Error: invalid signature');
            die();
        }
    }


    public function runServer($onlyPullMaster, $ifLog)
    {
        $rawPost = file_get_contents('php://input');


        $this->checkSignature($rawPost);

        $content = json_decode($rawPost, true);

        if ($ifLog){
            $this->log->write('data: ');
            $this->log->write($content);
        }

        $branch = substr($content['ref'], 11);

        $content = 'user [ ' . $content['pusher']['name'] . ' ] pushed [ ' . count($content['commits']) . ' ] commit(s) to the branch [ ' . $branch . ' ], the last commit message is [ ' . $content['head_commit']['message'] . ' ], commit id is [ '. $content['head_commit']['id'] . ' ]';

        $this->log->write($content);

        if ($onlyPullMaster && $branch !== 'master'){
            $this->log->write('don\'t pull the branch [' . $branch . ' ]');
            die();
        }

        $this->doPull();

        $this->log->write('pull the branch [' . $branch . ' ] successfully');
    }

    private function doPull()
    {
        $command = 'cd ' . $this->project['dir'];
        $command .= '&& unset GIT_DIR';
        $command .= '&& sudo /usr/bin/git pull origin master';
        $command .= '&& chown -R '.$this->userName['user'].':'.$this->userName['web_usergroup'].' '. $this->project['dir'];

        shell_exec($command);
    }

}