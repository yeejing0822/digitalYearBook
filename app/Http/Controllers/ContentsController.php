<?php

namespace App\Http\Controllers;
use App\Models\Content;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentsController extends Controller
{
    //

    //'create Content within a specific album' page 
    public function create(int $categoryId) {
        return view('contents.create')->with('categoryId', $categoryId);
    }

    //save new content info from create new content form
    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            //'image' => 'required|image',
        ]);

       
        $filenameWithExtension = $request->file('image')->getClientOriginalName();
        $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
        $extension = $request->file('image')->getClientOriginalExtension();
        $filenameToStore = $filename . '_' . time() . '.' . $extension;

        $path = $request->file('image')->storeAs('/public/categories/' . $request->input('category-id'), $filenameToStore);  


        $content = new Content();
        $content->title = $request->input('title');
        $content->description = $request->input('description');
        $content->image = $filenameToStore;
        $content->role_id = $request->input('role-id');
        $content->category_id = $request->input('category-id');
        $content->save();


        return redirect('/categories/' . $request->input('category-id'))->with('success', 'Content created successfully!');
    }

    //show full details of a specific content
    public function show($id)
    {
        $content = Content::find($id);
        $user = User::find($id);

        return view('contents.show')->with('content', $content);
    }

    //delete an content
    public function destroy($id){
        $content = Content::find($id);

        if(Storage::delete('/public/categories/'.$content->category_id.'/'.$content->image)) {
            $content->delete();

            return redirect('/')->with('success', 'Content deleted successfully!');
        }
    }
}
    