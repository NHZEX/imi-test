<?php

namespace ImiApp\Extend\Think\Orm;

use Imi\Cache\CacheManager;
use Imi\Pool\BasePoolResource;
use Imi\Pool\Interfaces\IPool;
use RuntimeException;
use think\db\ConnectionInterface;
use think\db\PDOConnection;
use function is_subclass_of;
use function strpos;
use function ucfirst;

class DbResource extends BasePoolResource
{
    /**
     * @var ConnectionInterface|PDOConnection
     */
    protected $connection;

    /**
     * @var array
     */
    protected $config;

    public function __construct(IPool $pool, array $config)
    {
        $this->config = $config;
        parent::__construct($pool);
        $this->initConnection();
    }

    protected function initConnection()
    {
        $config = $this->config;
        $type = !empty($config['type']) ? $config['type'] : 'mysql';

        if (false !== strpos($type, '\\')) {
            $class = $type;
        } else {
            $class = '\\think\\db\\connector\\' . ucfirst($type);
        }
        if (!is_subclass_of($class, ConnectionInterface::class)) {
            throw new RuntimeException('connection adapter must be ' . ConnectionInterface::class);
        }
        if (!is_subclass_of($class, PDOConnection::class)) {
            throw new RuntimeException('connection adapter only supports ' . PDOConnection::class);
        }

        $dbManager = DbManager::getIns();

        /** @var ConnectionInterface|PDOConnection $connection */
        $connection = new $class($config);
        $connection->setDb($dbManager);

        $cache = CacheManager::getInstance($dbManager->getConfig('cache'));
        $connection->setCache($cache);

        $this->connection = $connection;
    }

    public function open()
    {
        return true;
    }

    public function close()
    {
        $this->connection->close();
    }

    /**
     * @return ConnectionInterface
     */
    public function getInstance()
    {
        return $this->connection;
    }

    public function reset()
    {
        // todo 清理可能残留的事务
    }

    public function checkState(): bool
    {
        // todo 检查连接状态
        return true;
    }
}
