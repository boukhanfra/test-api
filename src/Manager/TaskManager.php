<?php
/**
 * @author a.boukhanfra <a.boukhanfra@paritel.fr>
 * @date 29/11/17
 */

namespace Test\Manager;

use Test\Exception\TaskNotFoundException;
use Test\Model\Task;
use Test\Model\User;

/**
 * Class TaskManager
 * @package Test\Manager
 */
class TaskManager
{

    /**
     * @var UserManager
     */
    private static $instance;

    /**
     * @var array
     */
    private $list;

    /**
     * TaskManager constructor.
     */
    private function __construct()
    {
        $chars = 'ABCDEFGHIJKLMOPQRSTUVXWYZ';
        $status = array('Annulée', 'Traitée', 'A traiter');
        for ($i = 1; $i <= 10; $i++) {
            $task = new Task();
            $task->setId($i);
            $name = substr($chars, rand(0, strlen($chars)), 1);
            $name .= substr($chars, rand(0, strlen($chars)), 1);
            $name .= substr($chars, rand(0, strlen($chars)), 1);
            $name .= substr($chars, rand(0, strlen($chars)), 1);
            $task->setDescription($name. ' created on '.(new \DateTime('now'))->format('d/m/Y H:i:s'))
                ->setTitle($name)
                ->setCreationDate(new \DateTime('now'))
                ->setUser(UserManager::getInstance()->getUser($i))
                ->setStatus($status[rand(0,2)])
                ->setId($i);
            $this->list[$i] = $task;
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
     * @return Task
     * @throws TaskNotFoundException
     */
    public function getTask($id)
    {
        if (!key_exists($id, $this->list)) {
            throw new TaskNotFoundException($id);
        }

        return $this->list[$id];
    }

    /**
     * @param string $title
     * @param string $description
     * @param string $status
     * @param User   $user
     */
    public function create($title, $description, $status, User $user)
    {
        $task = new Task();
        $task->setDescription($description)
            ->setTitle($title)
            ->setCreationDate(new \DateTime('now'))
            ->setStatus($status)
            ->setUser($user)
            ->setId(count($this->list)+1);
        $this->list[] = $task;
    }

    /**
     * @param integer $id
     * @param string  $title
     * @param string  $description
     * @param string  $status
     * @param User    $user
     * @throws TaskNotFoundException
     */
    public function update($id, $title, $description, $status, User $user)
    {
        if (!key_exists($id, $this->list)) {
            throw new TaskNotFoundException($id);
        }
        /**
         * @var Task $task
         */
        $task = $this->list[$id];
        $task->setDescription($description)
            ->setTitle($title)
            ->setStatus($status)
            ->setUser($user);
        $this->list[$id] = $task;
    }

    public function delete($id)
    {
        if (!key_exists($id, $this->list)) {
            throw new TaskNotFoundException($id);
        }

        unset($this->list[$id]);
    }

}