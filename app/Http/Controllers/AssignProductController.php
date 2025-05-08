<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Engineer;
use App\Http\Requests\AssignProductRequest;
use Illuminate\Http\JsonResponse;

class AssignProductController extends Controller
{

    /** It assigns a product to an engineer based on 
     *  the provided request data and returns a JSON response indicating success.
     */
    public function __invoke(AssignProductRequest $request, Engineer $engineer): JsonResponse
    {
        $engineer->products()->attach($request->product_id);

        return response()->json([
            'message' => 'Product assigned to engineer sucessfuly'
        ]);
    }
}
