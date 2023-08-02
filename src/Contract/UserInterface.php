<?php
declare(strict_types=1);
/**
 * Author: sgenmi
 * Date: 2023/7/31 23:24
 * Email: 150560159@qq.com
 */

namespace Weida\Oauth2Core\Contract;

interface UserInterface
{
    public function getId():string;
    public function getOpenId():string;
    public function getNickname():string;
    public function getName():string;
    public function getEmail():string;
    public function getAvatar():string;
    public function map(array $attributes):static;
    public function setAttribute(array $attributes):static;
    public function getAttribute():array;

}
