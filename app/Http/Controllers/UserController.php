<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Rules\ReCaptcha;

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
        
        // Validação dos dados
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
                'g-recaptcha-response' => [new ReCaptcha]
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
                'g-recaptcha-response' => [new ReCaptcha]
            ]);
        }
        
        // Verificar a força da senha
        $strongPassword = $user->validatePassword($validated['password']);
        
        // Gerar código de verificação
        $verificationCode = mt_rand(100000, 999999);
        
        // Preparar dados do usuário para armazenamento temporário
        $userData = $validated;
        $userData['password'] = Hash::make($strongPassword);
        if ($request->user_type === 'pj') {
            $userData['name'] = $request->corporate_reason;
        }
        
        // Remover confirmações de email e senha dos dados armazenados
        unset($userData['g-recaptcha-response']);
        unset($userData['email_confirmation']);
        unset($userData['password_confirmation']);
        
        // Adicionar o tipo de usuário aos dados
        $userData['user_type'] = $request->user_type;
        
        // Armazenar os dados temporariamente
        // Primeiro, excluir qualquer verificação anterior para este email
        EmailVerification::where('email', $validated['email'])->delete();
        
        // Criar nova verificação
        EmailVerification::create([
            'email' => $validated['email'],
            'verification_code' => $verificationCode,
            'user_data' => $userData,
            'expires_at' => Carbon::now()->addMinutes(30)
        ]);
        
        // Enviar email com código de verificação
        try {
            Mail::send('emails.verification-code', ['verificationCode' => $verificationCode], function ($message) use ($validated) {
                $message->to($validated['email'])
                        ->subject('Verificação de Email - Pride Path');
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível enviar o email de verificação. Por favor, tente novamente.');
        }
        
        // Redirecionar para a página de verificação
        return redirect()->route('verify.email.form', ['email' => $validated['email']]);
    }

    /**
     * Exibe o formulário de verificação de email.
     */
    public function showVerificationForm(Request $request)
    {
        $email = $request->email;
        
        // Verificar se existe uma verificação pendente para este email
        $verification = EmailVerification::where('email', $email)->first();
        
        if (!$verification) {
            return redirect()->route('user-create')->with('error', 'Nenhuma verificação pendente encontrada para este email.');
        }
        
        return view('auth.verify-email', ['email' => $email]);
    }

    /**
     * Verifica o código e cria o usuário.
     */
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required|string'
        ]);
        
        $verification = EmailVerification::where('email', $request->email)->first();
        
        if (!$verification) {
            return redirect()->back()->with('error', 'Nenhuma verificação pendente encontrada para este email.');
        }
        
        if ($verification->isExpired()) {
            $verification->delete();
            return redirect()->back()->with('error', 'O código de verificação expirou. Por favor, solicite um novo código.');
        }
        
        if ($verification->verification_code !== $request->verification_code) {
            return redirect()->back()->with('error', 'Código de verificação inválido. Por favor, tente novamente.');
        }
        
        // Código válido, criar o usuário
        $userData = $verification->user_data;
        
        $user = new User();
        foreach ($userData as $key => $value) {
            if ($key !== 'user_type') {
                $user->{$key} = $value;
            }
        }
        
        $user->save();
        
        // Excluir a verificação
        $verification->delete();
        
        // Fazer login automático
        Auth::login($user);
        
        // Redirecionar para o perfil com mensagem de boas-vindas
        session()->flash('show_modal', true);
        return redirect()->route('profile', $user->id)->with('success', 'Conta criada com sucesso! Bem-vindo ao Pride Path!');
    }

    /**
     * Reenvia o código de verificação.
     */
    public function resendVerificationCode(Request $request)
    {
        $email = $request->email;
        
        $verification = EmailVerification::where('email', $email)->first();
        
        if (!$verification) {
            return redirect()->route('user-create')->with('error', 'Nenhuma verificação pendente encontrada para este email.');
        }
        
        // Gerar novo código
        $verificationCode = mt_rand(100000, 999999);
        
        // Atualizar verificação
        $verification->update([
            'verification_code' => $verificationCode,
            'expires_at' => Carbon::now()->addMinutes(30)
        ]);
        
        // Enviar email com novo código
        try {
            Mail::send('emails.verification-code', ['verificationCode' => $verificationCode], function ($message) use ($email) {
                $message->to($email)
                        ->subject('Verificação de Email - Pride Path');
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível enviar o email de verificação. Por favor, tente novamente.');
        }
        
        return redirect()->route('verify.email.form', ['email' => $email])->with('success', 'Um novo código de verificação foi enviado para o seu email.');
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
        
        // Atualiza o usuário
        $user->update($dataToUpdate);
        
        return back()->with('success', 'Perfil atualizado com sucesso!');
    }

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
