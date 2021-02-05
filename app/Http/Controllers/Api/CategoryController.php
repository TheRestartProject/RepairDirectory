<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TheRestartProject\RepairDirectory\Domain\Enums\Region;

class CategoryController extends Controller
{
    public function list(Request $request)
    {
        // We have a potentially different list of categories to return depending on the map region we're showing.
        $region = $request->input('region', Region::LONDON);

        return [
            'categories' => Region::CATEGORIES[$region]
        ];
    }
}
