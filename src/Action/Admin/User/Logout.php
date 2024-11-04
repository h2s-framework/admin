<?php

namespace Siarko\Admin\Action\Admin\User;

use Siarko\ActionRouting\ActionResult\AbstractActionResult;
use Siarko\ActionRouting\ActionResult\ActionRedirectResult;
use Siarko\ActionRouting\IAction;
use Siarko\ActionRouting\Routing\Attributes\ParametricUrl;
use Siarko\Admin\Model\Management\AdminUser\Management;
use Siarko\Utils\Persistance\Messaging\MessageManager;

class Logout implements IAction
{

    /**
     * @param Management $userManagement
     * @param MessageManager $messageManager
     * @param ActionRedirectResult $redirectActionResult
     */
    public function __construct(
        protected readonly Management $userManagement,
        protected readonly MessageManager $messageManager,
        protected readonly ActionRedirectResult $redirectActionResult
    )
    {
    }

    /**
     * @return AbstractActionResult|null
     */
    #[ParametricUrl('^admin/logout$')]
    public function run(): ?AbstractActionResult
    {
        $this->userManagement->logout();
        $this->messageManager->info(T("You have been logged out"));
        return $this->redirectActionResult->setUrl('/admin/login');
    }


}