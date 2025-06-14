@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0">Criar Novo Quadro</h1>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('boards.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold">Título do Quadro</label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}" 
                                   placeholder="Ex.: Projeto Kanban, Tarefas da Equipe..." 
                                   required 
                                   autofocus>

                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Salvar Quadro
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
