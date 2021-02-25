<?php

namespace ImiApp\Listener;

use Imi\Bean\Annotation\Listener;
use Imi\Event\EventParam;
use Imi\Event\IEventListener;
use Imi\Server\Event\Param\StartEventParam;
use Imi\ServerManage;
use Swoole\Process;

/**
 * Class OnMainServerStart
 * @package ImiApp\Listener
 * @Listener(eventName="IMI.MAIN_SERVER.START")
 */
class OnMainServerStart implements IEventListener
{
    /**
     * @param StartEventParam|EventParam $e
     */
    public function handle(EventParam $e)
    {
        imigo(function () {
            Process::signal(SIGHUP, function () {
                var_dump('session stop');
                ServerManage::getServer('main')->getSwooleServer()->shutdown();
            });
            Process::signal(SIGINT, function () {
                var_dump('ctrl+c stop');
                ServerManage::getServer('main')->getSwooleServer()->shutdown();
            });
        });
    }
}
