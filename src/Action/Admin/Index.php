<?php

namespace Siarko\Admin\Action\Admin;

use Siarko\ActionRouting\IAction;
use Siarko\ActionRouting\Routing\Attributes\ParametricUrl;
use Siarko\BlockLayout\ControllerRouting\ActionResult\ActionPageResult;
use Siarko\BlockLayout\ControllerRouting\Attribute\Layout;

class Index implements IAction
{

    /**
     * @param ActionPageResult $pageResult
     */
    public function __construct(
        protected readonly ActionPageResult $pageResult
    )
    {
    }

    /**
     * @return ActionPageResult
     */
    #[ParametricUrl("^admin$")]
    #[Layout('index')]
    public function run(){
        return $this->pageResult;
    }

}