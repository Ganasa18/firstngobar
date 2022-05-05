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


    public function create(Request $request)
    {
        try {
            $validator  = Validator::make($request->all(), [
                'category' => 'required',
            ]);


            // check jika validasi tidak valid
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 500);
            }

            // create data jika validasi valid
            $category = Category::create([
                'category' => $request->category,
            ]);
            return ResponseFormatter::success([
                $category,
            ], 'Category Created');

            // jika error tampilkan catch error
        } catch (Exception $error) {
            return response()->json(['error' => $error], 500);
        }
    }


    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        // check jika id ditemukan
        if ($category) {
            $category->category = $request->category;
            // Simpan perubahan setelah id ditemukan
            $category->save();
            return ResponseFormatter::success($category, 'Data berhasil di ubah');
        } else {
            // Tampilkan error 
            return ResponseFormatter::error(
                null,
                'Data produk tidak ada',
                404
            );
        }
    }


    public function delete(Request $request, $id)
    {
        try {
            $category = Category::findorfail($id);
            $category->delete();
            return ResponseFormatter::success($category, 'Data berhasil di hapus');
        } catch (ModelNotFoundException $e) {
            return ResponseFormatter::error(
                null,
                'something wrong',
                404
            );
        }
    }
}