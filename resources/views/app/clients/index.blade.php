@extends('layouts.app')

@section('content')
<div id="app">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Lista de Clientes</h4>
            </div>
            <div class="card-body">
                @if(count($clients) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Sistema</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                        <tr>
                            <td>{{ $client->id }}</td>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->email }}</td>
                            <td>{{ $client->system['name'] }}</td>
                        </tr>
                        @endforeach
                        {{ $clients->links() }}
                    </tbody>
                </table>
                @else 
                <h5>Ainda não há clientes para exibir. Eles serão cadastrados automaticamente quando abrirem um ticket.</h5>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
