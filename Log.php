<?php
/**
 * Created by PhpStorm.
 * User: 31272
 * Date: 2019/4/14
 * Time: 17:23
 */

class Log
{


    private $file;

    public function __construct($projectName)
    {
        if (!file_exists('../logs')){
            mkdir ('../logs',0777,true);
        }

        $this->file = fopen('../logs/ ' . $projectName . '.log', "a+");
    }

    public function write( $data )
    {
        if (!is_string($data)){
            $data = json_encode($data);
        }

        fwrite($this->file, $data . PHP_EOL);

    }

    public function endLine()
    {
        $this->write(PHP_EOL . '==========================================' . PHP_EOL);
    }

    public function writeRequest()
    {
        $this->write('Request on ['.date("Y-m-d H:i:s").'] from ['.$_SERVER['REMOTE_ADDR'].']');
    }


    public function __destruct()
    {
        $this->endLine();
        fclose($this->file);
    }

}