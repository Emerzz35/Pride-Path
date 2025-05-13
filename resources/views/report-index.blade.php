@extends('layouts.app')

@section('content')

<form method="GET" action="{{ route('report-index') }}" class="mb-4">
    <input type="text" name="search" placeholder="Buscar..." value="{{ request('search') }}">
    <select name="type">
        <option value="">Todos os tipos</option>
        <option value="user" {{ request('type') == 'user' ? 'selected' : '' }}>Usuário</option>
        <option value="service" {{ request('type') == 'service' ? 'selected' : '' }}>Serviço</option>
        <option value="order" {{ request('type') == 'order' ? 'selected' : '' }}>Pedido</option>
        <option value="comission" {{ request('type') == 'comission' ? 'selected' : '' }}>Entrega</option>
        <option value="rating" {{ request('type') == 'rating' ? 'selected' : '' }}>Avaliação</option> {{-- Novo filtro --}}
    </select>
    <button type="submit">Filtrar</button>
</form>

@foreach ($reports as $report)
    <div class="report-card border p-4 mb-3">
        <p><strong>Reportador:</strong> {{ $report->user->name }}</p>
        <p><strong>Tipo:</strong> {{ class_basename($report->reportable_type) }}</p>

        @php $target = $report->reportable; @endphp

        @if ($target instanceof App\Models\User)
            <p><strong>Usuário Reportado:</strong> {{ $target->name }}</p>
            <a href="{{ route('profile', $target->id) }}">Ver Perfil</a>

        @elseif ($target instanceof App\Models\Service)
            <p><strong>Serviço Reportado:</strong> {{ $target->name }}</p>
            <p><strong>Descrição:</strong> {{ Str::limit($target->description, 100) }}</p>
            <a href="{{ route('service-show', $target->id) }}">Ver Serviço</a>

        @elseif ($target instanceof App\Models\Order)
            <p><strong>Pedido Reportado:</strong> #{{ $target->id }}</p>
            <p><strong>Dono:</strong> {{ $target->user->name }}</p>
            <p><strong>Título:</strong> {{ $target->name }}</p>
            <p><strong>Mensagem:</strong> {{ $target->description }}</p>
            <a href="{{ route('profile', $target->user->id) }}">Ver Perfil</a>

        @elseif ($target instanceof App\Models\Comission)
            <p><strong>Entrega Reportada:</strong> #{{ $target->id }}</p>
            <p><strong>Dono:</strong> {{ $target->order->service->user->name }}</p>
            <p><strong>Título:</strong> {{ $target->name }}</p>
            <p><strong>Mensagem:</strong> {{ $target->description }}</p>
            <a href="{{ route('profile', $target->order->service->user->id) }}">Ver Perfil</a>    

        @elseif ($target instanceof App\Models\Rating)
            <p><strong>Avaliação Reportada:</strong></p>
            <p><strong>Usuário:</strong> {{ $target->user->name }}</p>
            <p><strong>Serviço:</strong> {{ $target->service->name }}</p>
            <p><strong>Nota:</strong> {{ $target->rating }} / 5</p>
            <p><strong>Comentário:</strong> {{ $target->comment ?: 'Nenhum comentário' }}</p>
            <a href="{{ route('service-show', $target->service->id) }}">Ver Serviço</a>
        @endif

        <p><strong>Motivo:</strong> {{ $report->reason }}</p>
        <p><strong>Data:</strong> {{ $report->created_at->format('d/m/Y H:i') }}</p>

        <form action="{{ route('report-destroy', $report->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja deletar este report?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Deletar</button>
        </form>
    </div>
@endforeach

@endsection
