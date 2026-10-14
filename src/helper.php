<?php

use iboxs\redis\Redis;

if(!function_exists('redis')){
    function redis($key,$value=null,$expire=null){
        if($value === null){
            return Redis::basic()->get($key);
        }
        return Redis::basic()->set($key,$value,$expire);
    }
}
?>
