<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TheRestartProject\RepairDirectory\Domain\Enums\Category;

class CategoryController extends Controller
{
    public function list(Request $request)
    {
        $c = new \ReflectionClass(Category::class);
        $categories = $c->getConstants();

        return [
            'categories' => array_values($categories)
        ];
    }
}
