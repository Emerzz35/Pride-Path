<input type="text" name="cep" onkeyup="formatarcep(this)" placeholder="CEP: 00000-000" maxlength="8" value="{{ old('cep') }}" class=" @error('cep') fild_error @enderror">   
 {{-- A classe "fild_error" é adicionada quando o usuario não preenche o campo corretamente, usa ela pra estilizar --}}
@error('cep')
    <p>{{ $message }} </p>    
@enderror
<input type="text" name="address_street" placeholder="address_street" value="{{ old('address_street') }}" class=" @error('address_street') fild_error @enderror">   
@error('address_street')
    <p>{{ $message }} </p>    
@enderror
<input type="text" name="address_number" placeholder="address_number" value="{{ old('address_number') }}" class=" @error('address_number') fild_error @enderror">   
@error('address_number')
    <p>{{ $message }} </p>    
@enderror
<input type="text" name="address_complement" placeholder="address_complement" value="{{ old('address_complement') }}" class=" @error('address_complement') fild_error @enderror">   
@error('address_complement')
    <p>{{ $message }} </p>    
@enderror
<input type="text" name="address_city" placeholder="address_city" value="{{ old('address_city') }}" class=" @error('address_city') fild_error @enderror">   
@error('address_city')
    <p>{{ $message }} </p>    
@enderror
<select name="state_id" id="state_id" class=" @error('state_id') fild_error @enderror">
    <option value="">Selecione um estado</option>
    @foreach ($states as $state)
        <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>
            {{ $state->name }}
        </option>
    @endforeach
</select>
@error('state_id')
    <p>{{ $message }} </p>    
@enderror
@push('scripts')
<script>
    function formatarcep(input) {
    var cep = input.value.replace(/\D/g, '');
    cep = cep.replace(/(\d{5})(\d{3})/, '$1-$2');
    input.value = cep;
  }
</script>   
@endpush
