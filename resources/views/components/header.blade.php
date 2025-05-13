<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Botões e elementos de navegação -->
            <div class="flex items-center space-x-4">
                @auth
                    <x-button 
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-200" 
                        linkto='service-index'
                    >
                        Home
                    </x-button>
                    <x-button 
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-200" 
                        linkto='service-create'
                    >
                        Postar serviço
                    </x-button>
                    
                    @if (Auth::user()->isAdmin())
                        <x-button 
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors duration-200" 
                            linkto='report-index'
                        >
                            Denúncias
                        </x-button>
                    @endif
                @endauth
            </div>

            <!-- Área de pesquisa e perfil -->
            <div class="flex items-center space-x-6">
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

                <!-- Menu do perfil -->
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
                                    Minhas Entregas
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
        </div>
    </div>
</header>

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
</style>