<?php

namespace ImiApp\Extend\Think\Orm;

use Imi\Bean\Annotation\Bean;
use Imi\Config;
use Imi\Pool\PoolManager;
use Imi\RequestContext;
use Psr\SimpleCache\CacheInterface;
use think\db\ConnectionInterface;

/**
 * Class DbManager
 * @package ImiApp\Extend\Think\Orm
 * @Bean("ThinkDbManager")
 */
class DbManager extends \think\DbManager
{
    public static function getIns(): DbManager
    {
        // todo 需要继续重构
        return RequestContext::getBean(DbManager::class);
    }

    protected function createConnection(string $name): ConnectionInterface
    {
        $r = PoolManager::getRequestContextResource($name);
        //$i = ServerManage::getServer('main')->getSwooleServer()->worker_id;
        //var_dump("w:{$i}:{$r->getPool()->getCount()}:{$r->getPool()->getFree()}");
        return $r->getInstance();
    }

    public function getConfig(string $name = '', $default = null)
    {
        $config = Config::get('@app.db-tp');
        if (empty($config['cache'])) {
            $config['cache'] = Config::get('@app.cache.default');
        }
        if ('' === $name) {
            return $config;
        }

        return $config[$name] ?? $default;
    }

    protected function getConnectionConfig(string $name): array
    {
        $pool = PoolManager::getResource($name);
        $config = $pool->getPool()->getResourceConfig();
        //打开断线重连
        $config['break_reconnect'] = true;
        return $config;
    }

    public function setCache(CacheInterface $cache): void
    {
        throw new \RuntimeException('does not support');
    }
}
