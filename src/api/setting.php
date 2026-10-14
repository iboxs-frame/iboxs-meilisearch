<?php
namespace iboxs\meilisearch\api;

use iboxs\basic\Basic;
use iboxs\meilisearch\lib\BaseApi;

class setting extends BaseApi{
    /**
     * 更新设置
     */
    public function uploadSetting(string $indexID, array $settings) {
        $url='indexes/'.$indexID.'/settings';
        $ret=$this->patchJson($url,$settings);
        return $ret;
    }
}
