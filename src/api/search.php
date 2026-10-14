<?php
namespace iboxs\meilisearch\api;

use iboxs\basic\Basic;
use iboxs\meilisearch\lib\BaseApi;

class search extends BaseApi{
    /**
     * 执行搜索
     */
    public function search($indexID,$query){
        $url='indexes/' . $indexID . '/search';
        $ret=$this->postJson($url,array_filter($query));
        return $ret;
    }
}
