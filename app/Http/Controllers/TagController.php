<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();

        return response()->json([
            'success' => true,
            'message' =>'List Tag',
            'data'    => $tags
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tag_name'   => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Tag Name tidak boleh kosong!',
                'data'   => $validator->errors()
            ],401);

        } else {

            $tag = Tag::create([
                'tag_name' => $request->input('tag_name')
            ]);

            if ($tag) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tag Berhasil Disimpan!',
                    'data' => $tag
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Tag Gagal Disimpan!',
                ], 400);
            }

        }
    }

    public function show($id)
    {
        $tag = Tag::select("*")
                    ->where("tag_id",$id)
                    ->get();

        if ($tag) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Tag!',
                'data'      => $tag
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tag Tidak Ditemukan!',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {   
        // var_dump($request->all());
        $validator = Validator::make($request->all(), [
            'tag_name'   => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Tag Name Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);

        } else {

            $tag = Tag::where('tag_id',$id)->update([
                'tag_name' => $request->input('tag_name')
            ]);

            if ($tag) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tag Berhasil Diupdate!',
                    'data' => $tag
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Tag Gagal Diupdate!',
                ], 400);
            }
        }
    }

    public function destroy($id)
    {
        $tag = Tag::where('tag_id',$id)->delete();

        if ($tag) {
            return response()->json([
                'success' => true,
                'message' => 'Tag Berhasil Dihapus!',
            ], 200);
        }

    }
}
