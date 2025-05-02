<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\State;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        $tipo = $request->input('tipo', 'pf');
        $states = State::all();
        return view('user-create', compact('tipo'),  compact('states'));
    }


    public function store(Request $request, User $user)
    {
  //  dd($request);
  if ($request->user_type === 'pf') {
       $validated = $request->validate([
        'name' => 'required|min:5|max:200',
        'phone' => 'required|min:14|max:14',
        'day_of_birth' => 'required|min:10|max:10',
        'cpf' => 'required|min:14|max:14',
        'email' => 'required|min:5|max:200|email|unique:users|confirmed',
        'password' => 'required|min:7|max:300|confirmed',
        'cep' => 'required|min:9|max:9',
        'address_street' => 'required|min:5|max:200',
        'address_complement' => 'max:200',
        'address_number' => 'min:1|max:9999999999|integer',
        'address_city' => 'required|min:3|max:200',
        'state_id' => 'required',
       ]);
    }elseif ($request->user_type === 'pj') {
        $validated = $request->validate([

            'phone' => 'required|min:14|max:14',
            'cnpj' => 'required|min:18|max:18',
            'email' => 'required|min:5|max:200|email|unique:users|confirmed',
            'password' => 'required|min:7|max:300|confirmed',
            'address_street' => 'required|min:5|max:200',
            'address_complement' => 'max:200',
            'cep' => 'required|min:9|max:9',
            'address_number' => 'min:1|max:9999999999|integer',
            'address_city' => 'required|min:3|max:200',
            'corporate_reason' => 'required|min:3|max:200',
            'state_registration' => 'required|min:8|max:20',
            'state_id' => 'required',
            'responsable' => 'required|min:5|max:200',
           ]);
    
    }
       
       $strongPassword = $user->validatePassword($validated['password']);
       
        // Image Upload

        if ($request->hasFile('image') && $request->file('image')->isValid()){
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $requestImage->move(public_path('img/profile'), $imageName);
            
            $user->image = $imageName;
        }
       
       $user = $user->fill($validated);
       $user->password = Hash::make($strongPassword);
       //dd($user);
       $user->save();
       return 'usuário cadastrado';
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
