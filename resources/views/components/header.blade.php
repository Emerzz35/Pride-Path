<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo e elementos de navegação -->
            <div class="flex items-center space-x-4">
                <!-- Pride Path botão - agora visível para todos os usuários -->
                <x-button 
                    class="flex items-center space-x-2 px-4 py-2 rounded-md hover:bg-indigo-100 transition-colors duration-200"
                    linkto='service-index'
                >
                    <img src="/img/logo/LOGO-PRIDEPATH.svg" alt="Logo" class="w-12 h-12" />
                    <span class="font-bold text-lg h-full">Pride Path</span>
                </x-button>

                <!-- Botões de navegação - visíveis apenas em telas maiores -->
                @auth
                    <div class="hidden md:flex items-center space-x-4">
                        <x-button 
                            class="px-4 py-2 rounded-md hover:bg-indigo-100 transition-colors duration-200" 
                            linkto='service-create'
                        >
                            Postar serviço
                        </x-button>
                        
                        @if (Auth::user()->isAdmin())
                            <x-button 
                                class="px-4 py-2 rounded-md hover:bg-red-100 transition-colors duration-200" 
                                linkto='report-index'
                            >
                                Denúncias
                            </x-button>
                        @endif
                    </div>
                @endauth
            </div>

            <div class="flex items-center space-x-6">
                <!-- Barra de pesquisa e perfil - visíveis apenas em telas maiores -->
                <div class="hidden md:flex items-center space-x-6">
                    @auth
                        <form method="GET" action="{{ route('service-index') }}" class="flex">
                            <input 
                                placeholder="Pesquisar..." 
                                type="text" 
                                name="search" 
                                id="search" 
                                value="{{ request('search') }}"
                                class="px-4 py-2 border border-r-0 border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            >
                            <button 
                                type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-r-md hover:bg-indigo-700 transition-colors duration-200"
                            >
                                Buscar
                            </button>
                        </form>

                        <!-- Notificações -->
                        <div class="notification_menu relative">
                            <div class="notification_icon cursor-pointer relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 hover:text-indigo-600 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span id="notification-badge" class="notification-badge hidden absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                            </div>
                            
                            <div id="notification-dropdown" class="notification-dropdown absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50 hidden">
                                <div class="px-4 py-2 border-b border-gray-200">
                                    <div class="flex justify-between items-center">
                                        <h3 class="text-sm font-semibold text-gray-700">Notificações</h3>
                                        <button id="mark-all-read" class="text-xs text-indigo-600 hover:text-indigo-800">Marcar todas como lidas</button>
                                    </div>
                                </div>
                                <div id="notification-list" class="max-h-80 overflow-y-auto">
                                    <div class="py-2 px-4 text-center text-sm text-gray-500">
                                        Carregando notificações...
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="menu_profile relative ml-4">
                            <div class="user_picture cursor-pointer">
                                <img 
                                    src="/img/profile/{{ auth()->user()->image }}" 
                                    class="w-10 h-10 rounded-full ring-2 ring-indigo-600 object-cover"
                                >
                            </div>
                            
                            <nav class="absolute right-0 mt-2 w-48 origin-top-right">
                                <ul class="bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5">
                                    <li>
                                        <a 
                                            href="/profile/{{ auth()->user()->id }}"
                                            class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 transition-colors duration-200"
                                        >
                                            Meu Perfil
                                        </a>
                                    </li>
                                    <li>
                                        <a 
                                            href="/meus-pedidos"
                                            class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 transition-colors duration-200"
                                        >
                                            Meus Pedidos
                                        </a>
                                    </li>
                                    <li>
                                        <a 
                                            href="/minhas-entregas"
                                            class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 transition-colors duration-200"
                                        >
                                            Minhas entregas
                                        </a>
                                    </li>
                                    <li>
                                        <a 
                                            href="/logout"
                                            class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 transition-colors duration-200"
                                        >
                                            Sair
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    @endauth

                    @guest
                        <x-button 
                            class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md transition-colors duration-200" 
                            linkto='login'
                        >
                            Entrar
                        </x-button>
                        <x-button 
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-200" 
                            linkto='user-create'
                        >
                            Criar conta
                        </x-button>
                    @endguest
                </div>

                <!-- Botão de menu mobile - visível apenas em telas menores -->
                <button 
                    id="mobile-menu-button" 
                    class="md:hidden p-2 rounded-md hover:bg-gray-100 transition-colors duration-200"
                    aria-label="Menu"
                >
                    <x-fas-bars class="text-black w-5" />
                </button>
            </div>
        </div>
    </div>

    <!-- Menu mobile - aparece quando o botão de menu é clicado -->
    <div id="mobile-menu" class="md:hidden hidden bg-white shadow-md">
        <div class="px-4 py-3 space-y-3">
            @auth
                <form method="GET" action="{{ route('service-index') }}" class="flex">
                    <input 
                        placeholder="Pesquisar..." 
                        type="text" 
                        name="search" 
                        id="mobile-search" 
                        value="{{ request('search') }}"
                        class="flex-1 px-4 py-2 border border-r-0 border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    >
                    <button 
                        type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-r-md hover:bg-indigo-700 transition-colors duration-200"
                    >
                        Buscar
                    </button>
                </form>

                <!-- Notificações Mobile -->
                <button id="mobile-notifications-button" class="w-full flex items-center justify-between px-4 py-2 rounded-md hover:bg-indigo-100 transition-colors duration-200">
                    <span>Notificações</span>
                    <span id="mobile-notification-badge" class="bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center hidden">0</span>
                </button>
                
                <div id="mobile-notifications" class="hidden bg-gray-50 rounded-md p-2 max-h-60 overflow-y-auto">
                    <div id="mobile-notification-list" class="space-y-2">
                        <div class="py-2 px-2 text-center text-sm text-gray-500">
                            Carregando notificações...
                        </div>
                    </div>
                </div>

                <x-button 
                    class="w-full px-4 py-2 rounded-md hover:bg-indigo-100 transition-colors duration-200 text-left" 
                    linkto='service-create'
                >
                    Postar serviço
                </x-button>
                
                @if (Auth::user()->isAdmin())
                    <x-button 
                        class="w-full px-4 py-2 rounded-md hover:bg-red-100 transition-colors duration-200 text-left" 
                        linkto='report-index'
                    >
                        Denúncias
                    </x-button>
                @endif

                <div class="flex flex-col space-y-2 py-2">
                    <a 
                        href="/profile/{{ auth()->user()->id }}"
                        class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 rounded-md transition-colors duration-200"
                    >
                        Meu Perfil
                    </a>
                    <a 
                        href="/logout"
                        class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 rounded-md transition-colors duration-200"
                    >
                        Sair
                    </a>
                </div>
            @endauth

            @guest
                <div class="flex flex-col space-y-2">
                    <x-button 
                        class="w-full px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md transition-colors duration-200" 
                        linkto='login'
                    >
                        Entrar
                    </x-button>
                    <x-button 
                        class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-200" 
                        linkto='user-create'
                    >
                        Criar conta
                    </x-button>
                </div>
            @endguest
        </div>
    </div>
</header>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Menu mobile
    const mobileMenuButton = document.getElementById("mobile-menu-button");
    const mobileMenu = document.getElementById("mobile-menu");

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener("click", function() {
            // Toggle the 'hidden' class to show/hide the menu
            mobileMenu.classList.toggle("hidden");
        });
    }
    
    // Notificações
    @auth
    const notificationIcon = document.querySelector('.notification_icon');
    const notificationDropdown = document.getElementById('notification-dropdown');
    const notificationList = document.getElementById('notification-list');
    const notificationBadge = document.getElementById('notification-badge');
    const markAllReadBtn = document.getElementById('mark-all-read');
    
    // Mobile
    const mobileNotificationsButton = document.getElementById('mobile-notifications-button');
    const mobileNotifications = document.getElementById('mobile-notifications');
    const mobileNotificationList = document.getElementById('mobile-notification-list');
    const mobileNotificationBadge = document.getElementById('mobile-notification-badge');
    
    let notifications = [];
    
    // Função para carregar notificações
    function loadNotifications() {
        fetch('/notifications')
            .then(response => response.json())
            .then(data => {
                notifications = data;
                renderNotifications();
                updateNotificationBadge();
            })
            .catch(error => {
                console.error('Erro ao carregar notificações:', error);
                notificationList.innerHTML = '<div class="py-2 px-4 text-center text-sm text-gray-500">Erro ao carregar notificações</div>';
                mobileNotificationList.innerHTML = '<div class="py-2 px-2 text-center text-sm text-gray-500">Erro ao carregar notificações</div>';
            });
    }
    
    // Função para renderizar notificações
    function renderNotifications() {
        if (notifications.length === 0) {
            notificationList.innerHTML = '<div class="py-2 px-4 text-center text-sm text-gray-500">Nenhuma notificação</div>';
            mobileNotificationList.innerHTML = '<div class="py-2 px-2 text-center text-sm text-gray-500">Nenhuma notificação</div>';
            return;
        }
        
        // Desktop
        notificationList.innerHTML = notifications.map(notification => `
            <a href="${notification.link}" class="block py-2 px-4 hover:bg-gray-50 ${!notification.read ? 'bg-blue-50' : ''}" data-id="${notification.id}">
                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-0.5">
                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                            ${getNotificationIcon(notification.type)}
                        </div>
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900 ${!notification.read ? 'font-bold' : ''}">${notification.content}</p>
                        <p class="text-xs text-gray-500">${formatDate(notification.created_at)}</p>
                    </div>
                    ${!notification.read ? `
                    <div class="ml-2 flex-shrink-0">
                        <button class="mark-read-btn inline-flex text-gray-400 hover:text-gray-500" data-id="${notification.id}">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    ` : ''}
                </div>
            </a>
        `).join('');
        
        // Mobile
        mobileNotificationList.innerHTML = notifications.map(notification => `
            <a href="${notification.link}" class="block p-2 rounded-md ${!notification.read ? 'bg-blue-50' : 'bg-white'}" data-id="${notification.id}">
                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-0.5">
                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                            ${getNotificationIcon(notification.type)}
                        </div>
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900 ${!notification.read ? 'font-bold' : ''}">${notification.content}</p>
                        <p class="text-xs text-gray-500">${formatDate(notification.created_at)}</p>
                    </div>
                </div>
            </a>
        `).join('');
        
        // Adicionar event listeners para os botões de marcar como lido
        document.querySelectorAll('.mark-read-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const id = this.getAttribute('data-id');
                markAsRead(id);
            });
        });
    }
    
    // Função para atualizar o badge de notificações
    function updateNotificationBadge() {
        const unreadCount = notifications.filter(n => !n.read).length;
        
        if (unreadCount > 0) {
            notificationBadge.textContent = unreadCount > 9 ? '9+' : unreadCount;
            notificationBadge.classList.remove('hidden');
            
            mobileNotificationBadge.textContent = unreadCount > 9 ? '9+' : unreadCount;
            mobileNotificationBadge.classList.remove('hidden');
        } else {
            notificationBadge.classList.add('hidden');
            mobileNotificationBadge.classList.add('hidden');
        }
    }
    
    // Função para marcar uma notificação como lida
    function markAsRead(id) {
        fetch(`/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Atualizar o estado local
                const notification = notifications.find(n => n.id == id);
                if (notification) {
                    notification.read = true;
                    renderNotifications();
                    updateNotificationBadge();
                }
            }
        })
        .catch(error => console.error('Erro ao marcar notificação como lida:', error));
    }
    
    // Função para marcar todas as notificações como lidas
    function markAllAsRead() {
        fetch('/notifications/read-all', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Atualizar o estado local
                notifications.forEach(n => n.read = true);
                renderNotifications();
                updateNotificationBadge();
            }
        })
        .catch(error => console.error('Erro ao marcar todas notificações como lidas:', error));
    }
    
    // Função para formatar a data
    function formatDate(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diffMs = now - date;
        const diffSec = Math.floor(diffMs / 1000);
        const diffMin = Math.floor(diffSec / 60);
        const diffHour = Math.floor(diffMin / 60);
        const diffDay = Math.floor(diffHour / 24);
        
        if (diffSec < 60) {
            return 'agora mesmo';
        } else if (diffMin < 60) {
            return `${diffMin} ${diffMin === 1 ? 'minuto' : 'minutos'} atrás`;
        } else if (diffHour < 24) {
            return `${diffHour} ${diffHour === 1 ? 'hora' : 'horas'} atrás`;
        } else if (diffDay < 7) {
            return `${diffDay} ${diffDay === 1 ? 'dia' : 'dias'} atrás`;
        } else {
            return date.toLocaleDateString('pt-BR');
        }
    }
    
    // Função para obter o ícone baseado no tipo de notificação
    function getNotificationIcon(type) {
        switch (type) {
            case 'order':
                return '<svg class="h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>';
            case 'rating':
                return '<svg class="h-5 w-5 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>';
            case 'comission':
                return '<svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>';
            default:
                return '<svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
        }
    }
    
    // Event listeners
    if (notificationIcon) {
        notificationIcon.addEventListener('click', function(e) {
            e.stopPropagation();
            notificationDropdown.classList.toggle('hidden');
        });
    }
    
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', function(e) {
            e.preventDefault();
            markAllAsRead();
        });
    }
    
    if (mobileNotificationsButton) {
        mobileNotificationsButton.addEventListener('click', function() {
            mobileNotifications.classList.toggle('hidden');
        });
    }
    
    // Fechar dropdown ao clicar fora
    document.addEventListener('click', function(e) {
        if (notificationDropdown && !notificationDropdown.contains(e.target) && !notificationIcon.contains(e.target)) {
            notificationDropdown.classList.add('hidden');
        }
    });
    
    // Carregar notificações iniciais
    loadNotifications();
    
    // Atualizar notificações a cada 30 segundos
    setInterval(loadNotifications, 30000);
    @endauth
});
</script>

<style>
.menu_profile nav {
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.2s ease;
}

.menu_profile:hover nav {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

/* Estilos para o dropdown de notificações */
.notification-dropdown {
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.2s ease;
}

.notification-dropdown:not(.hidden) {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

/* Animação para o badge de notificação */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.notification-badge:not(.hidden) {
    animation: pulse 2s infinite;
}
</style>
