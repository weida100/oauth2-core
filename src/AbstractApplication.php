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


    public function __construct(array|ConfigInterface $config )
    {
        if(is_array($config)){
            $this->config = new Config($config);
        }else{
            $this->config = $config;
        }
    }

    /**
     * @param string $code
     * @return array
     * @throws GuzzleException
     * @author Weida
     */
    public function tokenFromCode(string $code): array
    {
        $url =  $this->getTokenUrl($code);
        $resp = $this->getHttpClient()->request('GET',$url);
        if($resp->getStatusCode()!=200){
            throw new RuntimeException('Request access_token exception');
        }
        $arr = json_decode($resp->getBody()->getContents(),true);
        if (empty($arr['access_token'])) {
            throw new RuntimeException('Failed to get access_token: ' . json_encode($arr, JSON_UNESCAPED_UNICODE));
        }
        return $arr;
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

    public function setHttpClient(HttpClientInterface|ClientInterface $httpClient):static {
        $this->httpClient = $httpClient;
        return $this;
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

    /**
     * @param string $accessToken
     * @return UserInterface
     * @throws GuzzleException
     * @author Weida
     */
    public function getUserByToken(string $accessToken): UserInterface
    {
        return $this->userFromToken($accessToken);
    }

    abstract protected function getAuthUrl():string;

    abstract protected function getTokenUrl(string $code):string;

    abstract protected function getUserInfoUrl(string $accessToken):string;

}
