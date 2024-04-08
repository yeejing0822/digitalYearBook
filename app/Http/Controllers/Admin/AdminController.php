<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Role;
use App\Actions\Fortify\CreateNewUser;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$users = User::all();

        if(Gate::denies('logged-in')){
            dd('You are not allowed to access this webpage');
        }

        if(Gate::allows('is-admin')){
            // Return the array of users
            return view('admin.users.index', ['users' => User::paginate(10)]);
        }

        dd('Only the admin can access this webpage.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create', ['roles' => Role::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        //dd($request);

        $newUser = new CreateNewUser();
        $user = $newUser->create($request->only(['name', 'email', 'password', 'password_confirmation']));

        //validates data from StoreUserRequest.php
        //$validatedData = $request->validated();
        //$user = User::create($validatedData);

        // create user without stoing the csrf token and exact role
        //$user = User::create($request->except(['_token','roles']));

        //Assign user to roles table
        $user->roles()->sync($request->roles);

        //Alert the user if the storing has successful
        $request->session()->flash('success', 'You have created the user');

        return redirect(route('admin.users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.users.edit', [
            'roles' => Role::all(),
            'user' => User::find($id)
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Search for the user, if failed turn to undefined page
        $user = User::findOrFail($id);

        //Alert the user and redirect page if the request has failed
        if(!$user){
            $request->session()->flash('error', 'You have failed to update a profile');
            return redirect(route('admin.users.index'));
        };

        // update user without stoing the csrf token and exact role
        $user->update($request->except(['_token', 'roles']));
        
        //Assign user to roles table
        $user->roles()->sync($request->roles);

        //Alert the user if the update has successful
        $request->session()->flash('success', 'You have updated the user profile');

        return redirect(route('admin.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        User::destroy($id);

        //Alert the user if the delete has successful
        $request->session()->flash('success', 'You had deleted the user!');

        return redirect(route('admin.users.index'));
    }
}
