<?php
/**
 * @author a.boukhanfra <a.boukhanfra@paritel.fr>
 * @date 29/11/17
 */

namespace Test\Exception;

/**
 * Class UserNotFoundException
 * @package Test\Exception
 */
class UserNotFoundException extends \Exception
{
    /**
     * UserNotFoundException constructor.
     * @param integer $id
     */
    public function __construct($id)
    {
        parent::__construct("L'utilisateur ".$id." est introuvable!", 404);
    }
}