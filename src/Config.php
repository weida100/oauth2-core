<?php
declare(strict_types=1);

/**
 * Author: sgenmi
 * Date: 2023/7/31 23:40
 * Email: 150560159@qq.com
 */

namespace Weida\Oauth2Core;

use Weida\Oauth2Core\Contract\ConfigInterface;

class Config implements ConfigInterface
{
    private array $config=[];
    public function __construct(array $config){
        $this->config = $config;
    }




}
