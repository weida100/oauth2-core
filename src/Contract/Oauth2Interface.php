<?php
declare(strict_types=1);
/**
 * Author: sgenmi
 * Date: 2023/7/31 23:31
 * Email: 150560159@qq.com
 */

namespace Weida\Oauth2Core\Contract;

use GuzzleHttp\ClientInterface;

interface Oauth2Interface
{
    public function getConfig():ConfigInterface;
    public function getHttpClient():HttpClientInterface|ClientInterface;
    public function userFromToken(string $accessToken):UserInterface;
    public function userFromCode(string $code):UserInterface;
    public function redirect():string;
    public function tokenFromCode(string $code):array;
}
