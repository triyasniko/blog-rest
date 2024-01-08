<?php

namespace App\Http\Controllers;

use App\Models\CompanySector;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CompanySectorController extends Controller
{
    public function index()
    {
        $company = CompanySector::all();

        return response()->json([
            'success' => true,
            'message' =>'List Category',
            'data'    => $company
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'companysector_name'   => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Company Sector Name tidak boleh kosong!',
                'data'   => $validator->errors()
            ],401);

        } else {

            $company = CompanySector::create([
                'companysector_name' => $request->input('companysector_name')
            ]);

            if ($company) {
                return response()->json([
                    'success' => true,
                    'message' => 'Company Sector Berhasil Disimpan!',
                    'data' => $company
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Company Sector Gagal Disimpan!',
                ], 400);
            }

        }
    }

    public function show($id)
    {
        $company = CompanySector::select("*")
                    ->where("companysector_id",$id)
                    ->get();

        if ($company) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Company Sector!',
                'data'      => $company
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Company Sector Tidak Ditemukan!',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {   
        // var_dump($request->all());
        $validator = Validator::make($request->all(), [
            'companysector_name'   => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Company Sector Name Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);

        } else {

            $company = CompanySector::where('companysector_id',$id)->update([
                'companysector_name' => $request->input('companysector_name')
            ]);

            if ($company) {
                return response()->json([
                    'success' => true,
                    'message' => 'Company Sector Berhasil Diupdate!',
                    'data' => $company
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Company Sector Gagal Diupdate!',
                ], 400);
            }
        }
    }

    public function destroy($id)
    {
        $company = CompanySector::where('companysector_id',$id)->delete();

        if ($company) {
            return response()->json([
                'success' => true,
                'message' => 'Company Sector Berhasil Dihapus!',
            ], 200);
        }

    }
}
