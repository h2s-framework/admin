<?php

namespace Siarko\Admin\Model\Management\AdminUser;

use Siarko\DbModelApi\StorageInterface;
use Siarko\Admin\Model\AdminUser;
use Siarko\Admin\Model\AdminUserFactory;
use Siarko\Admin\Model\Exception\AuthenticationException;
use Siarko\Utils\Crypt\PasswordCrypt;
use Siarko\Utils\Persistance\Session\SessionManager;

class Management
{

    private const SESSION_USER_KEY = 'admin_user_id';

    /**
     * @param AdminUserFactory $adminUserFactory
     * @param PasswordCrypt $passwordCrypt
     * @param StorageInterface $storage
     * @param SessionManager $sessionManager
     */
    public function __construct(
        private readonly AdminUserFactory $adminUserFactory,
        private readonly PasswordCrypt   $passwordCrypt,
        private readonly StorageInterface $storage,
        private readonly SessionManager $sessionManager
    )
    {
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @return void
     */
    public function create(string $username, string $email, string $password): void
    {
        $passwordHash = $this->passwordCrypt->encrypt($password);
        $adminUser = $this->adminUserFactory->create();
        $adminUser->setUsername($username);
        $adminUser->setEmail($email);
        $adminUser->setPasswordHash($passwordHash);
        $this->storage->save($adminUser);
    }

    /**
     * @param string $username
     * @param string $password
     * @return AdminUser
     * @throws AuthenticationException
     */
    public function authenticate(string $username, string $password): AdminUser
    {
        try{
            $user = $this->storage->one(AdminUser::class, [AdminUser::USERNAME => $username]);
            if($this->passwordCrypt->match($password, $user->getPasswordHash())){
                return $user;
            }
        }catch (\Exception $exception){}
        throw new AuthenticationException("Authentication failed");
    }

    /**
     * @param AdminUser $user
     * @return void
     */
    public function login(AdminUser $user): void
    {
        $this->sessionManager->set(self::SESSION_USER_KEY, $user->getId());
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        $this->sessionManager->set(self::SESSION_USER_KEY, null);
    }

    /**
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return $this->sessionManager->get(self::SESSION_USER_KEY) !== null;
    }

    /**
     * @return AdminUser
     * @throws AuthenticationException
     */
    public function getLoggedIn(): AdminUser
    {
        $userId = $this->sessionManager->get(self::SESSION_USER_KEY);
        if($userId === null) {
            throw new AuthenticationException("User is not logged in");
        }
        return $this->storage->one(AdminUser::class, [AdminUser::ID => $userId]);
    }
}