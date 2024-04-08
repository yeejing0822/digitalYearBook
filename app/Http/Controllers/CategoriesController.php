<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Favourite;
//use App\Http\Controllers\User;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
//use Request;
use Auth;

class CategoriesController extends Controller
{
    //

    //show all categories page
    public function index() {
        $categories = Category::get();

        return view('categories.index')->with('categories', $categories);
    }

    //show create new category page
    public function create() {
        return view('categories.create');
    }

    //save new category info from create new category form
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'cover-image' => 'required|image',
        ]);

       
        $filenameWithExtension = $request->file('cover-image')->getClientOriginalName();
        $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
        $extension = $request->file('cover-image')->getClientOriginalExtension();
        $filenameToStore = $filename . '_' . time() . '.' . $extension;

        $path = $request->file('cover-image')->storeAs('/public/category_covers', $filenameToStore);  
       
        $category = new Category();
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->cover_image = $filenameToStore;

        $category->save();

        return redirect('/categories')->with('success', 'Class created successfully!');
    }

    //show all contents that existed in a specific category
    public function show($id)
    {
        $category = Category::with('contents')->find($id);

        return view('categories.show')->with('category', $category);
    }

    
    public function search()
    {
        $search_text = $_GET['query'];
        $categories = Category::where('name','LIKE','%'.$search_text.'%')->get();

        return view('categories.index', compact('categories'));
    }

    public function addToFav(Request $req)
    {
        if(Gate::allows('logged-in'))
        {


            $favourite = new Favourite;
            $favourite->user_id=$req->user()->id; 
            $favourite->category_id=$req->category_id;
            $favourite->save();
            return redirect('/');
        }

    }

    public function hasFav($item)
    {
        //return $this->favourites()->where('category_id',$item->category_id)->count() !==0;
    }
   
    static function favItem()
    {
       //$userId = auth()->user()->id;
        //return Favourite::where('category_id',$userId)->count();
     

      // return Favourite::select('category_id')->count();
       //$exists = Favourite::('category_id')->exists();
       //return view('favlist', compact('exists'));

       //return DB::table('favourites')
       //->select('category_id')
       //->groupBy('category_id')
       //->get();
        

    }

    public function favList() 
    {
        $userId = auth()->user()->id;//->id;
        $categories = DB::table('favourites')
        ->join('categories','favourites.category_id','=','categories.id')
        ->where('favourites.user_id',$userId)
        ->select('categories.*','favourites.id as fav_id')
        ->groupBy('favourites.category_id')
        ->get();

        return view('favlist',['categories' => $categories]);

    } 
    
    function removeFav($id)
    {
        Favourite::destroy($id);
        return redirect('favlist');
    }

    public function userfavList() {
        
        //$users = DB::table('favourites')
        //->join('categories','favourites.category_id','=','categories.id')
        //->join('users','favourites.user_id','=', 'users.id')


        $users = DB::table('favourites')
        ->join('categories','favourites.category_id','=','categories.id')
        ->join('users','favourites.user_id','=', 'users.id')
        ->select('users.*','categories.name as cat_name')
        //->groupBy('users.id')
        ->groupBy('categories.id')
        ->get();

       
        return view('userfavlist',['users' => $users]);

    } 

    public function sort(){

        $users = DB::table('favourites')
        ->join('categories','favourites.category_id','=','categories.id')
        ->join('users','favourites.user_id','=', 'users.id')
        ->select('users.*','categories.name as cat_name')
        //->groupBy('users.id')
        ->groupBy('categories.id')
        ->orderBy('categories.id')
        ->get();
       

        //$users= Category::select(['categories.*','categories.name as cat_name'])
        //->join('favourites','categories.id','=','favourites.category_id')
        //->orderBy('categories.id')
        //->paginate(100);

        return view('userfavlist',['users' => $users]);
    }

  



}
