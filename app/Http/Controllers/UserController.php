<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
    //dd($request);
       $validated = $request->validate([
        'name' => 'required|min:2|max:200',
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
       ]);
       
       $strongPassword = $user->validatePassword($validated['password']);
       
       $user = $user->fill($validated);
       $user->password = Hash::make($strongPassword);
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
