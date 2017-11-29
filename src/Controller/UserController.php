<?php
/**
 * @author a.boukhanfra <a.boukhanfra@paritel.fr>
 * @date 28/11/17
 */

namespace Test\Controller;

use Test\Http\Request;
use Test\Http\Response;
use Test\Manager\UserManager;
use Test\Model\User;

/**
 * Class UserController
 * @package Test\Controller
 */
class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {

    }

    public function configurePrefix()
    {
        $this->prefix = '/user';
    }

    public function configureRoutes()
    {
        $this->routes = array(
            array('method' => Request::HTTP_GET, 'action' => 'getAction', 'param' => true, 'format' => '(\d+)'),
            array('method' => Request::HTTP_GET, 'action' => 'listAction', 'param' => false, 'format' => '#'),
            array('method' => Request::HTTP_POST, 'action' => 'addUserAction', 'param' => false, 'format' => '#'),
            array('method' => Request::HTTP_DELETE, 'action' => 'deleteUserAction', 'param' => true, 'format' => '(\d+)'),
            array('method' => Request::HTTP_PUT, 'action' => 'updateUserAction', 'param' => true, 'format' => '(\d+)')
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function addUserAction(Request $request)
    {
        $params = json_decode($request->getContent(), true);
        UserManager::getInstance()->create($params['name'], $params['email']);

        return new Response($this->getList());
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function updateUserAction(Request $request)
    {
        $id = (int) $request->getSplitUri()[1];
        $params = json_decode($request->getContent(), true);
        UserManager::getInstance()->update($id, $params['name'], $params['email']);

        return new Response($this->getList());
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function deleteUserAction(Request $request)
    {
        $id = (int) $request->getSplitUri()[1];
        UserManager::getInstance()->delete($id);

        return new Response($this->getList());
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getAction(Request $request)
    {
        $id = (int)$request->getSplitUri()[1];

        return new Response(UserManager::getInstance()->getUser($id)->toArray());
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request)
    {

        return new Response($this->getList());
    }

    /**
     * @return array
     */
    private function getList()
    {
        $userList = array();
        /**
         * @var User $user
         */
        foreach (UserManager::getInstance()->getList() as $user) {
            $userList [] = $user->toArray();
        }

        return $userList;
    }
}
