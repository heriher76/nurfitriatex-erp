<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('manage constant unit'))
        {
            $categories = Category::get();

            return view('categories.index', compact('categories'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('create constant unit'))
        {
            return view('categories.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    public function store(Request $request)
    {
        if(\Auth::user()->can('create constant unit'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|max:20',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $category             = new Category();
            $category->name       = $request->name;
            $category->save();

            return redirect()->route('categories.index')->with('success', __('Category successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function edit($id)
    {
        if(\Auth::user()->can('edit constant unit'))
        {
            $category = Category::find($id);

            return view('categories.edit', compact('category'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    public function update(Request $request, $id)
    {
        if(\Auth::user()->can('edit constant unit'))
        {
            $category = Category::find($id);
            
            $validator = \Validator::make(
                $request->all(), [
                                    'name' => 'required|max:20',
                                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $category->name = $request->name;
            $category->save();

            return redirect()->route('categories.index')->with('success', __('Category successfully updated.'));
            
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if(\Auth::user()->can('delete constant unit'))
        {
            $category = Category::find($id);
        
            $category->delete();

            return redirect()->route('categories.index')->with('success', __('Category successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
