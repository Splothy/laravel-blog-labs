<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;

abstract class BaseController extends Controller
{
    public function __construct()
    {
        // Ініціалізація загальних елементів API блогу.
    }
}
