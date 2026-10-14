<?php
/**
 * 搜索引擎从这里开始
 * @author  zqu zqu1016@qq.com
 */
namespace iboxs\meilisearch;

use iboxs\meilisearch\lib\key;
use iboxs\meilisearch\api\{index, documents, search, setting};

/**
 * Meilisearch 主类
 * @property index $index 索引操作
 * @property documents $documents 文档操作
 * @property search $search 搜索操作
 * @property setting $setting 设置操作
 */
class Meilisearch
{
    use key;
    protected $apiKey;

    public function __construct(
        protected $masterKey,
        protected $host
    ){
        $this->apiKey = $this->getApiKey($host,$masterKey);
    }

    public function __get($name)
    {
        $className="iboxs\\meilisearch\\api\\".$name;
        if(class_exists($className)){
            $this->apiKey = $this->getApiKey($this->host,$this->masterKey);
            return new $className($this->masterKey, $this->host, $this->apiKey);
        }
        throw new \Exception("Class $className does not exist");
    }

    /**
     * 获取 Meilisearch 实例
     */
    public static function getInstance($config=[]){
        $masterKey=config('meilisearch.masterKey');
        $host=config('meilisearch.host');
        if(isset($config['master_key'])){
            $masterKey=$config['master_key'];
        }
        if(isset($config['host'])){
            $host=$config['host'];
        }
        return new self($masterKey, $host);
    }
}
