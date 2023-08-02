<?php
declare(strict_types=1);
namespace Weida\Oauth2Core;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Weida\Oauth2Core\Contract\ConfigInterface;
use Weida\Oauth2Core\Contract\HttpClientInterface;
use Weida\Oauth2Core\Contract\Oauth2Interface;
use Weida\Oauth2Core\Contract\UserInterface;
use RuntimeException;

/**
 * Author: Weida
 * Date: 2023/7/31 23:29
 * Email: sgenmi@gmail.com
 */
abstract class AbstractApplication implements Oauth2Interface
{
    protected ConfigInterface $config;
    protected UserInterface $user;
    protected HttpClientInterface|ClientInterface $httpClient;
    protected array $scopes=[];
    protected string $scopeSeparator=',';
    protected string $state="";


    public function __construct(array $config )
    {
        $this->config = new Config($config);
    }

    /**
     * @return UserInterface
     * @author Weida
     */
    public function userFromCode(string $code):UserInterface{
        $this->getConfig()->set('code',$code);
        $tokenArr = $this->tokenFromCode($code);
        return $this->userFromToken($tokenArr['access_token']);
    }

    /**
     * @return UserInterface
     * @author Weida
     */
    public function userFromToken(string $accessToken): UserInterface
    {
        $url = $this->getUserInfoUrl($accessToken,$openid);
        //明天继续

    }


    /**
     * @return string
     * @author Weida
     */
    public function redirect(): string
    {
        return $this->getAuthUrl();
    }



    /**
     * @return ConfigInterface
     * @author Weida
     */
    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }

    /**
     * @param ConfigInterface $config
     * @return $this
     * @author Weida
     */
    public function setConfig(ConfigInterface $config): static
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return HttpClientInterface|ClientInterface
     * @author Weida
     */
    public function getHttpClient(): HttpClientInterface|ClientInterface
    {
        if(empty($this->httpClient)){
            $this->httpClient = new Client([]);
        }
        return $this->httpClient;
    }

    /**
     * @param string $state
     * @return $this
     * @author Weida
     */
    public function withState(string $state):static{
        return $this->setState($state);
    }

    /**
     * @param string $state
     * @return $this
     * @author Weida
     */
    public function setState(string $state):static{
        $this->state = $state;
        return $this;
    }

    /**
     * @param array $scopes
     * @return $this
     * @author Weida
     */
    public function withScopes(array $scopes):static {
       return $this->setScopes($scopes);
    }

    /**
     * @param array $scopes
     * @return $this
     * @author Weida
     */
    public function setScopes(array $scopes):static {
        $this->scopes = $scopes;
        return $this;
    }

    /**
     * scope 分割字符，默认逗号
     * @param string $separator
     * @return $this
     * @author Sgenmi
     */
    public function setScopeSeparator(string $separator):static {
        $this->scopeSeparator = $separator;
        return $this;
    }

    abstract protected function getAuthUrl():string;

    abstract public function getTokenUrl():string;

    abstract protected function getUserInfoUrl(string $accessToken,string $openid=''):string;

    abstract public function getUserByToken():string;


}
