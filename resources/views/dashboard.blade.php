@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4">Meus Quadros</h1>
        <a href="{{ route('boards.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Novo Quadro
        </a>
    </div>

    @if ($boards->count())
        <div class="row">
            @foreach ($boards as $board)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $board->title }}</h5>
                            <p class="card-text text-muted small">Criado em {{ $board->created_at->format('d/m/Y') }}</p>

                            <a href="{{ route('boards.show', $board) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-kanban"></i> Abrir Kanban
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            Nenhum quadro criado. Clique em <strong>Novo Quadro</strong> para começar.
        </div>
    @endif
@endsection
