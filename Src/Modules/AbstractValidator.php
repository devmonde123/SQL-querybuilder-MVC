<?php
/**
 * Created by PhpStorm.
 * User: abmes
 * Date: 18.08.2019
 * Time: 18:26
 */

namespace App\Modules;

use Valitron\Validator;

abstract class AbstractValidator
{
    protected $data;
    protected $validator;

    /**
     * Validator constructor.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->validator = new Validator($data);
    }

    public function Validate(): bool
    {
        return $this->validator->validate();
    }

    public function getErrors(): array
    {
        return $this->validator->errors();
    }

}