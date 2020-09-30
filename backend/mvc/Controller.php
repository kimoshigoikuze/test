<?php

namespace Mvc;

use App\Models\User;

abstract class Controller
{
    protected $request = [];

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function __call($method, $args)
    {
        method_exists($this, $method) ?
            call_user_func_array([$this, $method], $args)
            :
            die("Method $method not found in controller " . get_class($this));
    }

    protected function redirect($path = '')
    {
        if (!empty($path)) header("Location: $path", true, 301); exit;
    }

    protected function post($except = [])
    {
        if ($this->request['REQUEST_METHOD'] === 'GET') {
            if ($except) {
                $routes = implode(' ', $except);
                if (strpos($routes, strtok($this->request["REQUEST_URI"], '?')) !== false) {
                    return true;
                }
            }
            return $this->redirect('/');
        }
    }

    protected function json($data = [], $status = 200, $success = true, $message = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
            header('Access-Control-Allow-Headers: token, Content-Type');
            header('Access-Control-Max-Age: 1728000');
            header('Content-Length: 0');
            header('Content-Type: text/plain');
            die();
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode(['success' => $success, 'payload' => $data, 'message' => $message], TRUE);
    }
}
