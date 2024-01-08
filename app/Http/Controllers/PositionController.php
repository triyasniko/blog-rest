<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::all();

        return response()->json([
            'success' => true,
            'message' =>'List Category',
            'data'    => $positions
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'position_name'   => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Position Name tidak boleh kosong!',
                'data'   => $validator->errors()
            ],401);

        } else {

            $position = Position::create([
                'position_name' => $request->input('position_name')
            ]);

            if ($position) {
                return response()->json([
                    'success' => true,
                    'message' => 'Position Berhasil Disimpan!',
                    'data' => $position
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Position Gagal Disimpan!',
                ], 400);
            }

        }
    }

    public function show($id)
    {
        $position = Position::select("*")
                    ->where("position_id",$id)
                    ->get();

        if ($position) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Posisi!',
                'data'      => $position
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Posisi Tidak Ditemukan!',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {   
        // var_dump($request->all());
        $validator = Validator::make($request->all(), [
            'position_name'   => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Position Name Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);

        } else {

            $position = Position::where('position_id',$id)->update([
                'position_name' => $request->input('position_name')
            ]);

            if ($position) {
                return response()->json([
                    'success' => true,
                    'message' => 'Posisi Berhasil Diupdate!',
                    'data' => $position
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Posisi Gagal Diupdate!',
                ], 400);
            }
        }
    }

    public function destroy($id)
    {
        $position = Position::where('position_id',$id)->delete();

        if ($position) {
            return response()->json([
                'success' => true,
                'message' => 'Posisi Berhasil Dihapus!',
            ], 200);
        }

    }
}
