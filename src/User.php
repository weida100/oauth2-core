<?php
declare(strict_types=1);
/**
 * Author: sgenmi
 * Date: 2023/7/31 23:48
 * Email: 150560159@qq.com
 */

namespace Weida\Oauth2Core;

use Weida\Oauth2Core\Contract\UserInterface;

class User implements UserInterface
{
    private array $attributes=[];
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function getId(): string
    {
       return $this->getOpenId();
    }

    public function getOpenId(): string
    {
       return $this->attributes['uid']??'';
    }

    public function getNickname(): string
    {
        return $this->attributes['nickname']??'';
    }

    public function getName(): string
    {
        return $this->attributes['name']??'';
    }

    public function getEmail(): string
    {
        return $this->attributes['email']??'';
    }

    public function getAvatar(): string
    {
        return $this->attributes['avatar']??'';
    }

    public function map(array $attributes): static
    {
       return $this->setAttribute($attributes);
    }

    public function setAttribute(array $attributes): static
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function getAttribute(): array
    {
        return $this->attributes;
    }
}
