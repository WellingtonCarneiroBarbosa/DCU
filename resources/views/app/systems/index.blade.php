@extends('layouts.app')

@section('content')
<div id="app">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <a class="float-right" href="{{ route('systems.create') }}">Cadastrar Sistema</a>
                <h4>Lista de Sistemas</h4>
            </div>
            <div class="card-body">
                @if(count($systems) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sistema</th>
                            <th>Token</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($systems as $system)
                        <tr>
                            <td>{{ $system->name }}</td>
                            <td>{{ $system->token }}</td>
                            <td class="td-actions text-right">
                                <a href="{{ route('systems.confirmDestroy', [$system->id]) }}">
                                    <button title="Desativar" type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm " data-original-title="">
                                        <i class="fa fa-trash pt-1"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        {{ $systems->links() }}
                    </tbody>
                </table>
                @else 
                <h5>Ainda não há nenhum sistema cadastrado. Clique <a href="{{ route('systems.create') }}">aqui</a> para cadastrar um novo sistema</h5>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
