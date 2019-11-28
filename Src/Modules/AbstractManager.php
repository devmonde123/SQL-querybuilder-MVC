<?php
/**
 * Created by PhpStorm.
 * User: abmes
 * Date: 18.08.2019
 * Time: 18:26
 */

namespace App\Modules;

use App\Database\DatabasePdo;
use App\Database\QueryBuilder;
use PDO;
use App\Modules\Users\UsersEntity;

abstract class AbstractManager
{
    protected $bdd;
    protected $table;
    protected $entity;
    protected $query_select;
    protected $queryBuilder;
    protected $form_cols;
    protected $yaml;

    protected abstract function getClass();

    protected abstract function getTable();
    /**
     * Users constructor.
     */
    public function __construct()
    {
        $this->bdd = (new DatabasePdo)->getPdo();
        $this->table = strtolower(get_class($this)::getTable());
        $this->class = get_class($this);
        $this->manager = array_values(array_slice(explode('\\',$this->class), -1))[0];
        $this->namespace = get_class($this)::getClass();
        $this->entity = array_values(array_slice(explode('\\',$this->namespace), -1))[0];
        $this->queryBuilder = new QueryBuilder();
        $this->query_select = $this->queryBuilder->select('*')
            ->from($this->table);
    }

    public function all($limit = 200, $offset = 0)
    {
        $this->query_select
            ->orderBy('id', 'ASC')
            ->limit($limit)
            ->offset($offset);
        return $this->query_select->fetchAll();
    }

    public function list($field='name')
    {
        $items = $this->query_select
            ->select('id',$field)
            ->from('categories')
            ->orderBy($field, 'ASC')->fetchAll();
        $results = [];
        foreach($items as $item){
            $results[$item['id']] = $item[$field];
        }
        return $results;
    }

    public function limit($limit)
    {
        $this->query_select->limit($limit);
    }

    public function offset(int $offset)
    {
        $this->query_select->offset($offset);
    }

    public function orderBy($col, $sort = 'ASC')
    {
        $this->query_select->orderBy($col, $sort);
    }

    public function count()
    {
        $q = $this->query_select->from($this->table);
        return $q->count($this->bdd);
    }

    public function findBy($param)
    {
        $column = array_keys($param)[0];
        $item = $this->query_select
            ->where("$column = :$column")
            ->setParam("$column", $param[$column])
            ->fetchByOne( $this->namespace);
        if ($item === false) {
            return null;
        } else {
            return $item;
        }
    }

    public function delete(int $id)
    {
        $pdoStatemet = $this->bdd->prepare('delete from ' . $this->table . ' where id= :id limit 1');
        $pdoStatemet->bindValue(':id', $id, PDO::PARAM_INT);
        return $pdoStatemet->execute();
    }

    public function exists($feld, $value, ?array $except = null)
    {
        $query = "select count(*) from " . $this->table . " where $feld= ?";
        $params = [$value];
        if ($except[1] > 0) {
            $query .= " and id != ? ";
            $params[] = $except;
        }
        $pdoStatemet = $this->bdd->prepare($query);
        $pdoStatemet->execute($params);
        return $pdoStatemet->fetch(PDO::FETCH_NUM)[0] > 0;
    }


    //categorieEntity
    public function save(&$object)
    {
        if (is_null($object->getId()) || $object->getId() == 0) {
            return $this->create($object);
        } else {
            return $this->update($object);
        }
    }

    //CategoryEntity
    private function create($object)
    {
        $pdoStatemet = $this->bdd->prepare("insert into " . $this->table . " values(NULL, ".$this->getInsertValues().")");//:nom, :prenom, :age
        $excuteIsOk = $this->bind($pdoStatemet, $object)->execute();
        if (!$excuteIsOk) {
            return false;
        } else {
            $id = $this->bdd->lastInsertId();
            return $this->query_select
                ->where("id = :id")
                ->setParam("id", $id)
                ->fetchByOne($this->namespace);
        }
    }

    //CategoryEntity
    private function update($object)
    {
        $pdoStatemet = $this->bdd->prepare('update ' . $this->table .' set '. $this->getUpdate() .' where id=:id limit 1');
        if ($this->bind($pdoStatemet, $object)->execute()) {
            return $this->query_select
                ->where("id = :id")
                ->setParam("id", $object->getId())
                ->fetchByOne($this->namespace);
        } else
            return false;
    }

    //CategoryEntity
    private function bind(\PDOStatement $pdoStatemet, $object): \PDOStatement
    {
        if ($object->getId() != '')
            $pdoStatemet->bindValue(":id", $object->getId());
        foreach ($this->form_cols['create'] as $col) {
            $attr = "get" . str_replace('_','',ucfirst($col));
            $pdoStatemet->bindValue(":$col", $object->{$attr}());
        }
        return $pdoStatemet;
    }

    public function getUpdate()
    {
        $update = '';
        foreach($this->form_cols['update'] as $attr)
            $update .= " $attr=:$attr ,";
        return substr($update,0,-1);
    }

    public function getInsertValues()
    {
        $insert = '';
        foreach($this->form_cols['create'] as $attr)
            $insert .= " :$attr ,";
        return substr($insert,0,-1);
    }
}