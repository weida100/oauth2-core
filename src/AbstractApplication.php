<?php
declare(strict_types=1);
namespace Weida\Oauth2Core;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Weida\Oauth2Core\Contract\ConfigInterface;
use Weida\Oauth2Core\Contract\HttpClientInterface;
use Weida\Oauth2Core\Contract\Oauth2Interface;
use Weida\Oauth2Core\Contract\UserInterface;

/**
 * Author: sgenmi
 * Date: 2023/7/31 23:29
 * Email: 150560159@qq.com
 */
abstract class AbstractApplication implements Oauth2Interface
{
    protected ConfigInterface $config;
    protected UserInterface $user;
    protected HttpClientInterface|ClientInterface $httpClient;
    protected array $scopes=[];
    protected string $scopeSeparator=',';


    public function __construct(array $config )
    {
        $this->config = new Config($config);
    }

    /**
     * @return UserInterface
     * @author Sgenmi
     */
    public function userFromCode():UserInterface{

    }

    /**
     * @return UserInterface
     * @author Sgenmi
     */
    public function userFromToken(): UserInterface
    {

    }


    /**
     * @return string
     * @author Sgenmi
     */
    public function redirect(): string
    {
        return $this->getUrl();
    }

    /**
     * @return array
     * @author Sgenmi
     */
    public function tokenFromCode(): array
    {
        return [];
    }

    /**
     * @return ConfigInterface
     * @author Sgenmi
     */
    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }

    /**
     * @return HttpClientInterface|ClientInterface
     * @author Sgenmi
     */
    public function getHttpClient(): HttpClientInterface|ClientInterface
    {
        if(empty($this->httpClient)){
            $this->httpClient = new Client([]);
        }
        return $this->httpClient;
    }


    /**
     * @return string
     * @author Sgenmi
     */
    abstract public function getAuthUrl():string;

    abstract public function getTokenUrl():string;

    abstract public function getUserByToken():string;




}
