<?php

namespace App\Logic;

class LDAP
{
    private $ldapParams;

    public function __construct(array $ldapParams)
    {
        $this->ldapParams = $ldapParams;
    }

    /**
     * @param string $query
     * @return \Symfony\Component\Ldap\Adapter\CollectionInterface|\Symfony\Component\Ldap\Entry[]
     */
    private function searchLdap($query)
    {
        $ldap = \Symfony\Component\Ldap\Ldap::create('ext_ldap',['connection_string'=>$this->ldapParams['connection_string']]);
        $ldap->bind($this->ldapParams['bind_dn'],$this->ldapParams['bind_password']);
        $query = $ldap->query($this->ldapParams['user_dn'], $query);

        return $query->execute();
    }

    /**
     * @param string $username
     * @param string|null $query
     * @return array
     */
    public function searchUser(string $username, string $query=null)
    {
        if (is_null($query))
            $query = "(uid=$username)";

        $results = [];
        foreach ($this->searchLdap($query) as $user)
        {
            $object = [
                'lastname'=>$user->getAttribute('sn')[0],
                'firstname'=>$user->getAttribute('givenName')[0],
                'mail'=>$user->getAttribute('mail')[0],
                'username'=>$user->getAttribute('uid')[0],
            ];

            $results[$user->getAttribute('sn')[0]." ".$user->getAttribute('givenName')[0]] = (object) $object;
        }
        ksort($results);

        return $results;
    }

    /**
     * @param $username
     * @return bool
     */
    public function isAdmin($username)
    {
        return !empty($this->searchUser($username,str_replace('{{username}}',$username,$this->ldapParams["admin_query"])));
    }
}