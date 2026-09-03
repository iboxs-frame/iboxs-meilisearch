<?php
namespace iboxs\meilisearch\api;

use iboxs\basic\Basic;
use iboxs\meilisearch\lib\BaseApi;

class documents extends BaseApi{
    /**
     * 添加或替换文档
     * @param string $indexID 索引UID
     * @param array $documents 文档数组
     * @return mixed
     */
    public function addOrReplace($indexID,array $documents) {
        $url='/indexes/'.$indexID.'/documents';
        $ret=$this->postJson($url,$documents);
        return $ret;
    }
}
