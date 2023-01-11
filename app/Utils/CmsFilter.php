<?php

namespace App\Utils;

use Throwable;

class CmsFilter
{
    protected $fields = [];
    protected $route = null;
    protected $model = null;
    protected $buttons = [];

    public function __construct($model, $route)
    {
        $this->route = route($route);
        $this->model = new $model();
    }

    public function addField($field, $placeholder, $type = 'input')
    {
        $this->fields[] = [
            'name' => $field,
            'placeholder' => $placeholder,
            'type' => $type
        ];

        return $this;
    }

    public function render()
    {
        $data = [
            'route' => $this->route,
            'fields' => $this->fields,
            'request' => request()->all(),
            'buttons' => $this->buttons
        ];
        $view = view('cms.partials.filter', $data);

        try {
            return $view->render();
        } catch (Throwable $e) {
            return "";
        }
    }

    public function addButton($name, $route)
    {
        $this->buttons[] = [
            'name' => $name,
            'route' => route($route)
        ];

        return $this;
    }
}