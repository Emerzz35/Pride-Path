        <input type="text" name="email" placeholder="Seu Email" @guest value="{{ old('email') }}" @endguest @auth readonly value="{{ auth()->user()->email }}" @endauth  class=" @error('email') fild_error @enderror"> 
        @error('email')
            <p>{{ $message }} </p>    
        @enderror

        @guest    
            <input type="text" name="email_confirmation" placeholder="confirme o seu email" value="{{ old('email_confirmation')}}" class=" @error('email_confirmation') fild_error @enderror"> 
            @error('email_confirmation')
                <p>{{ $message }} </p>    
            @enderror
            
            <input type="password" name="password" placeholder="Sua senha" class=" @error('password') fild_error @enderror">
            @error('password')
                <p>{{ $message }} </p>    
            @enderror
            <input type="password" name="password_confirmation" placeholder="confirme Sua senha" class=" @error('password_confirmation') fild_error @enderror">
            @error('password_confirmation')
                <p>{{ $message }} </p>    
            @enderror
        @endguest
        
        <input type="tel" name="phone" maxlength="11" placeholder="(  ) _ ____-____" onkeyup="formatarTelefone(this)" @guest value="{{ old('phone') }}" @endguest @auth value="{{ auth()->user()->phone }}" @endauth class=" @error('phone') fild_error @enderror">   
        @error('phone')
            <p>{{ $message }} </p>    
        @enderror 
        <input type="text" name="cnpj" placeholder="Seu cnpj"@guest value="{{ old('cnpj') }}" @endguest @auth readonly value="{{ auth()->user()->cnpj }}" @endauth onkeyup="formatarCnpj(this)" maxlength="14" class=" @error('cnpj') fild_error @enderror"> 
        @error('cnpj')
            <p>{{ $message }} </p>    
        @enderror 
        <input type="text" name="corporate_reason" placeholder="Seu corporate_reason" @guest value="{{ old('corporate_reason') }}" @endguest @auth value="{{ auth()->user()->corporate_reason }}" @endauth class=" @error('corporate_reason') fild_error @enderror"> 
        @error('corporate_reason') 
            <p>{{ $message }} </p>    
        @enderror 
        <input type="text" name="state_registration" placeholder="Seu state_registration" maxlength="20" @guest value="{{ old('state_registration') }}" @endguest @auth value="{{ auth()->user()->state_registration }}" @endauth class=" @error('state_registration') fild_error @enderror"> 
        @error('state_registration')
            <p>{{ $message }} </p>    
        @enderror 
        <input type="text" name="responsable" placeholder="Seu responsable" @guest value="{{ old('responsable') }}" @endguest @auth value="{{ auth()->user()->responsable }}" @endauth class=" @error('responsable') fild_error @enderror"> 
        @error('responsable')
            <p>{{ $message }} </p>    
        @enderror 

        @push('scripts')
        <script>
            function formatarTelefone(input) {
            var telefone = input.value.replace(/\D/g, '');
            telefone = telefone.replace(/(\d{2})(\d{5})(\d{4})/, '($1)$2-$3');
            input.value = telefone;
          }
          function formatarCnpj(input) {
            var Cnpj = input.value.replace(/\D/g, '');
            Cnpj = Cnpj.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
            input.value = Cnpj;
          }
        </script>
        @endpush
      