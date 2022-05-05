<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use \Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    public function all(Request $request)
    {

        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $name = $request->input('category');

        // Cek jika id tidak kosong 
        if ($id) {
            $category = Category::find($id);
            if ($category)
                return ResponseFormatter::success($category, 'Data berhasil di dapatkan');
            else
                return ResponseFormatter::error(
                    null,
                    'Data tidak ditemukan',
                    404
                );
        }
        // Cek dengan query params
        $role = Category::query();
        if ($name)
            $role->where('category', 'like', '%' . $name . '%');

        return ResponseFormatter::success(
            $role->paginate($limit),
            'Data list category berhasil di dapatkan'
        );
    }
}
