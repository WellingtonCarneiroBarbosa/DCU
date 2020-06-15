@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Cadastrar nova demanda</div>
                <div class="card-body">
                    <form action="{{ route('demands.store') }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="demand" class="col-form-label">Nome da Demanda</label>

                                <input class="form-control" type="text" name="demand" id="demand">
                            </div>

                            <div class="col-md-6">
                                <label for="priority" class="col-form-label">Prioridade</label>

                                <select name="priority" id="priority" class="form-control">
                                    <option value="1">Baixa</option>
                                    <option value="2">Média</option>
                                    <option value="3">Alta</option>
                                    <option value="4">Urgente</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="description" class="col-form-label">Descrição</label>

                                <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
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
