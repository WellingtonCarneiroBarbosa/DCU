@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="float-right" href="{{ route('demands.index') }}">Voltar para lista de demandas</a>
                    Cadastrar nova demanda
                </div>
                <div class="card-body">
                    <form action="{{ route('demands.store') }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="demand" class="col-form-label">Nome da Demanda</label>

                                <input required class="form-control" type="text" name="demand" id="demand" value="{{ old('demand') }}">
                            </div>

                            <div class="col-md-6">
                                <label for="priority" class="col-form-label">Prioridade</label>

                                <select required name="priority" id="priority" class="form-control">
                                    <option value="1" {{ old('priority') == 1 ? 'selected' : ''}}>Baixa</option>
                                    <option value="2" {{ old('priority') == 2 ? 'selected' : ''}}>Média</option>
                                    <option value="3" {{ old('priority') == 3 ? 'selected' : ''}}>Alta</option>
                                    <option value="4" {{ old('priority') == 4 ? 'selected' : ''}}>Urgente</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="description" class="col-form-label">Descrição</label>

                                <textarea required class="form-control" name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
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
