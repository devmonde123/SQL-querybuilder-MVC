<?php
/**
 * Created by PhpStorm.
 * User: abmes
 * Date: 15.09.2019
 * Time: 16:47
 */

namespace App\Modules;


class AbstractForm
{
    private $data;

    private $errors;

    public function __construct($data, array $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    public function input(string $key, string $label): string
    {
        $value = $this->getValue($key);
        return <<<HTML
          <div class="form-group">
            <label for="field{$key}">{$label}</label>
            <input type="text" id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}" value="{$value}" required>
            {$this->getErrorFeedback($key)}
        </div>
HTML;
    }

    public function select(string $key, string $label, $options = [], $selected = []): string
    {
        $optionsHTML = [];
        foreach ($options as $k => $v) {
            $select='';
            isset($selected[$k]) ? $select = ' selected ' : '';
            $optionsHTML[] = "<option value=\"$k\" $select>$v</option>";
        }
        $value = $this->getValue($key);
        $optionsHTML = implode('',$optionsHTML);
        return <<<HTML
          <div class="form-group">
            <label for="field{$key}">{$label}</label>
            <select id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}" multiple required>
                {$optionsHTML}
            </select>
            {$this->getErrorFeedback($key)}
        </div>
HTML;
    }

    public function inputHidden(string $key, string $label): string
    {
        $value = $this->getValue($key);
        return <<<HTML
            <input type="hidden" id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}" value="{$value}" >
        </div>
HTML;
    }

    public function textarea(string $key, string $label): string
    {
        $value = $this->getValue($key);
        return <<<HTML
          <div class="form-group">
            <label for="field{$key}">{$label}</label>
            <textarea type="text" id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}" required>{$value}</textarea>
            {$this->getErrorFeedback($key)}
        </div>
HTML;
    }

    private function getValue(string $key)//: ?string
    {
        if (is_array($this->data)) {
            return $this->data[$key] ?? null;
        }
        $method = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
        $value = $this->data->$method(); 
        return $value;
    }

    private function getInputClass(string $key): string
    {
        $inputClass = 'form-control';
        if (isset($this->errors[$key])) {
            $inputClass .= ' is-invalid';
        }
        return $inputClass;
    }

    private function getErrorFeedback(string $key): string
    {
        if (isset($this->errors[$key])) {
            return '<div class="invalid-feedback">' . implode('<br>', $this->errors[$key]) . '</div>';
        }
        return '';
    }
}

