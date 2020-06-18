@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h5>Tickets em Aberto</h5>
    </div>
    <div class="row justify-content-center">
        @if(count($tickets) > 0) 
        @foreach($tickets as $tk)
        <div class="col-md-4 mb-2">
            <div class="card">
                <div class="card-header">Lista de Tickets</div>

                <div class="card-body">
                    Não há nenhum ticket em aberto no momento.
                </div>
            </div>
        </div>
        @endforeach
        @else 
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Lista de Tickets</div>

                <div class="card-body">
                    Não há nenhum ticket em aberto no momento.
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
