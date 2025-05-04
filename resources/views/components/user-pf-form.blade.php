<input type="text" name="name" placeholder="Seu nome" value="{{ old('name') }}" class=" @error('name') fild_error @enderror">   
        {{-- A classe "fild_error" é adicionada quando o usuario não preenche o campo corretamente, usa ela pra estilizar --}}
        @error('name')
            <p>{{ $message }} </p>    
        @enderror
        <input type="tel" name="phone" maxlength="11" placeholder="(  ) _ ____-____" onkeyup="formatarTelefone(this)" value="{{ old('phone') }}" class=" @error('phone') fild_error @enderror">   
        @error('phone')
            <p>{{ $message }} </p>    
        @enderror
        <input type="text" name="email" placeholder="Seu Email" value="{{ old('email')}}" class=" @error('email') fild_error @enderror"> 
        @error('email')
            <p>{{ $message }} </p>    
        @enderror 
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
        <input type="text" name="cpf" maxlength="11" placeholder="000.000.000-00" onkeyup="formatarcpf(this)" value="{{ old('cpf') }}" class=" @error('cpf') fild_error @enderror">   
        @error('cpf')
            <p>{{ $message }} </p>    
        @enderror
        <input type="date" name="day_of_birth" value="{{ old('day_of_birth') }}" class=" @error('day_of_birth') fild_error @enderror">   
        @error('day_of_birth')
            <p>{{ $message }} </p>    
        @enderror

        
        @push('scripts')
        <script>
            function formatarTelefone(input) {
            var telefone = input.value.replace(/\D/g, '');
            telefone = telefone.replace(/(\d{2})(\d{5})(\d{4})/, '($1)$2-$3');
            input.value = telefone;
          }
          function formatarcpf(input) {
            var cpf = input.value.replace(/\D/g, '');
            cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            input.value = cpf;
          }
        </script>
        @endpush
        