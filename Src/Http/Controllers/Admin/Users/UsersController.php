<?php
/**
 * Created by PhpStorm.
 * User: abmes
 * Date: 01.09.2019
 * Time: 18:18
 */
namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\BaseController;
use App\Modules\Users\UsersEntity;
use App\Modules\Users\Managers\UsersManager;
use App\Modules\Users\Validators\UsersValidator;
use App\Modules\Users\Forms\UsersForm;
use App\Helpers\ObjectHelper;
use App\Helpers\PaginationManager;

class UsersController extends BaseController
{
    static $action = "users";

    public function __construct()
    {

    }

    public static function getInstanceManager()
    {
        return new UsersManager();
    }

    public static function getInstanceEntity()
    {
        return UsersEntity::getInstanceEntity();
    }

    public static function getInstanceValidator($data, $fields)
    {
        return UsersValidator::getInstanceValidator($data, $fields);
    }

    public static function ActionIndex()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $paginationManager = new PaginationManager($page, parent::ActionCount1(self::getInstanceManager()), 4);
       // $offset  = $paginationManager->getPaginationDetails()['limitMin'];
        $offset  = 4;

        $data = parent::ActionIndex1(self::getInstanceManager(), 4, 0);

        self::render(self::$action, self::getViewName(__FUNCTION__), array('data' => $data, 'pagination' => $paginationManager));//
    }

    public static function ActionDelete()
    {
        parent::ActionDelete1(self::getInstanceManager());
        header('Location: /users/index');
    }

    public static function ActionShow($param)
    {
        $data = parent::ActionShow1(self::getInstanceManager(), array('id' => $param['id']));
        parent::render(self::$action, self::getViewName(__FUNCTION__), array('data' => $data));
    }

    public static function ActionUpdate($param)
    {
        $entity = self::getInstanceManager()->findBy(array('id' => $param['id']));
        $validate = 0;
        if ($param['id'] > 0) {
            $validate = new UsersValidator($param, $entity->getFirstname(), $entity->getId());
        }
        $usersForm = new UsersForm($entity, $validate->getErrors());
        parent::render(self::$action, 'update', array('data' => $entity, 'errors' => $validate->getErrors(), 'form' => $usersForm));
    }

    public static function ActionAdd($entity, $errors = array())
    {
        if (empty($entity)) {
            $entity = self::getInstanceEntity();
        }
        $usersForm = new UsersForm($entity, $errors);
        parent::render(self::$action, 'update', array('data' => $entity, 'errors' => $errors, 'form' => $usersForm));
    }

    public static function ActionCreate()
    {
        $entity = self::getInstanceEntity();
        $validate = self::getInstanceValidator($_POST, array($_POST['age']));
        ObjectHelper::hydrate($entity, $_POST, ['id', 'firstname', 'lastname', 'age']);
        if ($validate->Validate()) {
            $data = self::getInstanceManager()->save($entity);
            self::ActionShow(array('id' => $data->getId()));
        } else {
            self::ActionAdd($entity, $validate->getErrors());
        }
    }
}