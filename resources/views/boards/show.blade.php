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
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="categoryForm" action="/boards/{{ $board->id }}/categories" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Nova Coluna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar" id="closeCategoryModalBtn"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Nome da Coluna</label>
                        <input type="text" class="form-control" id="categoryName" name="name" required placeholder="Ex.: To Do, Doing, Done">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" id="cancelCategoryBtn">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="submitCategoryBtn">
                        <i class="bi bi-plus-lg"></i> Adicionar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal para adicionar tarefa --}}
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="taskForm">
                <input type="hidden" id="taskCategoryId">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel">Nova Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar" id="closeTaskModalBtn"></button>
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
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" id="cancelTaskBtn">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="submitTaskBtn">
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
    // Armazenar instâncias do Sortable
    let sortableInstances = {};
    
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
        
        // Configurar os modais para resolver problemas de acessibilidade
        const modalOptions = {
            backdrop: 'static',
            keyboard: false,
            focus: false // Desativar o foco automático
        };
        
        // Inicializar modais com opções personalizadas
        const categoryModalElement = document.getElementById('addCategoryModal');
        const categoryModal = new bootstrap.Modal(categoryModalElement, modalOptions);
        
        const taskModalElement = document.getElementById('addTaskModal');
        const taskModal = new bootstrap.Modal(taskModalElement, modalOptions);
        
        // Botões para fechar os modais
        $('#closeCategoryModalBtn, #cancelCategoryBtn').on('click', function() {
            // Remover foco antes de fechar
            $(this).blur();
            setTimeout(function() {
                categoryModal.hide();
            }, 100);
        });
        
        $('#closeTaskModalBtn, #cancelTaskBtn').on('click', function() {
            // Remover foco antes de fechar
            $(this).blur();
            setTimeout(function() {
                taskModal.hide();
            }, 100);
        });
        
        // Verificar se o botão está sendo clicado
        $('[data-bs-target="#addCategoryModal"]').on('click', function(e) {
            e.preventDefault();
            console.log('Botão Nova Coluna clicado');
            
            // Limpar o formulário
            $('#categoryName').val('');
            
            // Mostrar o modal com um pequeno atraso
            setTimeout(function() {
                categoryModal.show();
            }, 100);
        });
        
        // Eventos do modal de categoria
        $(categoryModalElement).on('show.bs.modal', function () {
            console.log('Modal de categoria: evento show');
        });
        
        $(categoryModalElement).on('shown.bs.modal', function () {
            console.log('Modal de categoria: evento shown');
            // Focar no campo de nome com um pequeno atraso
            setTimeout(function() {
                $('#categoryName').focus();
            }, 200);
        });
        
        $(categoryModalElement).on('hide.bs.modal', function () {
            console.log('Modal de categoria: evento hide');
            // Remover o foco antes de fechar o modal
            document.activeElement.blur();
        });
        
        $(categoryModalElement).on('hidden.bs.modal', function () {
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
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-header bg-primary text-white fw-semibold d-flex justify-content-between align-items-center">
                                    ${category.name}
                                    <button class="btn btn-light btn-sm task-add-btn" data-category-id="${category.id}" title="Nova Tarefa">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group task-list" id="category-${category.id}" data-category-id="${category.id}">
                                        <!-- As tarefas irão aqui -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    `);

                    $('#categories').append(column);

                    loadTasks(category.id);
                });
                
                // Adicionar evento aos botões de nova tarefa
                $('.task-add-btn').on('click', function() {
                    const categoryId = $(this).data('category-id');
                    openTaskModal(categoryId);
                });
            }).fail(function(error) {
                console.error('Erro ao carregar categorias:', error);
            });
        }

        // Definindo a função no escopo global
        loadTasks = function(categoryId) {
            console.log('Carregando tarefas para categoria:', categoryId);
            $.get(`/api/categories/${categoryId}/tasks`, function(tasks) {
                console.log('Tarefas recebidas para categoria', categoryId, ':', tasks);
                const list = $(`#category-${categoryId}`);
                list.empty();

                // Sempre inicializar o Sortable, mesmo sem tarefas
                const sortable = initSortable(categoryId);

                if (!tasks || tasks.length === 0) {
                    // Adicionar um placeholder que não é arrastável
                    list.append(`
                        <li class="list-group-item text-muted fst-italic empty-message" id="empty-${categoryId}">
                            Nenhuma tarefa
                        </li>
                    `);
                } else {
                    // Remover qualquer mensagem de "Nenhuma tarefa" se existir
                    $(`#empty-${categoryId}`).remove();
                    
                    // Adicionar as tarefas à lista
                    tasks.forEach(task => {
                        const item = $(`
                            <li class="list-group-item mb-2 task-item" data-task-id="${task.id}">
                                <strong>${task.title}</strong><br>
                                <small class="text-muted">${task.description ?? ''}</small>
                            </li>
                        `);
                        list.append(item);
                    });
                }
            }).fail(function(error) {
                console.error('Erro ao carregar tarefas:', error);
            });
        };
        
        // Função para inicializar o Sortable em uma lista de tarefas
        function initSortable(categoryId) {
            const el = document.getElementById(`category-${categoryId}`);
            
            // Destruir instância anterior se existir
            if (sortableInstances[categoryId]) {
                sortableInstances[categoryId].destroy();
            }
            
            // Criar nova instância do Sortable
            sortableInstances[categoryId] = new Sortable(el, {
                group: 'tasks', // Permite arrastar entre listas com o mesmo grupo
                animation: 150,
                ghostClass: 'bg-light', // Classe aplicada ao item fantasma durante o arraste
                chosenClass: 'bg-info', // Classe aplicada ao item escolhido
                dragClass: 'sortable-drag', // Classe aplicada ao item durante o arraste
                filter: '.empty-message', // Não permitir arrastar mensagens de "Nenhuma tarefa"
                onStart: function(evt) {
                    // Remover mensagens de "Nenhuma tarefa" de todas as listas
                    $('.empty-message').hide();
                },
                onEnd: function(evt) {
                    const taskId = evt.item.getAttribute('data-task-id');
                    const fromCategoryId = evt.from.getAttribute('data-category-id');
                    const toCategoryId = evt.to.getAttribute('data-category-id');
                    const newIndex = evt.newIndex;
                    
                    console.log(`Tarefa ${taskId} movida da categoria ${fromCategoryId} para ${toCategoryId}, nova posição: ${newIndex}`);
                    
                    // Verificar se a lista de origem ficou vazia
                    if (evt.from.children.length === 0 || 
                        (evt.from.children.length === 1 && evt.from.children[0].classList.contains('empty-message'))) {
                        // Adicionar mensagem de "Nenhuma tarefa" à lista de origem
                        $(evt.from).append(`
                            <li class="list-group-item text-muted fst-italic empty-message" id="empty-${fromCategoryId}">
                                Nenhuma tarefa
                            </li>
                        `);
                    }
                    
                    // Remover mensagem de "Nenhuma tarefa" da lista de destino se existir
                    $(`#empty-${toCategoryId}`).remove();
                    
                    // Se a tarefa foi movida para outra categoria
                    if (fromCategoryId !== toCategoryId) {
                        moveTask(taskId, toCategoryId, newIndex);
                    } else if (evt.oldIndex !== evt.newIndex) {
                        // Se a tarefa foi apenas reordenada na mesma categoria
                        updateTaskOrder(taskId, toCategoryId, newIndex);
                    }
                    
                    // Mostrar novamente as mensagens de "Nenhuma tarefa" que foram escondidas
                    $('.empty-message').show();
                }
            });
            
            return sortableInstances[categoryId];
        }
        
        // Função para mover uma tarefa para outra categoria
        function moveTask(taskId, categoryId, order) {
            $.ajax({
                url: `/api/tasks/${taskId}/move`,
                type: 'POST',
                data: {
                    category_id: categoryId,
                    order: order
                },
                success: function(response) {
                    console.log('Tarefa movida com sucesso:', response);
                },
                error: function(error) {
                    console.error('Erro ao mover tarefa:', error);
                    alert('Erro ao mover tarefa. A página será recarregada.');
                    loadCategories(); // Recarregar tudo em caso de erro
                }
            });
        }
        
        // Função para atualizar a ordem de uma tarefa na mesma categoria
        function updateTaskOrder(taskId, categoryId, order) {
            $.ajax({
                url: `/api/tasks/${taskId}`,
                type: 'PUT',
                data: {
                    order: order
                },
                success: function(response) {
                    console.log('Ordem da tarefa atualizada com sucesso:', response);
                },
                error: function(error) {
                    console.error('Erro ao atualizar ordem da tarefa:', error);
                    loadTasks(categoryId); // Recarregar apenas esta categoria em caso de erro
                }
            });
        }

        // Interceptar o envio do formulário tradicional para fazer via AJAX
        $('#categoryForm').on('submit', function(e) {
            e.preventDefault();
            console.log('Form de categoria submetido via evento submit');
            
            // Desativar o botão de submit para evitar múltiplos envios
            $('#submitCategoryBtn').prop('disabled', true);
            
            const form = $(this);
            const url = form.attr('action');
            const formData = form.serialize();
            
            console.log('URL:', url);
            console.log('Form data:', formData);
            
            // Remover o foco do botão de submit antes de fechar o modal
            document.activeElement.blur();
            
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log('Categoria criada com sucesso:', response);
                    
                    // Remover o foco de qualquer elemento antes de fechar o modal
                    document.activeElement.blur();
                    
                    // Fechar o modal com um pequeno atraso
                    setTimeout(function() {
                        categoryModal.hide();
                        
                        // Limpar o formulário
                        $('#categoryName').val('');
                        
                        // Recarregar as categorias
                        loadCategories();
                        
                        // Reativar o botão de submit
                        $('#submitCategoryBtn').prop('disabled', false);
                    }, 100);
                },
                error: function(error) {
                    console.error('Erro ao criar coluna:', error);
                    alert('Erro ao criar coluna. Verifique o console para detalhes.');
                    
                    // Reativar o botão de submit
                    $('#submitCategoryBtn').prop('disabled', false);
                }
            });
        });
        
        // Função para abrir o modal de nova tarefa
        window.openTaskModal = function(categoryId) {
            console.log('Abrindo modal de tarefa para categoria:', categoryId);
            
            // Limpar o formulário
            $('#taskCategoryId').val(categoryId);
            $('#taskTitle').val('');
            $('#taskDescription').val('');
            
            // Mostrar o modal com um pequeno atraso
            setTimeout(function() {
                taskModal.show();
                
                // Focar no campo de título com um pequeno atraso
                setTimeout(function() {
                    $('#taskTitle').focus();
                }, 200);
            }, 100);
        };
        
        // Submeter tarefa
        $('#taskForm').on('submit', function(e) {
            e.preventDefault();
            console.log('Form de tarefa submetido');
            
            // Desativar o botão de submit para evitar múltiplos envios
            $('#submitTaskBtn').prop('disabled', true);

            const categoryId = $('#taskCategoryId').val();
            const title = $('#taskTitle').val();
            const description = $('#taskDescription').val();
            console.log('Dados da tarefa:', {categoryId, title, description});

            // Remover o foco do botão de submit antes de fechar o modal
            document.activeElement.blur();
            
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
                    
                    // Remover o foco de qualquer elemento antes de fechar o modal
                    document.activeElement.blur();
                    
                    // Fechar o modal com um pequeno atraso
                    setTimeout(function() {
                        taskModal.hide();
                        
                        // Recarregar as tarefas
                        loadTasks(categoryId);
                        
                        // Reativar o botão de submit
                        $('#submitTaskBtn').prop('disabled', false);
                    }, 100);
                },
                error: function(error) {
                    console.error('Erro ao criar tarefa:', error);
                    alert('Erro ao criar tarefa');
                    
                    // Reativar o botão de submit
                    $('#submitTaskBtn').prop('disabled', false);
                }
            });
        });
    });
</script>

<style>
    /* Estilos para o drag and drop */
    .task-item {
        cursor: grab;
        transition: background-color 0.2s, transform 0.1s;
        border-radius: 4px;
    }
    
    .task-item:hover {
        background-color: #f8f9fa;
    }
    
    .sortable-drag {
        opacity: 0.8;
        transform: scale(0.95);
    }
    
    .sortable-ghost {
        opacity: 0.4;
        background-color: #e9ecef !important;
    }
    
    .task-list {
        min-height: 50px;
        padding: 10px 0;
    }
    
    .empty-message {
        border: 1px dashed #ced4da;
        background-color: #f8f9fa;
        color: #6c757d;
        text-align: center;
        cursor: default;
    }
</style>
@endsection