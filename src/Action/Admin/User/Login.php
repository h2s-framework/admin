<?php

namespace Siarko\Admin\Action\Admin\User;

use Siarko\ActionRouting\ActionProvider\InputParams\Attributes\RequireParam;
use Siarko\ActionRouting\ActionResult\ActionPageResult;
use Siarko\ActionRouting\ActionResult\ActionRedirectResult;
use Siarko\ActionRouting\Routing\Attributes\ParametricUrl;
use Siarko\ActionRouting\Routing\Method;
use Siarko\ActionRouting\Routing\Url\RequestDataProvider;
use Siarko\Admin\Model\Exception\AuthenticationException;
use Siarko\Admin\Model\Management\AdminUser\Management;
use Siarko\Utils\Persistance\Messaging\MessageManager;

class Login implements \Siarko\ActionRouting\IAction
{

    public function __construct(
        protected readonly ActionPageResult $pageResult,
        protected readonly ActionRedirectResult $redirectResult,
        protected readonly RequestDataProvider $requestDataProvider,
        protected readonly Management $userManagement,
        protected readonly MessageManager $messageManager
    )
    {
    }

    /**
     * View Action
     * @return ActionPageResult
     */
    #[ParametricUrl("^admin/login")]
    public function run(){
        $this->pageResult->getLayoutParser()->enableModifierLayout('login/login');
        return $this->pageResult;
    }

    /**
     * Authenticate Action
     * @return ActionRedirectResult
     * @throws AuthenticationException
     */
    #[ParametricUrl("^admin/login", Method::POST)]
    #[RequireParam('username')]
    #[RequireParam('password')]
    public function authenticate()
    {
        $username = $this->requestDataProvider->post('username');
        $password = $this->requestDataProvider->post('password');
        try{
            $user = $this->userManagement->authenticate($username, $password);
            $this->userManagement->login($user);
            $this->messageManager->success(T('Login successful as %s', $username));
            return $this->redirectResult->setUrl('/admin');
        }catch (AuthenticationException $e){
            $this->messageManager->error($e->getMessage());
            return $this->redirectResult->setUrl('/admin/login');
        }
    }

}