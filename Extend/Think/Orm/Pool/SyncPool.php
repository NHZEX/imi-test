<?php

namespace ImiApp\Extend\Think\Orm\Pool;

use Imi\Pool\BaseSyncPool;
use Imi\Pool\Interfaces\IPoolResource;
use ImiApp\Extend\Think\Orm\DbResource;

class SyncPool extends BaseSyncPool
{
    protected function createResource(): IPoolResource
    {
        $config = $this->getNextResourceConfig();
        return new DbResource($this, $config);
    }
}
