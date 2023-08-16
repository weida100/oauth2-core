# oauth2-core
oauth2授权通用核心 （ oauth2 Authorization Common core ）

## Install
```shell
composer require weida/oauth2-core
```

## Demo

```php

use Weida\Oauth2Core\AbstractApplication;
use Weida\Oauth2Core\Contract\UserInterface;
use Weida\Oauth2Core\User;

class GitHub extends AbstractApplication {

    protected function getAuthUrl(): string{
        //your code
    }
    
    protected function getTokenUrl(string $code):string {
        //your code
    }
    
    protected function getUserInfoUrl(string $accessToken): string {
       //your code
    }
    
    public function userFromToken(string $accessToken): UserInterface {
        // demo code
        $url = $this->getUserInfoUrl($accessToken);
        //http get,post
        $resp = $this->getHttpClient()->request('GET',$url);
        if($resp->getStatusCode()!=200){
             throw new RuntimeException('Request userinfo exception');
        }
        $userinfo = json_decode($resp->getBody()->getContents(),true);
        if (empty($userinfo)) {
            throw new RuntimeException('Failed to get userinfo: ' . json_encode($arr, JSON_UNESCAPED_UNICODE));
        }
        return new User($userinfo);
    }
    
    public function userFromCode(string $code): UserInterface
     {
         // demo code
         $tokenArr = $this->tokenFromCode($code);
         return $this->userFromToken($tokenArr['access_token']);
     }
}

$github = new GitHub([
    'client_id' => 'aaaaaa',
    'client_secret' => 'bbbbbbbbbbb',
    'redirect'=>'http://127.0.0.1/a',
]);

echo $github->redirect();
$code = "xxxxxxx";
print_r($github->userFromCode($code)->getAttribute());

```
