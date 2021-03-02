<?php

namespace ImiApp\Extend\Think\Orm\Pool;

use Imi\Pool\BaseAsyncPool;
use Imi\Pool\Interfaces\IPoolResource;
use ImiApp\Extend\Think\Orm\DbResource;

class AsyncPool extends BaseAsyncPool
{
    protected function createResource(): IPoolResource
    {
        $config = $this->getNextResourceConfig();
        return new DbResource($this, $config);
    }
}
