@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h5>Tickets em andamento</h5>
    </div>
    
        @if(count($tickets) > 0) 
        <div class="row">
            @foreach($tickets as $tk)
            <div class="col-md-4 mb-2">
                <div class="card">
                    <div class="card-header">Demanda: {{ $tk->demand_id }}</div>

                    <div class="card-body">
                        <div class="row">Mensagem: {{ $tk->message }}</div>
                        <div class="row">Aberto por {{ $tk->client_id }} em {{ $tk->created_at }}</div>
                        <div class="row">
                            <a href="{{ route('tickets.show', [$tk->id]) }}">
                                <button class="btn btn-primary">Visualizar</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{ $tickets->links() }}
        </div>
        @else 
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Lista de Tickets</div>

                    <div class="card-body">
                        Não há tickets em andamento no momento.
                    </div>
                </div>
            </div>
        </div>
        @endif

</div>
@endsection
