<?php
/**
 * Created by PhpStorm.
 * User: abmes
 * Date: 04.09.2019
 * Time: 22:59
 */

namespace App\Modules\Users\Validators;

use App\Modules\AbstractValidator;
use App\Modules\Users\Managers\UsersManager;


class UsersValidator extends AbstractValidator
{
    private $usersManager;
    public function __construct(array $data, $value,?int $id = null)
    {

        $this->usersManager = new UsersManager();
        parent::__construct($data);
        $this->validator->rule('requiredWithout', 'id');
        $this->validator->rule('required', 'firstname');
        $this->validator->rule('required', 'lastname');
        $this->validator->rule('required', 'age');
        $this->validator->rule('lengthBetween', 'age', 1,100);
    }

    public static function getInstanceValidator($data, $fields):self
    {
        return new UsersValidator($data, $fields);
    }
}