<?php
/**
 * Created by PhpStorm.
 * User: 31272
 * Date: 2019/4/14
 * Time: 17:23
 */

class Log
{

    private $logName;
    private $content = '';
    private $dir;


    public function __construct($logName, $dir)
    {
        $this->logName = $logName;
        $this->dir = rtrim($dir, '/') . '/';
    }

    public function write( $data )
    {
        if (!is_string($data)){
            $data = json_encode($data);
        }
        $this->content .= $data . PHP_EOL;
    }

    public function writeError( $data )
    {
        $this->write($data);
        $this->logName = 'error';
    }

    public function endLine()
    {
        $this->write(PHP_EOL . PHP_EOL);
    }

    public function writeRequest()
    {
        $this->write('-----Request on ['.date("Y-m-d H:i:s").'] from ['.$_SERVER['REMOTE_ADDR'].']-----');
    }


    public function __destruct()
    {
        if (!file_exists($this->dir)){
            mkdir ($this->dir,0777,true);
        }

        $filePath = $this->dir . $this->logName . '.log';

        $file = fopen($filePath, 'a+');
        $this->endLine();
        fwrite($file, $this->content);
        fclose($file);
    }

}