<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();

        return response()->json([
            'success' => true,
            'message' =>'List Category',
            'data'    => $category
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name'   => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Category Name tidak boleh kosong!',
                'data'   => $validator->errors()
            ],401);

        } else {

            $category = Category::create([
                'category_name' => $request->input('category_name')
            ]);

            if ($category) {
                return response()->json([
                    'success' => true,
                    'message' => 'Category Berhasil Disimpan!',
                    'data' => $category
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Category Gagal Disimpan!',
                ], 400);
            }

        }
    }

    public function show($id)
    {
        $category = Category::select("*")
                    ->where("category_id",$id)
                    ->get();

        if ($category) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Category!',
                'data'      => $category
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Category Tidak Ditemukan!',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {   
        // var_dump($request->all());
        $validator = Validator::make($request->all(), [
            'category_name'   => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Category Name Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);

        } else {

            $category = Category::where('category_id',$id)->update([
                'category_name' => $request->input('category_name')
            ]);

            if ($category) {
                return response()->json([
                    'success' => true,
                    'message' => 'Category Berhasil Diupdate!',
                    'data' => $category
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Category Gagal Diupdate!',
                ], 400);
            }
        }
    }

    public function destroy($id)
    {
        $category = Category::where('category_id',$id)->delete();

        if ($category) {
            return response()->json([
                'success' => true,
                'message' => 'Category Berhasil Dihapus!',
            ], 200);
        }

    }
}
