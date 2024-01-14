<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class JobApplicationController extends Controller
{
    public function index()
    {
        $jobs = DB::table('jobapplications')
        ->join('positions', 'jobapplications.position_id', '=', 'positions.position_id')
        ->join('company_sectors', 'jobapplications.companysector_id', '=', 'company_sectors.companysector_id')
        ->select('jobapplications.application_id','jobapplications.user_id', 'jobapplications.job_title', 'jobapplications.position_id', 'jobapplications.company_name', 'jobapplications.companysector_id', 'jobapplications.application_date', 'jobapplications.status', 'positions.position_name', 'company_sectors.companysector_name')
        ->where('user_id',auth()->user()->user_id)
        ->get();

        return response()->json([
            'success' => true,
            'message' =>'List Job',
            'data'    => $jobs
        ], 200);
    }

    public function store(Request $request)
    {
        // return response()->json([
        //     'message'=>'Masuk broo'
        // ],200);
        // exit();
        $validator = Validator::make($request->all(), [
            'job_title'   => 'required',
            'application_date' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Job Title/Application Date tidak boleh kosong!',
                'data'   => $validator->errors()
            ],401);

        } else {

            $job = JobApplication::create([
                'user_id' => auth()->user()->user_id,
                'job_title' => $request->input('job_title'),
                'position_id'  => $request->input('position_id'),
                'company_name' => $request->input('company_name'),
                'companysector_id' => $request->input('companysector_id'),  
                'application_date' => $request->input('application_date'),
                'status' => $request->input('status'),
            ]);

            if ($job) {
                $notification = Notification::create([
                    'user_id' => auth()->user()->user_id,
                    'notification_message' =>'Kamu berhasil menambah job application baru'
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Job Berhasil Disimpan!',
                    'data' => $job
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Job Gagal Disimpan!',
                ], 400);
            }

        }
    }
    public function show($id)
    {
        $job = JobApplication::select("*")
                    ->where("application_id",$id)
                    ->get();

        if ($job) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Job!',
                'data'      => $job
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Job Tidak Ditemukan!',
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'job_title'   => 'required',
            'application_date' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Job Title/Application Date tidak boleh kosong!',
                'data'   => $validator->errors()
            ],401);

        } else {

            $job = JobApplication::where('application_id',$id)->update([
                'job_title' => $request->input('job_title'),
                'position_id'  => $request->input('position_id'),
                'company_name' => $request->input('company_name'),
                'companysector_id' => $request->input('companysector_id'),  
                'application_date' => $request->input('application_date'),
                'status' => $request->input('status'),
            ]);

            if ($job) {
                return response()->json([
                    'success' => true,
                    'message' => 'Job Berhasil Diupdate!',
                    'data' => $job
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Job Gagal Diupdate!',
                ], 400);
            }
        }
    }

    public function destroy($id)
    {
        $job = JobApplication::where('application_id',$id)->delete();

        if ($job) {
            return response()->json([
                'success' => true,
                'message' => 'Job Berhasil Dihapus!',
            ], 200);
        }

    }
}
