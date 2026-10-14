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
        $url='indexes/'.$indexID.'/documents';
        $ret=$this->postJson($url,$documents);
        return $ret;
    }

    /**
     * 删除文档
     * @param string $indexID 索引UID
     * @param array $params 删除参数
     * @return mixed
     */
    public function delete($indexID,array $params) {
        $url='indexes/'.$indexID.'/documents/delete';
        $ret=$this->postJson($url,$params);
        return $ret;
    }
}
