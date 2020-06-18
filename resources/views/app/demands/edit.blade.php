@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="float-right" href="{{ route('demands.index') }}">Voltar para lista de demandas</a>
                    Editar demanda
                </div>
                <div class="card-body">
                    <form action="{{ route('demands.update', [$demand->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="demand" class="col-form-label">Nome da Demanda</label>

                                <input class="form-control" type="text" name="demand" id="demand" value="{{ $demand->demand }}">
                            </div>

                            <div class="col-md-6">
                                <label for="priority" class="col-form-label">Prioridade</label>

                                <select name="priority" id="priority" class="form-control">
                                    <option value="1" {{ $demand->priority == 1 ? 'selected' : ''}}>Baixa</option>
                                    <option value="2" {{ $demand->priority == 2 ? 'selected' : ''}}>Média</option>
                                    <option value="3" {{ $demand->priority == 3 ? 'selected' : ''}}>Alta</option>
                                    <option value="4" {{ $demand->priority == 4 ? 'selected' : ''}}>Urgente</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="description" class="col-form-label">Descrição</label>

                                <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ $demand->description }}</textarea>
                            </div>

                            <div class="col-md-12 mt-2">
                                <div class="float-right">
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection
