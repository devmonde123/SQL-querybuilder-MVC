<?php
/**
 * Created by PhpStorm.
 * User: abmes
 * Date: 04.09.2019
 * Time: 22:59
 */

namespace App\Modules\Users\Forms;
use App\Modules\AbstractForm;

class UsersForm extends AbstractForm{

    public function __construct($data, $errors)
    {
        parent::__construct($data,$errors);
    }
}