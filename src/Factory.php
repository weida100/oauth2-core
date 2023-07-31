<?php
declare(strict_types=1);

/**
 * Author: sgenmi
 * Date: 2023/7/31 23:13
 * Email: 150560159@qq.com
 */
final class Factory
{
    public function __construct()
    {
    }

    const WEIXIN='weixin';
    const GITEE = 'gitee';
    const GITHUB='github';
    const TAOBAO='taobao';


    public static function getOauth2(string $name,array $config)
    {

    }

}
