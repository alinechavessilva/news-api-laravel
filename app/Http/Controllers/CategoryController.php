<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;

class CategoryController extends BaseController
{
    public function index(){

       return $this->sendResponse(Category::orderBy('id', 'desc')
                                    ->get(), 'Categories retrieved successfully.');
    }

    public function store(Request $request){

        $category = new Category();
        $category->name = $request->input('name');
        $category->slug = $request->input('slug');

        if($category->save()){
            return Response("1",201);
        }
        else{
            return Response("0",304);
        }
    }

    public function update($id, Request $request){

        $category = Category::find($id);
        $category->name = $request->input('name');
        $category->slug = $request->input('slug');

        if($category->save()){
            return Response()->json($category, 201);
        }
        else{
            return Response("0",304);
        }
    }

    public function destroy($id){

        $category = Category::find($id);

        if($category->delete()){
            return Response("1",200);
        }
        else{
            return Response("0",304);
        }
    }
}
