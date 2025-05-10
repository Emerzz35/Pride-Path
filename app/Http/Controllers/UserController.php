<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\State;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show(User $User){
        $Users = User::all();
        return view('profile')
        ->with('User', $User);
    
    }

    public function create(Request $request)
    {

        if (Auth::user()){
            $userId = Auth::User()->id;
            return redirect()->route('profile', $userId);
        }
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
       
       
       
       $user = $user->fill($validated);
       $user->password = Hash::make($strongPassword);
       if ($request->user_type === 'pj') {
            $user->name = $request->corporate_reason;
       }
       $user->save();
       Auth::login($user);
       session()->flash('show_modal', true);
       return redirect(route('profile', $user->id));

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $user = $request->user();
        $tipo = $user && !empty($user->cnpj) ? 'pj' : 'pf';

        $states = State::all();
        return view('user-edit', compact('tipo'),  compact('states'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateImage(Request $request)
    {

         // Image Upload
         if ($request->hasFile('image') && $request->file('image')->isValid()){
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $requestImage->move(public_path('img/profile'), $imageName);
            
            $request->user()->update([
                'image'=>$imageName
            ]);
 
        }


        return back(); 
    }

    public function update(Request $request)
    {
        //dd($request);
        if ($request->user_type === 'pf') {
            $validated = $request->validate([
             'name' => 'required|min:5|max:200',
             'phone' => 'required|min:14|max:14',
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
                 'address_street' => 'required|min:5|max:200',
                 'address_complement' => 'max:200',
                 'cep' => 'required|min:9|max:9',
                 'address_number' => 'min:1|max:9999999999|integer',
                 'address_city' => 'required|min:3|max:200',
                 'corporate_reason' => 'required|min:3|max:200',
                 'state_registration' => 'required|min:8|max:20',
                 'state_id' => 'required',
                 'responsable' => 'required|min:5|max:200'
                ]);
   
         
         }
         $request->user()->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'cpf'=>$request->cpf,
            'day_of_birth'=>$request->day_of_birth,
            'cep'=>$request->cep,
            'address_street'=>$request->address_street,
            'address_complement'=>$request->address_complement,
            'address_number'=>$request->address_number,
            'address_city'=>$request->address_city,
            'cnpj'=>$request->cnpj,
            'corporate_reason'=>$request->corporate_reason,
            'state_registration'=>$request->state_registration,
            'responsable'=>$request->responsable,
            'state_id'=>$request->state_id,
         ]);

         if ($request->user_type === 'pj') {
            $request->user()->update([
                'name' => $request->corporate_reason
        ]);
       }
        return back(); 
    }


    /**
     * Remove the specified resource from storage.
     */
   /**
 * Remove the specified resource from storage.
 */
public function destroy(string $id)
{
    $user = User::find($id);

    if (!$user) {
        return redirect()->back()->with('error', 'Usuário não encontrado.');
    }

    // Se quiser garantir que apenas o próprio usuário ou um admin possa excluir:
    if (Auth::id() !== $user->id && !Auth::user()->isAdmin()) {
        return redirect()->back()->with('error', 'Você não tem permissão para excluir este usuário.');
    }

    $user->delete();

    // Se o usuário deletado for o mesmo que está logado, faz logout
    if (Auth::id() === $user->id) {
        Auth::logout();
    }

    return redirect()->route('login')->with('success', 'Usuário deletado com sucesso.');
}

}
