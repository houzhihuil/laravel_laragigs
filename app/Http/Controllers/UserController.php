<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use PhpParser\Node\Expr\List_;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Show Register/Create Form
    public function create() {
        return view('users.register');
    }

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    // Create New User
    public function store(Request $request) {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        // Create User
        $user = User::create($formFields);

        // Login
        auth()->login($user);

        return redirect('/listings/')->with('message', 'User created and logged in');
    }

    // Logout User
    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/listings/')->with('message', 'You have been logged out!');

    }

    // Show Login Form
    public function login() {
        return view('users.login');
    }

    // Authenticate User
    public function authenticate(Request $request) {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/listings/')->with('message', 'You are now logged in!');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    } 
 
    public function index() {

        $users = User::latest()->paginate(8); 
          return view('users.index',compact('users'))
              ->with('i', (request()->input('page', 1) - 1) * 8);
       /*  return view('users.index', [ 
            'users' =>User::all()
        ]
        ); */
    }  

    public function show($id)
    {
        return view('users.show', [
            'user' => User::findOrFail($id)
        ]);
    }
    // Show Edit Form
 
    public function edit(Request $request, User $user)
    {
         
    
        $user->update($request->all());
    
        return redirect('/users')
                        ->with('success','User updated successfully');
    }
    // delete user
    public function destroy($id) { 
        
        User::find($id)->delete(); 
        return redirect('/users') ->with('message', 'User deleted successfully');  
    }

}
