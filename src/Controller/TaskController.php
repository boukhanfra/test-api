<?php
/**
 * @author a.boukhanfra <a.boukhanfra@paritel.fr>
 * @date 28/11/17
 */

namespace Test\Controller;
use Test\Http\Request;
use Test\Http\Response;
use Test\Manager\TaskManager;
use Test\Manager\UserManager;
use Test\Model\Task;

/**
 * Class TaskController
 * @package Test\Controller
 */
class TaskController extends Controller
{

    public function configureRoutes()
    {
        $this->routes = array(
            array('method' => Request::HTTP_GET, 'action' => 'getTaskAction', 'param' => true, 'format' => '(\d+)'),
            array('method' => Request::HTTP_GET, 'action' => 'listAction', 'param' => false, 'format' => '#'),
            array('method' => Request::HTTP_POST, 'action' => 'addTaskAction', 'param' => false, 'format' => '#'),
            array('method' => Request::HTTP_DELETE, 'action' => 'deleteTaskAction', 'param' => true, 'format' => '(\d+)'),
            array('method' => Request::HTTP_PUT, 'action' => 'updateTskAction', 'param' => true, 'format' => '(\d+)')
        );
    }


    public function configurePrefix()
    {
        $this->prefix = '/task';
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function addTaskAction(Request $request)
    {
        $params = json_decode($request->getContent(), true);
        $user = UserManager::getInstance()->getUser($params['user_id']);
        TaskManager::getInstance()->create(
            $params['title'],
            $params['description'],
            $params['status'],
            $user
        );

        return new Response($this->getList());
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function updateTskAction(Request $request)
    {
        $id = (int) $request->getSplitUri()[1];
        $params = json_decode($request->getContent(), true);
        $user = UserManager::getInstance()->getUser($params['user_id']);
        TaskManager::getInstance()->update(
            $id,
            $params['title'],
            $params['description'],
            $params['status'],
            $user
        );

        return new Response($this->getList());
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function deleteTaskAction(Request $request)
    {
        $id = (int) $request->getSplitUri()[1];
        TaskManager::getInstance()->delete($id);

        return new Response($this->getList());
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getTaskAction(Request $request)
    {
        $id = (int)$request->getSplitUri()[1];

        return new Response(TaskManager::getInstance()->getTask($id)->toArray());
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
        $taskList = array();
        /**
         * @var Task $task
         */
        foreach (TaskManager::getInstance()->getList() as $task) {
            $taskList [] = $task->toArray();
        }

        return $taskList;
    }
}
