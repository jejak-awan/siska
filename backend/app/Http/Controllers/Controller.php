<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Base Controller untuk SISKA Backend System
 * 
 * @package App\Http\Controllers
 * @author jejakawan.com
 * @supported K2NET - PT. Kirana Karina Network
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
