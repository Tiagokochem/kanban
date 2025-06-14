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
                                    
                                    <a href="{{ route('boards.edit', $board) }}" class="inline-flex items-center p-2 text-sm font-medium text-gray-600 dark:text-gray-300 dark:bg-gray-700 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
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
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('createBoardModal');
        const openModalBtn = document.getElementById('openCreateModal');
        const closeModalBtn = document.getElementById('closeCreateModal');
        const submitBtn = document.getElementById('submitCreateBoard');
        const form = document.getElementById('createBoardForm');
        const titleInput = document.getElementById('title');
        const titleError = document.getElementById('titleError');
        
        // Abrir modal
        openModalBtn.addEventListener('click', function() {
            modal.classList.remove('hidden');
            titleInput.value = '';
            titleError.classList.add('hidden');
        });
        
        // Fechar modal
        closeModalBtn.addEventListener('click', function() {
            modal.classList.add('hidden');
        });
        
        // Fechar modal ao clicar fora
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });
        
        // Enviar formulário via AJAX
        submitBtn.addEventListener('click', function() {
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            // Mostrar indicador de carregamento
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Criando...';
            
            // Usar FormData para enviar o formulário
            const formData = new FormData(form);
            
            // Adicionar header para aceitar JSON
            const headers = new Headers();
            headers.append('X-Requested-With', 'XMLHttpRequest');
            headers.append('Accept', 'application/json');
            
            fetch(form.action, {
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
                    modal.classList.add('hidden');
                    
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
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Criar Quadro';
            });
        });
    });
</script>
@endsection
