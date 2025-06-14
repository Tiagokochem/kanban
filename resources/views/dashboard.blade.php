@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 dark:bg-gray-900">
        <!-- Header com título e botão de novo quadro -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Meus Quadros</h1>
            <button id="openCreateModal" class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 border border-transparent rounded-md font-medium text-sm text-white uppercase tracking-wider focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Novo Quadro
            </button>
        </div>

        <!-- Área de quadros -->
        <div id="boards-container">
            @if ($boards->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($boards as $board)
                        <div class="dark:bg-gray-800 overflow-hidden shadow-md rounded-lg hover:shadow-lg transition-shadow duration-300 border border-gray-200 dark:border-gray-700">
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">{{ $board->title }}</h2>
                                    <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100 text-xs font-medium px-2.5 py-0.5 rounded-full">Kanban</span>
                                </div>
                                
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">Criado em {{ $board->created_at->format('d/m/Y') }}</p>
                                
                                <div class="mt-4 flex justify-between items-center">
                                    <a href="{{ route('boards.show', $board) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 dark:bg-blue-500 rounded-md hover:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        Abrir Kanban
                                    </a>
                                    
                                    <div class="flex items-center space-x-2">
                                        <button 
                                            class="edit-board-btn inline-flex items-center p-2 text-sm font-medium text-gray-600 dark:text-gray-300 dark:bg-gray-700 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600"
                                            data-board-id="{{ $board->id }}"
                                            data-board-title="{{ $board->title }}"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        
                                        <button 
                                            class="delete-board-btn inline-flex items-center p-2 text-sm font-medium text-red-600 dark:text-red-400 dark:bg-gray-700 rounded-md hover:bg-red-100 dark:hover:bg-gray-600"
                                            data-board-id="{{ $board->id }}"
                                            data-board-title="{{ $board->title }}"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-400 dark:border-blue-500 p-6 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-base text-blue-700 dark:text-blue-100">
                                Nenhum quadro criado. Clique em <strong>Novo Quadro</strong> para começar.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal de criação de quadro -->
    <div id="createBoardModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay de fundo -->
            <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            
            <!-- Truque para centralizar o modal -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <!-- Conteúdo do modal -->
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4 bg-white dark:bg-gray-800">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                Criar Novo Quadro
                            </h3>
                            <div class="mt-4">
                                <form id="createBoardForm" action="{{ route('boards.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="title" class="block text-base font-medium text-gray-800 dark:text-white mb-2">
                                            Título do Quadro
                                        </label>
                                        <input type="text" 
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-base" 
                                               id="title" 
                                               name="title" 
                                               placeholder="Ex.: Projeto Kanban, Tarefas da Equipe..." 
                                               required>
                                        <p id="titleError" class="mt-2 text-sm text-red-600 dark:text-red-400 hidden"></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                    <button type="button" id="submitCreateBoard" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Criar Quadro
                    </button>
                    <button type="button" id="closeCreateModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de edição de quadro -->
    <div id="editBoardModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title-edit" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay de fundo -->
            <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            
            <!-- Truque para centralizar o modal -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <!-- Conteúdo do modal -->
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4 bg-white dark:bg-gray-800">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title-edit">
                                Editar Quadro
                            </h3>
                            <div class="mt-4">
                                <form id="editBoardForm" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-4">
                                        <label for="edit_title" class="block text-base font-medium text-gray-800 dark:text-white mb-2">
                                            Título do Quadro
                                        </label>
                                        <input type="text" 
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-base" 
                                               id="edit_title" 
                                               name="title" 
                                               required>
                                        <p id="editTitleError" class="mt-2 text-sm text-red-600 dark:text-red-400 hidden"></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                    <button type="button" id="submitEditBoard" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Salvar Alterações
                    </button>
                    <button type="button" id="closeEditModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de confirmação de exclusão -->
    <div id="deleteBoardModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title-delete" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay de fundo -->
            <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            
            <!-- Truque para centralizar o modal -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <!-- Conteúdo do modal -->
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4 bg-white dark:bg-gray-800">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title-delete">
                                Confirmar exclusão
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-300">
                                    Tem certeza que deseja excluir o quadro <span id="delete-board-name" class="font-medium"></span>? Esta ação não pode ser desfeita e todas as categorias e tarefas associadas serão permanentemente removidas.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                    <form id="deleteBoardForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="confirmDeleteBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Excluir
                        </button>
                    </form>
                    <button type="button" id="closeDeleteModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal de criação
        const createModal = document.getElementById('createBoardModal');
        const openCreateModalBtn = document.getElementById('openCreateModal');
        const closeCreateModalBtn = document.getElementById('closeCreateModal');
        const submitCreateBtn = document.getElementById('submitCreateBoard');
        const createForm = document.getElementById('createBoardForm');
        const titleInput = document.getElementById('title');
        const titleError = document.getElementById('titleError');
        
        // Modal de edição
        const editModal = document.getElementById('editBoardModal');
        const closeEditModalBtn = document.getElementById('closeEditModal');
        const submitEditBtn = document.getElementById('submitEditBoard');
        const editForm = document.getElementById('editBoardForm');
        const editTitleInput = document.getElementById('edit_title');
        const editTitleError = document.getElementById('editTitleError');
        const editBtns = document.querySelectorAll('.edit-board-btn');
        
        // Modal de exclusão
        const deleteModal = document.getElementById('deleteBoardModal');
        const closeDeleteModalBtn = document.getElementById('closeDeleteModal');
        const deleteBtns = document.querySelectorAll('.delete-board-btn');
        const deleteForm = document.getElementById('deleteBoardForm');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const deleteBoardName = document.getElementById('delete-board-name');
        
        // Abrir modal de criação
        openCreateModalBtn.addEventListener('click', function() {
            createModal.classList.remove('hidden');
            titleInput.value = '';
            titleError.classList.add('hidden');
        });
        
        // Fechar modal de criação
        closeCreateModalBtn.addEventListener('click', function() {
            createModal.classList.add('hidden');
        });
        
        // Fechar modal de criação ao clicar fora
        window.addEventListener('click', function(event) {
            if (event.target === createModal) {
                createModal.classList.add('hidden');
            }
            if (event.target === editModal) {
                editModal.classList.add('hidden');
            }
            if (event.target === deleteModal) {
                deleteModal.classList.add('hidden');
            }
        });
        
        // Abrir modal de edição
        editBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const boardId = this.getAttribute('data-board-id');
                const boardTitle = this.getAttribute('data-board-title');
                
                editForm.action = `/boards/${boardId}`;
                editTitleInput.value = boardTitle;
                editTitleError.classList.add('hidden');
                
                editModal.classList.remove('hidden');
            });
        });
        
        // Fechar modal de edição
        closeEditModalBtn.addEventListener('click', function() {
            editModal.classList.add('hidden');
        });
        
        // Abrir modal de exclusão
        deleteBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const boardId = this.getAttribute('data-board-id');
                const boardTitle = this.getAttribute('data-board-title');
                
                deleteForm.action = `/boards/${boardId}`;
                deleteBoardName.textContent = boardTitle;
                
                deleteModal.classList.remove('hidden');
            });
        });
        
        // Fechar modal de exclusão
        closeDeleteModalBtn.addEventListener('click', function() {
            deleteModal.classList.add('hidden');
        });
        
        // Enviar formulário de exclusão
        confirmDeleteBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Mostrar indicador de carregamento
            confirmDeleteBtn.disabled = true;
            confirmDeleteBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Excluindo...';
            
            // Usar FormData para enviar o formulário
            const formData = new FormData(deleteForm);
            
            fetch(deleteForm.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(function(response) {
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    return response.json();
                }
            })
            .then(function(data) {
                if (data && data.success) {
                    // Recarregar a página para atualizar a lista
                    window.location.reload();
                }
            })
            .catch(function(error) {
                console.error('Erro:', error);
                // Mesmo com erro, recarregar a página para garantir
                window.location.reload();
            });
        });
        
        // Enviar formulário de criação via AJAX
        submitCreateBtn.addEventListener('click', function() {
            if (!createForm.checkValidity()) {
                createForm.reportValidity();
                return;
            }
            
            // Mostrar indicador de carregamento
            submitCreateBtn.disabled = true;
            submitCreateBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Criando...';
            
            // Usar FormData para enviar o formulário
            const formData = new FormData(createForm);
            
            // Adicionar header para aceitar JSON
            const headers = new Headers();
            headers.append('X-Requested-With', 'XMLHttpRequest');
            headers.append('Accept', 'application/json');
            
            fetch(createForm.action, {
                method: 'POST',
                headers: headers,
                body: formData
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.errors) {
                    // Mostrar erros de validação
                    titleError.textContent = data.errors.title ? data.errors.title[0] : '';
                    titleError.classList.remove('hidden');
                } else {
                    // Sucesso - fechar modal e atualizar lista
                    createModal.classList.add('hidden');
                    
                    // Recarregar a página para mostrar o novo quadro
                    window.location.reload();
                }
            })
            .catch(function(error) {
                console.error('Erro:', error);
                alert('Ocorreu um erro ao criar o quadro. Tente novamente.');
            })
            .finally(function() {
                // Restaurar botão
                submitCreateBtn.disabled = false;
                submitCreateBtn.innerHTML = 'Criar Quadro';
            });
        });
        
        // Enviar formulário de edição via AJAX
        submitEditBtn.addEventListener('click', function() {
            if (!editForm.checkValidity()) {
                editForm.reportValidity();
                return;
            }
            
            // Mostrar indicador de carregamento
            submitEditBtn.disabled = true;
            submitEditBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Salvando...';
            
            // Usar FormData para enviar o formulário
            const formData = new FormData(editForm);
            
            // Adicionar header para aceitar JSON
            const headers = new Headers();
            headers.append('X-Requested-With', 'XMLHttpRequest');
            headers.append('Accept', 'application/json');
            
            fetch(editForm.action, {
                method: 'POST',
                headers: headers,
                body: formData
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.errors) {
                    // Mostrar erros de validação
                    editTitleError.textContent = data.errors.title ? data.errors.title[0] : '';
                    editTitleError.classList.remove('hidden');
                } else {
                    // Sucesso - fechar modal e atualizar lista
                    editModal.classList.add('hidden');
                    
                    // Recarregar a página para mostrar as alterações
                    window.location.reload();
                }
            })
            .catch(function(error) {
                console.error('Erro:', error);
                alert('Ocorreu um erro ao editar o quadro. Tente novamente.');
            })
            .finally(function() {
                // Restaurar botão
                submitEditBtn.disabled = false;
                submitEditBtn.innerHTML = 'Salvar Alterações';
            });
        });
    });
</script>
@endsection
