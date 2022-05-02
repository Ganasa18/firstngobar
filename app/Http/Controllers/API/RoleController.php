<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use \Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $name = $request->input('role');

        // Cek jika id tidak kosong 
        if ($id) {
            $role = Role::find($id);
            if ($role)
                return ResponseFormatter::success($role, 'Data berhasil di dapatkan');
            else
                return ResponseFormatter::error(
                    null,
                    'Data produk tidak ada',
                    404
                );
        }

        // Cek dengan query params
        $role = Role::query();
        if ($name)
            $role->where('role', 'like', '%' . $name . '%');

        return ResponseFormatter::success(
            $role->paginate($limit),
            'Data list role berhasil di dapatkan'
        );
    }



    public function create(Request $request)
    {

        try {
            $validator =  Validator::make($request->all(), [
                'role' => 'required',
            ]);

            // check jika validasi tidak valid
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 500);
            }

            // create data jika validasi valid
            $role = Role::create([
                'role' => $request->role,
            ]);

            return ResponseFormatter::success([
                $role,
            ], 'Role Created');

            // Jika error tampilkan catch error
        } catch (Exception $error) {
            return response()->json(['error' => $error], 500);
        }
    }



    public function update(Request $request, $id)
    {

        $role = Role::find($id);
        // Check role id ditemukan
        if ($role) {
            $role->role = $request->role;
            // Simpan perubahan setalah id ditemukan
            $role->save();
            return ResponseFormatter::success($role, 'Data berhasil di ubah');
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
            $role = Role::findorfail($id);
            $role->delete();
            return ResponseFormatter::success($role, 'Data berhasil di hapus');
        } catch (ModelNotFoundException $e) {
            return ResponseFormatter::error(
                null,
                'something wrong',
                404
            );
        }



        // if ($role->count() > 0) {

        //     return response()->json(['error' => $role->count()], 200);
        // } else {

        //     return response()->json(['error' => 'something wrong'], 500);
        // }



        // try {

        //     $role = Role::find($id);
        //     return response()->json(['error' => $role], 500);
        //     // Check role id ditemukan
        //     // if ($role) {

        //     //     return ResponseFormatter::success('Data tidak ditemukan');
        //     // }

        //     // return ResponseFormatter::success([], 'Role berhasil di hapus');
        // } catch (Exception $error) {
        //     return response()->json(['error' => $error], 500);
        // }

        // $role = Role::find($id);
        // // Check role id ditemukan
        // if ($role) {

        //     return ResponseFormatter::success('Data berhasil di hapus');
        // } else {
        //     // Tampilkan error 
        //     return ResponseFormatter::error(
        //         null,
        //         'Data produk tidak ada',
        //         404
        //     );
        // }
    }
}