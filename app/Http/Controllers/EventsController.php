<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\FavouriteEvent;
use App\Notifications\EventNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

use Auth;

class EventsController extends Controller
{
    //

    //show all events page
    public function index() {
        $events = Event::get();

        return view('events.index')->with('events', $events);
    }

    //show create new event page
    public function create() {
        return view('events.create');
    }

    //save new event info from create new event form
    public function store(Request $request){
      
        $this->validate($request, [
            'name' => 'required',
            'dateTime' => 'required|date_format:Y-m-d H:i:s',
            'location' => 'required',
            'description' => 'required',
            'image' => 'required|image',
        ]);

       
        $filenameWithExtension = $request->file('image')->getClientOriginalName();
        $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
        $extension = $request->file('image')->getClientOriginalExtension();
        $filenameToStore = $filename . '_' . time() . '.' . $extension;

        $path = $request->file('image')->storeAs('/public/events', $filenameToStore);  
        
        $user = User::all();

        $event = new Event();
        $event->name = $request->input('name');
        $event->dateTime = $request->input('dateTime');
        $event->location = $request->input('location');
        $event->description = $request->input('description');
        $event->image = $filenameToStore;

        $event->save();
        Notification::send($user, new EventNotification($request->name));
       

        return redirect('/events')->with('success', 'Event created successfully!');
  

        
    }

        //show full details of a specific event
        public function show($id)
        {
            $event = Event::find($id);
            //$user = User::find($id);
    
            return view('events.show')->with('event', $event);
        }
    
        //delete an event
        public function destroy($id){
            $event = Event::find($id);
    
            if(Storage::delete('/public/events/'.$event->image)) {
                
                $event->delete();
    
                return redirect('/events')->with('success', 'Event deleted successfully!');
            }
        }



        public function addToFav(Request $req)
    {
        if(Gate::allows('logged-in'))
        {
            
            $favourite = new FavouriteEvent;
            $favourite->user_id=$req->user()->id; 
            $favourite->event_id=$req->event_id;
            $favourite->save();
            return redirect('/');
        }

    }

    public function favList() 
    {
        $userId = auth()->user()->id;//->id;
        $events = DB::table('favourite_events')
        ->join('events','favourite_events.event_id','=','events.id')
        ->where('favourite_events.user_id',$userId)
        ->select('events.*','favourite_events.id as fav_id')
        ->groupBy('favourite_events.event_id')
        ->get();

        return view('eventfavlist',['events' => $events]);

    } 
    
    function removeFav($id)
    {
        FavouriteEvent::destroy($id);
        return redirect('eventfavlist');
    }

    public function notify()
    {
        if(auth()->user()){
        $user = User::all();

        auth()->user()->notify(new EventNotification($user));
        }
    }



}
