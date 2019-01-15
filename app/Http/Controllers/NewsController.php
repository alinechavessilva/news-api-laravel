<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;

class NewsController extends BaseController
{
    public function index(){
        return $this->sendResponse(News::orderBy('id', 'desc')
            ->get(), 'News retrieved successfully.');

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

            return $this->sendResponse($news, 'News created successfully.');
        }

        return $this->sendError('Error creating news', 'Error creating news');

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

            return $this->sendResponse($news, 'News updated successfully.');
        }

        return $this->sendError('Error updating news', 'Error updating news');

    }

    public function destroy($id){

        $news = News::find($id);

        if($news->delete()){

            return $this->sendResponse('News deleted successfully', 'News deleted successfully.');
        }

        return $this->sendError('Error updating news', 'Error updating news');

    }
}
