@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 dark:bg-gray-900">
        <!-- Estilos personalizados para o tema escuro -->
        <style>
            /* Estilos para o tema escuro */
            .dark .modal-content {
                background-color: #111827 !important;
            }
            .dark .modal-body {
                background-color: #111827 !important;
            }
            .dark .modal-content * {
                background-color: #111827 !important;
            }
            .dark .modal-content input {
                background-color: #374151 !important;
                color: white !important;
            }
            .dark .modal-footer {
                background-color: #1f2937 !important;
            }
            .dark .modal-content h3 {
                color: white !important;
            }
            .dark .modal-content label {
                color: white !important;
            }
            .dark .modal-content p {
                color: #d1d5db !important;
            }
            
            /* Garantir que o tema claro funcione corretamente */
            .modal-content {
                background-color: #ffffff !important;
            }
            .modal-body {
                background-color: #ffffff !important;
            }
            .modal-content .bg-white {
                background-color: #ffffff !important;
            }
            .modal-content input {
                background-color: #ffffff !important;
                color: #111827 !important;
            }
            .modal-footer {
                background-color: #f9fafb !important;
            }
            .modal-content h3 {
                color: #111827 !important;
            }
            .modal-content label {
                color: #111827 !important;
            }
            .modal-content p {
                color: #4b5563 !important;
            }
        </style>
        
        <!-- Header com título e botões -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Meus Quadros</h1>
            <div class="flex space-x-3">
                <button id="openAiChatModal" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 border border-transparent rounded-md font-medium text-sm text-white uppercase tracking-wider focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-150 shadow-sm transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    Assistente AI
                </button>
                <button id="openCreateModal" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 border border-transparent rounded-md font-medium text-sm text-white uppercase tracking-wider focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-150 shadow-sm transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Novo Quadro
                </button>
            </div>
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
                                    <a href="{{ route('boards.show', $board) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 dark:bg-blue-500 rounded-md hover:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150 shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        Abrir Kanban
                                    </a>
                                    
                                    <div class="flex items-center space-x-2">
                                        <button 
                                            class="edit-board-btn inline-flex items-center p-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-150 shadow-sm"
                                            data-board-id="{{ $board->id }}"
                                            data-board-title="{{ $board->title }}"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        
                                        <button 
                                            class="delete-board-btn inline-flex items-center p-2 text-sm font-medium text-red-600 dark:text-red-400 bg-red-50 dark:bg-gray-700 rounded-md hover:bg-red-100 dark:hover:bg-gray-600 transition-colors duration-150 shadow-sm"
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
    <div id="createBoardModal" class="fixed inset-0 z-50 hidden overflow-y-auto dark:bg-gray-900/20" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <!-- Overlay de fundo -->
            <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-90 transition-opacity backdrop-blur-sm" aria-hidden="true"></div>
            
            <!-- Conteúdo do modal -->
            <div class="relative inline-block align-bottom bg-white dark:bg-gray-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:align-middle sm:max-w-lg sm:w-full border border-gray-200 dark:border-gray-700 modal-content">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4 bg-white dark:bg-gray-900 modal-body">
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
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 modal-footer">
                    <button type="button" id="submitCreateBoard" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-150">
                        Criar Quadro
                    </button>
                    <button type="button" id="closeCreateModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-150">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de edição de quadro -->
    <div id="editBoardModal" class="fixed inset-0 z-50 hidden overflow-y-auto dark:bg-gray-900/20" aria-labelledby="modal-title-edit" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <!-- Overlay de fundo -->
            <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-90 transition-opacity backdrop-blur-sm" aria-hidden="true"></div>
            
            <!-- Conteúdo do modal -->
            <div class="relative inline-block align-bottom bg-white dark:bg-gray-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:align-middle sm:max-w-lg sm:w-full border border-gray-200 dark:border-gray-700 modal-content">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4 bg-white dark:bg-gray-900 modal-body">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title-edit">
                                Editar Quadro
                            </h3>
                            <div class="mt-4">
                                <form id="editBoardForm" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-4 bg-white dark:bg-gray-900">
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
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 modal-footer">
                    <button type="button" id="submitEditBoard" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-150">
                        Salvar Alterações
                    </button>
                    <button type="button" id="closeEditModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-150">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de confirmação de exclusão -->
    <div id="deleteBoardModal" class="fixed inset-0 z-50 hidden overflow-y-auto dark:bg-gray-900/20" aria-labelledby="modal-title-delete" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <!-- Overlay de fundo -->
            <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-90 transition-opacity backdrop-blur-sm" aria-hidden="true"></div>
            
            <!-- Conteúdo do modal -->
            <div class="relative inline-block align-bottom bg-white dark:bg-gray-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:align-middle sm:max-w-lg sm:w-full border border-gray-200 dark:border-gray-700 modal-content">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4 bg-white dark:bg-gray-900 modal-body">
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
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 modal-footer">
                    <form id="deleteBoardForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="confirmDeleteBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-150">
                            Excluir
                        </button>
                    </form>
                    <button type="button" id="closeDeleteModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-150">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de AI Chat -->
    <div id="aiChatModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title-ai-chat" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <!-- Overlay de fundo -->
            <div class="fixed inset-0 bg-gray-900 bg-opacity-80 dark:bg-black dark:bg-opacity-80 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
            
            <!-- Conteúdo do modal -->
            <div class="relative inline-block align-bottom bg-white dark:bg-gray-800 rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:align-middle sm:max-w-xl sm:w-full border border-gray-200 dark:border-gray-700">
                <!-- Header do modal -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-900 to-blue-900 dark:from-black dark:to-blue-950 relative overflow-hidden">
                    <!-- Decorative AI pattern background -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute left-4 top-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-300" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                        </div>
                        <div class="absolute right-8 bottom-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-300" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <circle cx="12" cy="12" r="10" stroke-width="1" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v8m-4-4h8" />
                            </svg>
                        </div>
                        <div class="absolute right-20 top-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-300" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center relative z-10">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full p-2 mr-3 shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white" id="modal-title-ai-chat">
                                Assistente Kanban AI
                            </h3>
                        </div>
                        <button type="button" id="closeAiChatModal" class="rounded-full p-1.5 bg-blue-500 bg-opacity-20 hover:bg-opacity-30 text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-900 transition-colors duration-150">
                            <span class="sr-only">Fechar</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <div class="p-6 bg-gray-50 dark:bg-gray-900">
                    <p class="text-sm text-gray-600 dark:text-blue-200 mb-4 italic font-medium">
                        Descreva seu projeto e tarefas para que o assistente crie um quadro Kanban personalizado para você.
                    </p>
                    
                    <!-- Área de chat -->
                    <div id="chat-messages" class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 h-72 overflow-y-auto mb-4 border border-gray-100 dark:border-gray-700 shadow-inner">
                        <div class="flex flex-col space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-gradient-to-br from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-700 rounded-full p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                </div>
                                <div class="ml-3 bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-600/40 dark:to-indigo-600/40 rounded-lg px-4 py-3 max-w-md shadow-sm border border-blue-200 dark:border-blue-700">
                                    <p class="text-sm text-gray-800 dark:text-white">
                                        Olá! Descreva seu projeto e as tarefas que você precisa realizar. Eu posso ajudá-lo a criar um quadro Kanban automaticamente.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Área de resposta do AI -->
                    <div id="ai-response-area" class="hidden bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 p-4 rounded-lg mb-4 shadow-sm">
                        <h4 class="font-medium text-blue-800 dark:text-blue-300 mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Sugestão do AI:
                        </h4>
                        <div id="ai-suggestion" class="text-sm text-blue-700 dark:text-blue-200"></div>
                        <div class="mt-4 flex justify-end">
                            <button id="create-from-ai" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 border border-transparent rounded-md font-medium text-sm text-white uppercase tracking-wider focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-150 shadow-sm transform hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Criar Quadro
                            </button>
                        </div>
                    </div>
                    
                    <!-- Input de mensagem -->
                    <div class="flex items-center bg-gray-50 dark:bg-blue-900/30 rounded-lg border border-gray-200 dark:border-blue-700 overflow-hidden shadow-sm">
                        <input type="text" id="chat-input" class="flex-1 px-4 py-3 bg-transparent border-none focus:ring-0 placeholder-gray-400 dark:placeholder-blue-300/70 text-gray-900 dark:text-white text-sm" placeholder="Descreva seu projeto e tarefas...">
                        <button id="send-message" class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                            <span class="mr-2 hidden sm:inline">Enviar</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </button>
                    </div>
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
        
        // Modal de AI Chat
        const aiChatModal = document.getElementById('aiChatModal');
        const openAiChatModalBtn = document.getElementById('openAiChatModal');
        const closeAiChatModalBtn = document.getElementById('closeAiChatModal');
        const chatInput = document.getElementById('chat-input');
        const sendMessageBtn = document.getElementById('send-message');
        const chatMessages = document.getElementById('chat-messages');
        const aiResponseArea = document.getElementById('ai-response-area');
        const aiSuggestion = document.getElementById('ai-suggestion');
        const createFromAiBtn = document.getElementById('create-from-ai');
        
        // Aplicar tema escuro aos modais quando necessário
        function applyDarkMode() {
            // Verificar se o tema escuro está ativo
            const isDarkMode = document.documentElement.classList.contains('dark');
            
            // Função para aplicar tema escuro a um modal
            function applyDarkToModal(modal) {
                const modalContent = modal.querySelector('.relative.inline-block');
                if (modalContent) {
                    if (isDarkMode) {
                        // Aplicar tema escuro
                        modalContent.style.backgroundColor = '#111827'; // bg-gray-900
                        
                        // Aplicar a todos os elementos internos que podem ter fundo branco
                        const innerElements = modalContent.querySelectorAll('.bg-white');
                        innerElements.forEach(el => {
                            el.classList.remove('bg-white');
                            el.classList.add('bg-gray-900');
                        });
                        
                        // Aplicar ao conteúdo principal do modal
                        const modalBody = modalContent.querySelector('.px-4.pt-5.pb-4');
                        if (modalBody) {
                            modalBody.style.backgroundColor = '#111827'; // bg-gray-900
                        }
                    } else {
                        // Garantir tema claro
                        modalContent.style.backgroundColor = '#ffffff';
                        
                        // Garantir que elementos tenham fundo branco no tema claro
                        const darkElements = modalContent.querySelectorAll('.bg-gray-900');
                        darkElements.forEach(el => {
                            el.classList.remove('bg-gray-900');
                            el.classList.add('bg-white');
                        });
                        
                        // Aplicar ao conteúdo principal do modal
                        const modalBody = modalContent.querySelector('.px-4.pt-5.pb-4');
                        if (modalBody) {
                            modalBody.style.backgroundColor = '#ffffff';
                        }
                    }
                }
            }
            
            // Aplicar tema aos modais
            applyDarkToModal(editModal);
            applyDarkToModal(document.getElementById('deleteBoardModal'));
            applyDarkToModal(createModal);
        }
        
        // Verificar tema ao carregar e quando mudar
        applyDarkMode();
        
        // Abrir modal de criação
        openCreateModalBtn.addEventListener('click', function() {
            createModal.classList.remove('hidden');
            titleInput.value = '';
            titleError.classList.add('hidden');
            applyDarkMode(); // Aplicar tema escuro quando abrir o modal
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
                applyDarkMode(); // Aplicar tema escuro quando abrir o modal
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
                applyDarkMode(); // Aplicar tema escuro quando abrir o modal
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
        
        // Abrir modal de AI Chat
        openAiChatModalBtn.addEventListener('click', function() {
            aiChatModal.classList.remove('hidden');
            chatInput.value = '';
            aiResponseArea.classList.add('hidden');
            
            // Garantir que o container de mensagens exista
            const messagesContainer = chatMessages.querySelector('.flex.flex-col.space-y-4');
            if (!messagesContainer) {
                const newContainer = document.createElement('div');
                newContainer.className = 'flex flex-col space-y-4';
                
                // Adicionar a mensagem inicial do assistente
                const initialMessage = document.createElement('div');
                initialMessage.className = 'flex items-start';
                initialMessage.innerHTML = `
                    <div class="flex-shrink-0 bg-gradient-to-br from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-700 rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <div class="ml-3 bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-600/40 dark:to-indigo-600/40 rounded-lg px-4 py-3 max-w-md shadow-sm border border-blue-200 dark:border-blue-700">
                        <p class="text-sm text-gray-800 dark:text-white">
                            Olá! Descreva seu projeto e as tarefas que você precisa realizar. Eu posso ajudá-lo a criar um quadro Kanban automaticamente.
                        </p>
                    </div>
                `;
                newContainer.appendChild(initialMessage);
                
                chatMessages.innerHTML = '';
                chatMessages.appendChild(newContainer);
            }
        });
        
        // Fechar modal de AI Chat
        closeAiChatModalBtn.addEventListener('click', function() {
            aiChatModal.classList.add('hidden');
        });
        
        // Fechar modal de AI Chat ao clicar fora
        window.addEventListener('click', function(event) {
            if (event.target === aiChatModal) {
                aiChatModal.classList.add('hidden');
            }
        });
        
        // Enviar mensagem para o AI
        function sendMessage() {
            const message = chatInput.value.trim();
            if (!message) return;
            
            // Adicionar mensagem do usuário ao chat
            addMessageToChat('user', message);
            
            // Limpar input
            chatInput.value = '';
            
            // Mostrar indicador de carregamento
            addMessageToChat('ai', '<div class="flex items-center"><div class="animate-pulse mr-2 font-medium text-blue-700 dark:text-blue-300">Pensando</div><div class="flex space-x-1"><div class="w-2 h-2 bg-blue-600 dark:bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0ms"></div><div class="w-2 h-2 bg-blue-600 dark:bg-blue-400 rounded-full animate-bounce" style="animation-delay: 150ms"></div><div class="w-2 h-2 bg-blue-600 dark:bg-blue-400 rounded-full animate-bounce" style="animation-delay: 300ms"></div></div></div>');
            
            // Enviar requisição para o servidor
            fetch('{{ route("ai-chat.message") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message })
            })
            .then(response => response.json())
            .then(data => {
                // Remover indicador de carregamento (último elemento)
                const loadingMessage = chatMessages.querySelector('.flex.flex-col.space-y-4')?.lastElementChild;
                if (loadingMessage) {
                    loadingMessage.remove();
                }
                
                if (data.success) {
                    // Mostrar resposta do AI
                    const aiContent = data.aiResponse;
                    
                    // Adicionar mensagem do AI ao chat
                    let aiMessage = "Analisei sua descrição e criei uma sugestão de quadro Kanban.";
                    addMessageToChat('ai', aiMessage);
                    
                    // Mostrar área de resposta do AI
                    aiResponseArea.classList.remove('hidden');
                    
                    // Formatar e mostrar sugestão
                    let suggestionHtml = `<strong>Título do Quadro:</strong> ${aiContent.boardTitle}<br><br>`;
                    suggestionHtml += '<strong>Tarefas:</strong><ul class="list-disc pl-5 mt-2">';
                    
                    aiContent.tasks.forEach(task => {
                        suggestionHtml += `<li class="mb-1"><strong>${task.title}</strong>`;
                        if (task.description) {
                            suggestionHtml += `<br><span class="text-xs">${task.description}</span>`;
                        }
                        suggestionHtml += '</li>';
                    });
                    
                    suggestionHtml += '</ul>';
                    aiSuggestion.innerHTML = suggestionHtml;
                    
                    // Armazenar dados para criação
                    createFromAiBtn.setAttribute('data-ai-response', JSON.stringify(aiContent));
                } else {
                    // Mostrar erro
                    addMessageToChat('ai', 'Desculpe, ocorreu um erro ao processar sua solicitação. Por favor, tente novamente.');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                
                // Remover indicador de carregamento
                const loadingMessage = chatMessages.querySelector('.flex.flex-col.space-y-4')?.lastElementChild;
                if (loadingMessage) {
                    loadingMessage.remove();
                }
                
                // Mostrar erro
                addMessageToChat('ai', 'Desculpe, ocorreu um erro ao processar sua solicitação. Por favor, tente novamente.');
            });
        }
        
        // Adicionar mensagem ao chat
        function addMessageToChat(sender, message) {
            const messageContainer = document.createElement('div');
            messageContainer.className = 'flex items-start';
            
            if (sender === 'user') {
                messageContainer.innerHTML = `
                    <div class="ml-auto bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-600/40 dark:to-purple-600/40 rounded-lg px-4 py-3 max-w-md shadow-sm border border-indigo-200 dark:border-indigo-700">
                        <p class="text-sm text-indigo-800 dark:text-white">${message}</p>
                    </div>
                    <div class="flex-shrink-0 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full p-2 ml-3 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                `;
            } else {
                messageContainer.innerHTML = `
                    <div class="flex-shrink-0 bg-gradient-to-br from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-700 rounded-full p-2 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <div class="ml-3 bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-600/40 dark:to-indigo-600/40 rounded-lg px-4 py-3 max-w-md shadow-sm border border-blue-200 dark:border-blue-700">
                        <p class="text-sm text-gray-800 dark:text-white">${message}</p>
                    </div>
                `;
            }
            
            // Verificar se o container de mensagens existe
            const messagesContainer = chatMessages.querySelector('.flex.flex-col.space-y-4');
            if (messagesContainer) {
                messagesContainer.appendChild(messageContainer);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            } else {
                console.error('Container de mensagens não encontrado');
                // Criar o container se não existir
                const newContainer = document.createElement('div');
                newContainer.className = 'flex flex-col space-y-4';
                newContainer.appendChild(messageContainer);
                chatMessages.innerHTML = '';
                chatMessages.appendChild(newContainer);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        }
        
        // Enviar mensagem ao pressionar Enter
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
        
        // Enviar mensagem ao clicar no botão
        sendMessageBtn.addEventListener('click', sendMessage);
        
        // Criar quadro a partir da resposta do AI
        createFromAiBtn.addEventListener('click', function() {
            const aiResponse = JSON.parse(this.getAttribute('data-ai-response'));
            
            // Mostrar indicador de carregamento
            createFromAiBtn.disabled = true;
            createFromAiBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Criando...';
            
            // Enviar requisição para criar o quadro
            fetch('{{ route("ai-chat.message") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ 
                    message: JSON.stringify(aiResponse),
                    create: true
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.redirectUrl) {
                    // Redirecionar para o novo quadro
                    window.location.href = data.redirectUrl;
                } else {
                    // Mostrar erro
                    alert('Ocorreu um erro ao criar o quadro. Tente novamente.');
                    createFromAiBtn.disabled = false;
                    createFromAiBtn.innerHTML = 'Criar Quadro';
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Ocorreu um erro ao criar o quadro. Tente novamente.');
                createFromAiBtn.disabled = false;
                createFromAiBtn.innerHTML = 'Criar Quadro';
            });
        });
    });
</script>
@endsection
