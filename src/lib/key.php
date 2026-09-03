<?php
namespace iboxs\meilisearch\lib;

use iboxs\basic\Basic;

trait key{
    public function getApiKey($host,$masterKey)
    {
        $cacheKey='meilisearch:api_key:'.md5($host.$masterKey);
        $cache=redis($cacheKey);
        if($cache!=null){
            return $cache;
        }

        $url=$host."/keys";
        $header=[
            'Authorization: Bearer '.$masterKey
        ];
        $rsp=Basic::Http($url)->setHeader($header)->get();
        $adminKey="";
        $searchKey="";
        if($rsp){
            foreach($rsp['results'] as $key){
                if($key['name']=='Default Search API Key'){
                    $searchKey=$key['key'];
                } else if($key['name']=='Default Admin API Key'){
                    $adminKey=$key['key'];
                }
            }
        }
        $ret=[
            'adminKey'=>$adminKey,
            'searchKey'=>$searchKey
        ];
        redis($cacheKey, $ret,86400);
        return $ret;
    }
}
