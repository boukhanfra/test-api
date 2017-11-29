<?php
/**
 * @author a.boukhanfra <a.boukhanfra@paritel.fr>
 * @date 29/11/17
 */

namespace Test\Exception;

/**
 * Class TaskNotFoundException
 * @package Test\Exception
 */
class TaskNotFoundException extends \Exception
{
    /**
     * UserNotFoundException constructor.
     * @param integer $id
     */
    public function __construct($id)
    {
        parent::__construct("La tâche ".$id." est introuvable!", 404);
    }
}