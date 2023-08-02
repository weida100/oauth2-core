<?php
declare(strict_types=1);
/**
 * Author: sgenmi
 * Date: 2023/7/31 23:33
 * Email: 150560159@qq.com
 */

namespace Weida\Oauth2Core\Contract;

interface ConfigInterface
{

    public function set(string $key, mixed $val): void;
    public function get(string $key, mixed $default = ''): mixed;
    public function has(string $key): bool;

}
