<?php
/**
 * @author a.boukhanfra <a.boukhanfra@paritel.fr>
 * @date 29/11/17
 */

namespace Test\Manager;
use Test\Exception\UserNotFoundException;
use Test\Model\User;

/**
 * Class UserManager
 * @package Test\Manager
 */
class UserManager
{
    /**
     * @var UserManager
     */
    private static $instance;

    /**
     * @var array
     */
    private $list;

    private function __construct()
    {
        $chars = 'ABCDEFGHIJKLMOPQRSTUVXWYZ';
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->setId($i);
            $name = substr($chars, rand(0, strlen($chars)), 1);
            $name .= substr($chars, rand(0, strlen($chars)), 1);
            $name .= substr($chars, rand(0, strlen($chars)), 1);
            $name .= substr($chars, rand(0, strlen($chars)), 1);
            $user->setName($name);
            $user->setEmail($name.'@'.'gmail.com');
            $this->list[$i] = $user;
        }
    }

    /**
     * @return UserManager|static
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * @param $id
     * @return User
     * @throws UserNotFoundException
     */
    public function getUser($id)
    {
        if (!key_exists($id, $this->list)) {
            throw new UserNotFoundException($id);
        }

        return $this->list[$id];
    }

    /**
     * @param string $name
     * @param string $email
     */
    public function create($name, $email)
    {
        $user = new User();
        $user->setEmail($email)
            ->setName($name)
            ->setId(count($this->list)+1);
        $this->list[] = $user;
    }

    /**
     * @param integer $id
     * @param string $name
     * @param string $email
     * @throws \Exception
     */
    public function update($id, $name, $email)
    {
        if (!key_exists($id, $this->list)) {
            throw new UserNotFoundException($id);
        }
        /**
         * @var User $user
         */
        $user = $this->list[$id];
        $user->setEmail($email)
            ->setName($name);
        $this->list[$id] = $user;
    }

    public function delete($id)
    {
        if (!key_exists($id, $this->list)) {
            throw new UserNotFoundException($id);
        }

        unset($this->list[$id]);
    }

}