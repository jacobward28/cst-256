<?php


namespace App\Services\Utility;

class MyLogger implements ILoggerService{
    
    private $logger;

    public function __construct($logger){
        $this->logger = $logger;
    }

    public function debug($message, $data=[]){
        $this->logger->debug($message, (count($data) ? $data : []));
    }
    
    public function warning($message, $data=[]){
        $this->logger->warning($message, (count($data) ? $data : []));
    }
    
    public function error($message, $data=[]){
        $this->logger->error($message, (count($data) ? $data : []));
    }
    
    public function info($message, $data=[]){
        $this->logger->info($message, (count($data) ? $data : []));
    }
}