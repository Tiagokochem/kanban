@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 mb-0">{{ $board->title }}</h1>
        <small class="text-muted">Kanban de tarefas</small>
    </div>
    <div>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="bi bi-plus-lg"></i> Nova Coluna
        </button>

        <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>
</div>

{{-- Mensagens de sucesso --}}
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
</div>
@endif

{{-- Mensagens de erro --}}
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle-fill"></i> Existem erros no formulário:
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
</div>
@endif

{{-- Área do Kanban --}}
<div class="row" id="categories" data-board-id="{{ $board->id }}">
    {{-- Colunas e tarefas carregadas via AJAX --}}
</div>

{{-- Modal para adicionar coluna --}}
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="categoryForm" action="/boards/{{ $board->id }}/categories" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Nova Coluna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Nome da Coluna</label>
                        <input type="text" class="form-control" id="categoryName" name="name" required placeholder="Ex.: To Do, Doing, Done">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> Adicionar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal para adicionar tarefa --}}
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="taskForm">
                <input type="hidden" id="taskCategoryId">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel">Nova Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="taskTitle" class="form-label">Título da Tarefa</label>
                        <input type="text" class="form-control" id="taskTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="taskDescription" class="form-label">Descrição</label>
                        <textarea class="form-control" id="taskDescription" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> Adicionar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
    // Definindo loadTasks no escopo global para poder ser acessada de qualquer lugar
    let loadTasks;
    
    $(document).ready(function() {
        console.log('Document ready');
        
        // Configurar o CSRF token para todas as requisições AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        
        // Pegar o ID do board do atributo data
        const boardId = $('#categories').data('board-id');
        console.log('Board ID:', boardId);
        
        // Verificar se o botão está sendo clicado
        $('[data-bs-target="#addCategoryModal"]').on('click', function() {
            console.log('Botão Nova Coluna clicado');
            // Tentar abrir o modal manualmente
            const modal = new bootstrap.Modal(document.getElementById('addCategoryModal'));
            modal.show();
        });
        
        // Verificar todos os eventos do modal
        $('#addCategoryModal').on('show.bs.modal', function () {
            console.log('Modal de categoria: evento show');
        });
        
        $('#addCategoryModal').on('shown.bs.modal', function () {
            console.log('Modal de categoria: evento shown');
            // Focar no campo de nome
            $('#categoryName').focus();
        });
        
        $('#addCategoryModal').on('hide.bs.modal', function () {
            console.log('Modal de categoria: evento hide');
        });
        
        $('#addCategoryModal').on('hidden.bs.modal', function () {
            console.log('Modal de categoria: evento hidden');
        });
        
        // Verificar se o Bootstrap está disponível
        if (typeof bootstrap !== 'undefined') {
            console.log('Bootstrap está disponível');
        } else {
            console.error('Bootstrap não está disponível!');
        }
        
        loadCategories();

        function loadCategories() {
            console.log('Carregando categorias...');
            $.get(`/api/boards/${boardId}/categories`, function(categories) {
                console.log('Categorias recebidas:', categories);
                $('#categories').empty();

                if (categories.length === 0) {
                    $('#categories').append(`
                        <div class="col-12">
                            <div class="alert alert-info">
                                Nenhuma coluna criada ainda. Clique em <strong>Nova Coluna</strong> para começar.
                            </div>
                        </div>
                    `);
                }

                categories.forEach(category => {
                    const column = $(`
                        <div class="col-md-4">
                            <div class="card shadow-sm border-0 mb-4">
                                <div class="card-header bg-primary text-white fw-semibold d-flex justify-content-between align-items-center">
                                    ${category.name}
                                    <button class="btn btn-light btn-sm" onclick="openTaskModal(${category.id})" title="Nova Tarefa">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group task-list" id="category-${category.id}">
                                        <!-- As tarefas irão aqui -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    `);

                    $('#categories').append(column);

                    loadTasks(category.id);
                });
            }).fail(function(error) {
                console.error('Erro ao carregar categorias:', error);
            });
        }

        // Definindo a função no escopo global
        loadTasks = function(categoryId) {
            console.log('Carregando tarefas para categoria:', categoryId);
            $.get(`/api/categories/${categoryId}/tasks`, function(tasks) {
                console.log('Tarefas recebidas:', tasks);
                const list = $(`#category-${categoryId}`);
                list.empty();

                if (tasks.length === 0) {
                    list.append(`<li class="list-group-item text-muted fst-italic">Nenhuma tarefa</li>`);
                }

                tasks.forEach(task => {
                    const item = $(`
                        <li class="list-group-item mb-2">
                            <strong>${task.title}</strong><br>
                            <small class="text-muted">${task.description ?? ''}</small>
                        </li>
                    `);
                    list.append(item);
                });
            }).fail(function(error) {
                console.error('Erro ao carregar tarefas:', error);
            });
        };

        // Interceptar o envio do formulário tradicional para fazer via AJAX
        $('#categoryForm').on('submit', function(e) {
            e.preventDefault();
            console.log('Form de categoria submetido via evento submit');
            
            const form = $(this);
            const url = form.attr('action');
            const formData = form.serialize();
            
            console.log('URL:', url);
            console.log('Form data:', formData);
            
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log('Categoria criada com sucesso:', response);
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addCategoryModal'));
                    modal.hide();
                    $('#categoryName').val('');
                    loadCategories();
                },
                error: function(error) {
                    console.error('Erro ao criar coluna:', error);
                    alert('Erro ao criar coluna. Verifique o console para detalhes.');
                }
            });
        });
    });

    // Abrir modal de nova tarefa passando categoryId
    function openTaskModal(categoryId) {
        console.log('Abrindo modal de tarefa para categoria:', categoryId);
        $('#taskCategoryId').val(categoryId);
        $('#taskTitle').val('');
        $('#taskDescription').val('');
        $('#addTaskModal').modal('show');
    }

    // Submeter tarefa
    $('#taskForm').submit(function(e) {
        e.preventDefault();
        console.log('Form de tarefa submetido');

        const categoryId = $('#taskCategoryId').val();
        const title = $('#taskTitle').val();
        const description = $('#taskDescription').val();
        console.log('Dados da tarefa:', {categoryId, title, description});

        // Usando a rota web para criar tarefa
        console.log('Enviando requisição para:', `/categories/${categoryId}/tasks`);
        $.ajax({
            url: `/categories/${categoryId}/tasks`,
            type: 'POST',
            data: {
                title: title,
                description: description,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('Tarefa criada com sucesso:', response);
                const taskModal = bootstrap.Modal.getInstance(document.getElementById('addTaskModal'));
                taskModal.hide();

                loadTasks(categoryId);
            },
            error: function(error) {
                console.error('Erro ao criar tarefa:', error);
                alert('Erro ao criar tarefa');
            }
        });
    });
</script>
@endsection