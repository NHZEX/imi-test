<?php

use Imi\Db\Pool\CoroutineDbPool;
use Imi\Db\Pool\SyncDbPool;
use ImiApp\Extend\Think\Orm\Pool\AsyncPool as TpOrmAsyncPool;
use ImiApp\Extend\Think\Orm\Pool\SyncPool as TpOrmSyncPool;
use think\db\Query as TpQuery;

return [
    // 项目根命名空间
    'namespace'   => 'ImiApp',

    // 配置文件
    'configs'     => [
        'beans' => __DIR__ . '/beans.php',
    ],

    // 扫描目录
    'beanScan'    => [
        'ImiApp\Listener',
        'ImiApp\Task',
        'ImiApp\Model',
        'ImiApp\Extend',
    ],

    // 组件命名空间
    'components'  => [
    ],

    // 主服务器配置
    'mainServer'  => [
        'namespace' => 'ImiApp\ApiServer',
        'type'      => Imi\Server\Type::HTTP,
        'host'      => '0.0.0.0',
        'port'      => 8080,
        'configs'   => [
            'worker_num'        =>  (int) imiGetEnv('IMI_WORKER_NUM', 4),
            // 'task_worker_num'   =>  16,
        ],
    ],

    // 子服务器（端口监听）配置
    'subServers'  => [
        // 'SubServerName'   =>  [
        //     'namespace'    =>    'ImiApp\XXXServer',
        //     'type'        =>    Imi\Server\Type::HTTP,
        //     'host'        =>    '127.0.0.1',
        //     'port'        =>    13005,
        // ]
    ],

    // 连接池配置
    'pools'       => [
        // 主数据库
        'maindb' => [
            'pool'     => [
                // 同步池类名
                'syncClass'  => SyncDbPool::class,
                // 协程池类名
                'asyncClass' => CoroutineDbPool::class,
                // 连接池配置
                'config'     => [
                    // 池子中最多资源数
                    'maxResources' => 3,
                    // 池子中最少资源数
                    'minResources' => 0,
                    // 资源回收时间间隔，单位：秒
                    // 'gcInterval' => 60,
                    // 获取资源最大存活时间，单位：秒
                    // 'maxActiveTime' => 3600,
                    // 等待资源最大超时时间，单位：毫秒
                    // 'waitTimeout' => 3000,
                    // 心跳时间间隔，单位：秒
                    // 'heartbeatInterval' => null,
                    // 当获取资源时，是否检查状态
                    // 'checkStateWhenGetResource' => true,
                    // 每次获取资源最长使用时间，单位：秒；为 null 则不限制
                    // 'maxUsedTime' => null,
                    // 当前请求上下文资源检查状态间隔，单位：支持小数的秒；为 null 则不限制
                    // 'requestResourceCheckInterval' => 30,
                    // 负载均衡-轮流
                    // 'resourceConfigMode' => ResourceConfigMode::TURN,
                    // 负载均衡-随机
                    // 'resourceConfigMode' => ResourceConfigMode::RANDOM,
                ],
            ],
            // 连接池资源配置
            'resource' => [
                'host'     => imiGetEnv('KM_MAIN_DB_HOST', '127.0.0.1'),
                'port'     => imiGetEnv('KM_MAIN_DB_PORT', 3306),
                'username' => imiGetEnv('KM_MAIN_DB_USERNAME', 'root'),
                'password' => imiGetEnv('KM_MAIN_DB_PASSWORD', 'password'),
                'database' => imiGetEnv('KM_MAIN_DB_DATABASE', 'dbname'),
                'charset'  => 'utf8mb4',
            ],
        ],
        // 主数据库
        'tporm' => [
            'pool'     => [
                // 同步池类名
                'syncClass'  => TpOrmSyncPool::class,
                // 协程池类名
                'asyncClass' => TpOrmAsyncPool::class,
                // 连接池配置
                'config'     => [
                    // 池子中最多资源数
                    'maxResources' => 8,
                    // 池子中最少资源数
                    'minResources' => 0,
                    // 资源回收时间间隔，单位：秒
                    // 'gcInterval' => 60,
                    // 获取资源最大存活时间，单位：秒
                    // 'maxActiveTime' => 3600,
                    // 等待资源最大超时时间，单位：毫秒
                    // 'waitTimeout' => 3000,
                    // 心跳时间间隔，单位：秒
                    // 'heartbeatInterval' => null,
                    // 当获取资源时，是否检查状态
                    // 'checkStateWhenGetResource' => true,
                    // 每次获取资源最长使用时间，单位：秒；为 null 则不限制
                    // 'maxUsedTime' => null,
                    // 当前请求上下文资源检查状态间隔，单位：支持小数的秒；为 null 则不限制
                    // 'requestResourceCheckInterval' => 30,
                    // 负载均衡-轮流
                    // 'resourceConfigMode' => ResourceConfigMode::TURN,
                    // 负载均衡-随机
                    // 'resourceConfigMode' => ResourceConfigMode::RANDOM,
                ],
            ],
            // 连接池资源配置
            'resource' => [
                'type'            => 'mysql',
                'hostname'        => imiGetEnv('KM_MAIN_DB_HOST', '127.0.0.1'),
                'hostport'        => imiGetEnv('KM_MAIN_DB_PORT', 3306),
                'database'        => (string) imiGetEnv('KM_MAIN_DB_DATABASE', ''),
                'username'        => (string) imiGetEnv('KM_MAIN_DB_USERNAME', 'root'),
                'password'        => (string) imiGetEnv('KM_MAIN_DB_PASSWORD', ''),
                // 连接dsn
                'dsn'             => '',
                // 数据库连接参数
                'params'          => [],
                // 数据库编码默认采用utf8
                'charset'         => 'utf8mb4',
                // 数据库表前缀
                'prefix'          => '',
                // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
                'deploy'          => 0,
                // 数据库读写是否分离 主从式有效
                'rw_separate'     => false,
                // 读写分离后 主服务器数量
                'master_num'      => 1,
                // 指定从服务器序号
                'slave_no'        => '',
                // 是否严格检查字段是否存在
                'fields_strict'   => true,
                // 开启字段缓存
                'fields_cache'    => false,
                // 监听SQL
                'trigger_sql'     => true,
                // Builder类
                'builder'         => '',
                // Query类
                'query'           => TpQuery::class,
                // 是否需要断线重连
                'break_reconnect' => true,
                // 字段缓存路径
                'schema_cache_path' => __DIR__ . '/../.runtime/schema/',
            ],
        ],
        // 'redis'    =>    [
        //     'sync'    =>    [
        //         'pool'    =>    [
        //             'class'        =>    \Imi\Redis\SyncRedisPool::class,
        //             'config'    =>    [
        //                 'maxResources'    =>    10,
        //                 'minResources'    =>    0,
        //             ],
        //         ],
        //         'resource'    =>    [
        //             'host'      => '127.0.0.1',
        //             'port'      => 6379,
        //             'password'  => null,
        //         ]
        //     ],
        //     'async'    =>    [
        //         'pool'    =>    [
        //             'class'        =>    \Imi\Redis\CoroutineRedisPool::class,
        //             'config'    =>    [
        //                 'maxResources'    =>    10,
        //                 'minResources'    =>    0,
        //             ],
        //         ],
        //         'resource'    =>    [
        //             'host'      => '127.0.0.1',
        //             'port'      => 6379,
        //             'password'  => null,
        //         ]
        //     ],
        // ],
    ],

    // 数据库配置
    'db'          => [
        // 数默认连接池名
        'defaultPool' => 'maindb',
        'statement'   => [
            'cache' => true, // 是否开启 statement 缓存，默认开启
        ],
    ],

    // 数据库配置
    'db-tp'          => [
        // 数默认连接池名
        'default' => 'tporm',
        // 自定义时间查询规则
        'time_query_rule' => [],
        // 自动写入时间戳字段
        // true为自动识别类型 false关闭
        // 字符串则明确指定时间字段类型 支持 int timestamp datetime date
        'auto_timestamp' => true,
        // 时间字段取出后的默认时间格式
        'datetime_format' => false,
        // 缓存提供商

    ],

    // redis 配置
    'redis'       => [
        // 数默认连接池名
        'defaultPool' => 'redis',
    ],

    // 内存表配置
    'memoryTable' => [
        // 't1'    =>  [
        //     'columns'   =>  [
        //         ['name' => 'name', 'type' => \Swoole\Table::TYPE_STRING, 'size' => 16],
        //         ['name' => 'quantity', 'type' => \Swoole\Table::TYPE_INT],
        //     ],
        //     'lockId'    =>  'atomic',
        // ],
    ],

    // 锁
    'lock'        => [
        // 'list'  =>  [
        //     'atomic' =>  [
        //         'class' =>  'AtomicLock',
        //         'options'   =>  [
        //             'atomicName'    =>  'atomicLock',
        //         ],
        //     ],
        // ],
    ],

    // atmoic 配置
    'atomics'     => [
        // 'atomicLock'   =>  1,
    ],

    'caches'    =>    [
        // 缓存名称
        'alias1'    =>    [
            // 缓存驱动类
            'handlerClass'    =>    \Imi\Cache\Handler\File::class,
            // 驱动实例配置
            'option'        =>    [
                'savePath'    =>    __DIR__ . '/../.runtime/cache/',
                'formatHandlerClass'    =>    null, // 数据读写修改器
                // 保存文件名处理回调，一般可以不写
                // 'saveFileNameCallback'    =>    function($savePath, $key){
                //     return '';
                // },
            ],
        ],
    ],

    'cache'    =>    [
        'default' => 'alias1',
    ],
];