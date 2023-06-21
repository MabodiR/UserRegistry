<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;
use App\User;

class UserListing extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Listing::orderBy('created_at', 'desc')->get();
        return view('user-listings.index', compact('users'));
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Listing::findOrFail($id);

        return view('user-listings.show')->with('user', $user);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users',
            'position' => 'required',
        ], [
            'position.required' => 'Please enter your current position.',
        ]);
    
        $user = new Listing;
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->email = $request->input('email');
        $user->position = $request->input('position');
        $user->save();

        return redirect()->back();

    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Listing::findOrFail($id);
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->email = $request->input('email');
        $user->position = $request->input('position');
        $user->save();
    
        return redirect()->route('user-listings.show', ['id' => $user->id])->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Listing::findOrFail($id);
        $user->delete();
    
        // Return a JSON response indicating success
        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}
