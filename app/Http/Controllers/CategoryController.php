<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
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

            return $this->sendResponse($category, 'Category created successfully.');
        }

        return $this->sendError('Error creating category', 'Error creating category');


    }

    public function update($id, Request $request){

        $category = Category::find($id);
        $category->name = $request->input('name');
        $category->slug = $request->input('slug');

        if($category->save()){

            return $this->sendResponse($category, 'Categories updated successfully.');
        }

        return $this->sendError('Error updating category', 'Error updating category');

    }

    public function destroy($id){

        $category = Category::find($id);

        if($category->delete()){

            return $this->sendResponse('Category deleted successfully', 'Category deleted successfully.');
        }

        return $this->sendError('Error updating category', 'Error updating category');

    }
}
