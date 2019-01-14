<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(){
        return Response()->json(News::orderBy('id', 'desc')->get(), 200);
    }

    public function store(Request $request){

        $news = new News();
        $news->title = $request->input('title');
        $news->slug = $request->input('slug');
        $news->content = $request->input('content');
        $news->category_id = $request->input('category_id');
        $news->thumbnail = $request->input('thumbnail');
        $news->author = $request->input('author');

        if($news->save()){
            return Response("1",201);
        }
        else{
            return Response("0",304);
        }
    }

    public function update($id, Request $request){

        $news = News::find($id);
        $news->title = $request->input('title');
        $news->slug = $request->input('slug');
        $news->content = $request->input('content');
        $news->category_id = $request->input('category_id');
        $news->thumbnail = $request->input('thumbnail');
        $news->author = $request->input('author');

        if($news->save()){
            return Response()->json($news, 201);
        }
        else{
            return Response("0",304);
        }
    }

    public function destroy($id){

        $news = News::find($id);

        if($news->delete()){
            return Response("1",200);
        }
        else{
            return Response("0",304);
        }
    }
}
