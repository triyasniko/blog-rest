<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = DB::table('articles')
        ->join('categories', 'articles.category_id', '=', 'categories.category_id')
        ->join('tags', 'articles.tag_id', '=', 'tags.tag_id')
        ->select('articles.article_id','articles.user_id', 'articles.article_title', 'articles.article_description', 'categories.category_name', 'categories.category_id', 'tags.tag_id')
        ->where('user_id',auth()->user()->user_id)
        ->get();

        return response()->json([
            'success' => true,
            'message' =>'List article',
            'data'    => $articles
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'article_title'   => 'required',
            'article_description' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Article Title/Description tidak boleh kosong!',
                'data'   => $validator->errors()
            ],401);

        } else {

            $article = Article::create([
                'user_id' => auth()->user()->user_id,
                'article_title' => $request->input('article_title'),
                'article_description' => $request->input('article_description'),
                'category_id'  => $request->input('category_id'),
                'tag_id' => $request->input('tag_id'), 
            ]);

            if ($article) {
                $notification = Notification::create([
                    'user_id' => auth()->user()->user_id,
                    'notification_message' =>'Kamu berhasil menambah article baru'
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Article Berhasil Disimpan!',
                    'data' => $article
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Article Gagal Disimpan!',
                ], 400);
            }

        }
    }
    public function show($id)
    {
        $article = Article::select("*")
                    ->where("article_id",$id)
                    ->get();

        if ($article) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Article!',
                'data'      => $article
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Article Tidak Ditemukan!',
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'article_title'   => 'required',
            'article_description' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Article Title/Description Date tidak boleh kosong!',
                'data'   => $validator->errors()
            ],401);

        } else {

            $article = Article::where('article_id',$id)->update([
                'article_title' => $request->input('article_title'),
                'article_description' => $request->input('article_description'),
                'category_id' => $request->input('category_id'),
                'tag_id' => $request->input('tag_id'),  
            ]);

            if ($article) {
                return response()->json([
                    'success' => true,
                    'message' => 'Article Berhasil Diupdate!',
                    'data' => $article
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Article Gagal Diupdate!',
                ], 400);
            }
        }
    }

    public function destroy($id)
    {
        $article = Article::where('article_id',$id)->delete();

        if ($article) {
            return response()->json([
                'success' => true,
                'message' => 'Article Berhasil Dihapus!',
            ], 200);
        }

    }
}
