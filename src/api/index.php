<?php
namespace iboxs\meilisearch\api;

use iboxs\basic\Basic;
use iboxs\meilisearch\lib\BaseApi;

class index extends BaseApi{
    /**
     * 创建索引
     * @param string $uid 请求索引的 uid
     * @param string|null $primaryKey 请求索引的`主键`
     * @return
     */
    public function create(string $uid,string|null $primaryKey=null) {
        $url='indexes';
        $ret=$this->postJson($url,array_filter([
            'uid'=>$uid,
            'primaryKey'=>$primaryKey
        ]));
        return $ret;
    }
}
