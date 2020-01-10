<?php

namespace App\Security\User;

use App\Logic\LDAP;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\User;

class UserProvider implements UserProviderInterface
{
    private $ldap;
    private $container;

    public function __construct(LDAP $ldap, ContainerInterface $container) {
        $this->ldap = $ldap;
        $this->container = $container;
    }

    public function loadUserByUsername($username)
    {
        if (true === $this->ldap->isAdmin($username))
            return new User($username, "xxx", ["ROLE_ADMIN"]);

        return new User($username, "xxx", ['ROLE_USER']);

    }


    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByUsername($user->getUsername());
    }


    public function supportsClass($class)
    {
        return $class === 'Symfony\Component\Security\Core\User\User';
    }
}