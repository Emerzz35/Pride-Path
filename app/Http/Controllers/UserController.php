<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show(User $User){

        $Users = User::all();


        $services = $User->Service()->with('ratings')->get();

        // Calcula a média de cada serviço e depois a média geral
        $serviceAverages = $services->map(function ($service) {
            return $service->ratings->avg('rating');
        })->filter(); // Remove nulos (serviços sem avaliação)

        $overallAverage = $serviceAverages->count() > 0 
            ? round($serviceAverages->avg(), 2)
            : null;


        return view('profile')
        ->with('User', $User)
        ->with('overallAverage', $overallAverage);
    
    }

// Vamos modificar o método create para garantir que a variável $tipo seja passada corretamente
// e tenha um valor padrão adequado

public function create(Request $request)
{
    if (Auth::user()){
        $userId = Auth::User()->id;
        return redirect()->route('profile', $userId);
    }
    
    // Definir o tipo padrão como 'pf' se não for especificado
    $tipo = $request->input('tipo', 'pf');
    
    // Garantir que o tipo seja válido (pf ou pj) e seja uma string
    if (!in_array($tipo, ['pf', 'pj'])) {
        $tipo = 'pf';
    }
    
    // Depuração para verificar o valor de $tipo
    // dd($tipo); // Descomente esta linha para verificar o valor
    
    $states = State::all();
    
    // Passar a variável $tipo explicitamente para a view
    return view('user-create', [
        'tipo' => $tipo,
        'states' => $states
    ]);
}


    public function store(Request $request, User $user)
    {
        // Converter a data de nascimento para o formato correto
        if ($request->user_type === 'pf' && $request->has('day_of_birth')) {
            // Verificar se a data está no formato DD/MM/YYYY
            $dateParts = explode('/', $request->day_of_birth);
            if (count($dateParts) === 3) {
                $day = $dateParts[0];
                $month = $dateParts[1];
                $year = $dateParts[2];
                
                // Reformatar para YYYY-MM-DD
                $request->merge(['day_of_birth' => "$year-$month-$day"]);
            }
        }
        
        //  dd($request);
        if ($request->user_type === 'pf') {
            $validated = $request->validate([
                'name' => 'required|min:5|max:200',
                'phone' => 'required|min:10|max:20',
                'day_of_birth' => 'required|date',
                'cpf' => 'required|min:11|max:14',
                'email' => 'required|min:5|max:200|email|unique:users|confirmed',
                'password' => 'required|min:7|max:300|confirmed',
                'cep' => 'required|min:8|max:9',
                'address_street' => 'required|min:5|max:200',
                'address_complement' => 'max:200',
                'address_number' => 'min:1|max:9999999999|integer',
                'address_city' => 'required|min:3|max:200',
                'state_id' => 'required',
            ]);
        } elseif ($request->user_type === 'pj') {
            $validated = $request->validate([
                'phone' => 'required|min:10|max:20',
                'cnpj' => 'required|min:14|max:18',
                'email' => 'required|min:5|max:200|email|unique:users|confirmed',
                'password' => 'required|min:7|max:300|confirmed',
                'address_street' => 'required|min:5|max:200',
                'address_complement' => 'max:200',
                'cep' => 'required|min:8|max:9',
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
        return view('user-edit', compact('tipo', 'states'));
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
        $user = $request->user();
        
        // Converter a data de nascimento para o formato correto
        if ($request->user_type === 'pf' && $request->has('day_of_birth')) {
            // Verificar se a data está no formato DD/MM/YYYY
            $dateParts = explode('/', $request->day_of_birth);
            if (count($dateParts) === 3) {
                $day = $dateParts[0];
                $month = $dateParts[1];
                $year = $dateParts[2];
                
                // Reformatar para YYYY-MM-DD
                $request->merge(['day_of_birth' => "$year-$month-$day"]);
            }
        }
        
        // Validação base comum para ambos os tipos
        $baseRules = [
            'phone' => 'required|min:10|max:20',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'cep' => 'required|min:8|max:9',
            'address_street' => 'required|min:5|max:200',
            'address_complement' => 'nullable|max:200',
            'address_number' => 'required|integer',
            'address_city' => 'required|min:3|max:200',
            'state_id' => 'required',
        ];
        
        // Regras específicas para senha (opcional na atualização)
        $passwordRules = [];
        if ($request->filled('password')) {
            $passwordRules = [
                'password' => 'min:7|max:300|confirmed',
            ];
        }
        
        // Regras específicas para cada tipo de usuário
        if ($request->user_type === 'pf') {
            $typeRules = [
                'name' => 'required|min:5|max:200',
                'cpf' => 'required|min:11|max:14',
                'day_of_birth' => 'required|date',
            ];
        } else { // PJ
            $typeRules = [
                'corporate_reason' => 'required|min:3|max:200',
                'cnpj' => 'required|min:14|max:18',
                'state_registration' => 'required|min:8|max:20',
                'responsable' => 'required|min:5|max:200',
            ];
        }
        
        // Combina todas as regras
        $rules = array_merge($baseRules, $passwordRules, $typeRules);
        
        // Valida os dados
        $validated = $request->validate($rules);
        
        // Prepara os dados para atualização
        $dataToUpdate = [
            'phone' => $request->phone,
            'email' => $request->email,
            'cep' => $request->cep,
            'address_street' => $request->address_street,
            'address_complement' => $request->address_complement,
            'address_number' => $request->address_number,
            'address_city' => $request->address_city,
            'state_id' => $request->state_id,
        ];
        
        // Adiciona campos específicos por tipo
        if ($request->user_type === 'pf') {
            $dataToUpdate['name'] = $request->name;
            $dataToUpdate['cpf'] = $request->cpf;
            $dataToUpdate['day_of_birth'] = $request->day_of_birth;
            // Limpa campos de PJ se existirem
            $dataToUpdate['cnpj'] = null;
            $dataToUpdate['corporate_reason'] = null;
            $dataToUpdate['state_registration'] = null;
            $dataToUpdate['responsable'] = null;
        } else { // PJ
            $dataToUpdate['name'] = $request->corporate_reason; // Nome é a razão social
            $dataToUpdate['corporate_reason'] = $request->corporate_reason;
            $dataToUpdate['cnpj'] = $request->cnpj;
            $dataToUpdate['state_registration'] = $request->state_registration;
            $dataToUpdate['responsable'] = $request->responsable;
            // Limpa campos de PF se existirem
            $dataToUpdate['cpf'] = null;
            $dataToUpdate['day_of_birth'] = null;
        }
        
        // Atualiza a senha se fornecida
        if ($request->filled('password')) {
            $strongPassword = $user->validatePassword($request->password);
            $dataToUpdate['password'] = Hash::make($strongPassword);
        }
        if ($request->filled('phone')) {
            // Remove caracteres não numéricos (parênteses, espaços, traços)
            $dataToUpdate['phone'] = preg_replace('/[^0-9]/', '', $request->phone);
}
        // Atualiza o usuário
        $user->update($dataToUpdate);
        
        return back()->with('success', 'Perfil atualizado com sucesso!');
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
