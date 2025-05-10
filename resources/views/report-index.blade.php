@extends('layouts.app')

@section('content')

@foreach ($reports as $report)
    <div class="report-card border p-4 mb-3">
        <p><strong>Reportador:</strong> {{ $report->user->name }}</p>
        <p><strong>Tipo:</strong> {{ class_basename($report->reportable_type) }}</p>

        @php
            $target = $report->reportable;
        @endphp

        @if ($target instanceof App\Models\User)
            <p><strong>Usuário Reportado:</strong> {{ $target->name }}</p>
            <a href="{{ route('profile', $target->id) }}" class="text-blue-500 underline">Ver Perfil</a>

        @elseif ($target instanceof App\Models\Service)
            <p><strong>Serviço Reportado:</strong> {{ $target->name }}</p>
            <p><strong>Descrição:</strong> {{ Str::limit($target->description, 100) }}</p>
            <a href="{{ route('service-show', $target->id) }}" class="text-blue-500 underline">Ver Serviço</a>

        @elseif ($target instanceof App\Models\Order)
            <p><strong>Pedido Reportado:</strong> Pedido #{{ $target->id }}</p>
            <p><strong>Dono do Pedido Reportado:</strong> {{ $target->user->name }}</p>
            <p><strong>Titulo do Pedido:</strong> {{ $target->name }}</p>
            <p><strong>Mensagem do Pedido:</strong> {{ $target->description }}</p>
            <a href="{{ route('profile', $target->user->id) }}" class="text-blue-500 underline">Ver Perfi de {{ $target->user->name }}</a>
        @elseif ($target instanceof App\Models\Comission)
            <p><strong>Entrega Reportada:</strong> Entrega #{{ $target->id }}</p>
            <p><strong>Dono da Entrega Reportada:</strong> {{ $target->order->service->user->name }}</p>
            <p><strong>Titulo da Entrega:</strong> {{ $target->name }}</p>
            <p><strong>Mensagem do Entrega:</strong> {{ $target->description }}</p>
            <a href="{{ route('profile', $target->order->service->user->id) }}" class="text-blue-500 underline">Ver Perfi de {{ $target->order->service->user->name }}</a>    
        @endif

        <p><strong>Motivo do Report:</strong> {{ $report->reason }}</p>
        <p><strong>Data:</strong> {{ $report->created_at->format('d/m/Y H:i') }}</p>
    </div>
@endforeach



@endsection
