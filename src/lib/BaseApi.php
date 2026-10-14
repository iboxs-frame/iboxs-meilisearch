<?php
namespace iboxs\meilisearch\lib;

use iboxs\basic\Basic;

class BaseApi{
    public function __construct(
        protected $masterKey,
        protected $host,
        protected $apiKey
    ){

    }

    public function postJson($url,$data){
        $ret=Basic::Http($url)->setHeader([
            'Authorization: Bearer '. $this->apiKey['adminKey']
        ])->postJson(array_filter($data));
        return $ret;
    }

    public function patchJson($url,$data){
        $ret=Basic::Http($this->host."/".$url)->setHeader([
            'Authorization: Bearer '. $this->apiKey['adminKey']
        ])->patchJson(array_filter($data));
        return $ret;
    }
}
