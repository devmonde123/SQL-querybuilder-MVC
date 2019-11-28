<?php

namespace App\Modules\Users\Managers;

use App\Modules\AbstractManager;
use Symfony\Component\Yaml\Yaml;

use App\Modules\Category\CategoryEntity;
use App\Modules\Category\Managers\CategoryManager;

class UsersManager extends AbstractManager
{
    public function __construct()
    {
        $this->form_cols = Yaml::parseFile(dirname(__DIR__).'/config/form.yaml');
        parent::__construct();
    }

    public function getClass()
    {
        return dirname(__NAMESPACE__).DIRECTORY_SEPARATOR.$this->getEntity();
    }

    public function getTable()
    {
        return 'users';
    }

    public function getEntity()
    {
        return 'UsersEntity';
    }

    public static function getInstanceManager():self
    {
        return new self();
    }
}