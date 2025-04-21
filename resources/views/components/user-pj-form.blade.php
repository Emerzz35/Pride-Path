        <input type="text" name="email" placeholder="Seu Email" value="{{ old('email')}}" class=" @error('email') fild_error @enderror"> 
        @error('email')
            <p>{{ $message }} </p>    
        @enderror 
        <input type="text" name="email_confirmation" placeholder="confirme o seu email" value="{{ old('email_confirmation')}}" class=" @error('email_confirmation') fild_error @enderror"> 
        @error('email_confirmation')
            <p>{{ $message }} </p>    
        @enderror
        <input type="tel" name="phone" maxlength="11" placeholder="(  ) _ ____-____" onkeyup="formatarTelefone(this)" value="{{ old('phone') }}" class=" @error('phone') fild_error @enderror">   
        @error('phone')
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
        <input type="text" name="cnpj" placeholder="Seu cnpj" value="{{ old('cnpj')}}" onkeyup="formatarCnpj(this)" maxlength="14" class=" @error('cnpj') fild_error @enderror"> 
        @error('cnpj')
            <p>{{ $message }} </p>    
        @enderror 
        <input type="text" name="corporate_reason" placeholder="Seu corporate_reason" value="{{ old('corporate_reason')}}" class=" @error('corporate_reason') fild_error @enderror"> 
        @error('corporate_reason') 
            <p>{{ $message }} </p>    
        @enderror 
        <input type="text" name="state_registration" placeholder="Seu state_registration" maxlength="20" value="{{ old('state_registration')}}" class=" @error('state_registration') fild_error @enderror"> 
        @error('state_registration')
            <p>{{ $message }} </p>    
        @enderror 
        <input type="text" name="responsable" placeholder="Seu responsable" value="{{ old('responsable')}}" class=" @error('responsable') fild_error @enderror"> 
        @error('responsable')
            <p>{{ $message }} </p>    
        @enderror 
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