<?php
declare(strict_types=1);

/**
 * Author: sgenmi
 * Date: 2023/7/31 23:13
 * Email: sgenmi@gmail.com
 */

namespace Weida\Oauth2Core;

use RuntimeException;

final class Factory
{
    private function __construct() {}
    const WEIXIN='weixin';
    const GITEE ='gitee';
    const GITHUB='github';
    const TAOBAO='taobao';
    const WEIBO='weibo';

    public static function getOauth2(string|object $name,array $config):AbstractApplication
    {
        return self::getApp($name,$config);
    }

    private static function getApp(string|object $name,array $config):AbstractApplication{
        if(is_string($name)){
            //内置定义
            $defineClass = self::getDefined($name);
            if($defineClass){
                $name = new $defineClass($config);
            }else{
                $name = new $name($config);
            }
        }

        if(! $name instanceof AbstractApplication){
            throw new RuntimeException(
                sprintf('Class %s was not found to inherit class %s',get_class($name),AbstractApplication::class)
            );
        }
        if($config){
            $name->setConfig( new Config($config));
        }
        return $name;
    }

    private static function getDefined(string $name):string{

        return match ($name){
            self::WEIXIN => \Weida\Oauth2\Weixin::class,
            self::GITEE => \Weida\Oauth2\Gitee::class,
            self::GITHUB => \Weida\Oauth2\Github::class,
            self::TAOBAO =>  \Weida\Oauth2\Taobao::class,
            self::WEIBO => \Weida\Oauth2\Weibo::class,
            default=>''
        };
    }

}
