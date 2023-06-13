<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function json(array|object $data, int $status = 200)
    {
        $defaults = ['error' => null, 'message' => null];
        //if (is_object($data)) $data = (array($data));
        return response()->json(array_merge($defaults, $data), $status);
    }
}
