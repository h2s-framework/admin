<?php

namespace Siarko\Admin\Action\Admin;

use Siarko\ActionRouting\ActionResult\ActionPageResult;
use Siarko\ActionRouting\IAction;
use Siarko\ActionRouting\Routing\Attributes\ParametricUrl;

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
    public function run(){
        $this->pageResult->getLayoutParser()->enableModifierLayout('index');
        return $this->pageResult;
    }

}