<?php

namespace balitrip\mbtcart;

use Yii;
use yii\httpclient\Client;
use worstinme\widgets\Module;
use yii\base\BootstrapInterface;
use yii\caching\Cache;
use yii\data\ArrayDataProvider;
use yii\web\ServerErrorHttpException;

/**
 * Class Component
 * @package balitrip\mbtcart
 *
 * @property Cache $cache
 * @property Client $client
 */
class Component extends \yii\base\Component implements BootstrapInterface
{
    public $apiUrl;
    public $serverApiUrl;
    public $apiAccessToken;
    public $cacheLifeTime = 3600;

    /** @inheritdoc */
    public function bootstrap($app)
    {
        /* @var $module Module */
        if ($app instanceof \yii\web\Application) {
        }
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return new Client(['baseUrl' => $this->serverApiUrl ?? $this->apiUrl]);
    }

    /**
     * @return CacheInterface
     */
    public function getCache()
    {
        return Yii::$app->cache;
    }

    public function getApiData(array $params)
    {
        $key = 'data-'.md5(serialize($params));

        if (($data = Yii::$app->cache->get($key)) === false) {
            $response = $this->getClient()->createRequest()
                ->setUrl('v2/tickets/')
                ->setMethod('GET')
                ->setData(array_merge([
                    'access-token' => $this->apiAccessToken,
                    'per-page' => 10000,
                ], $params))
                ->send();
            if ($response->isOk) {
                Yii::$app->cache->set($key, $response->data, $this->cacheLifeTime);
                return $response->data;
            }

            throw new ServerErrorHttpException('Data load exception');
        }

        return $data;
    }
}
