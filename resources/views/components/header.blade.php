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
    const mobileMenuButton = document.getElementById("mobile-menu-button");
    const mobileMenu = document.getElementById("mobile-menu");

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener("click", function() {
            // Toggle the 'hidden' class to show/hide the menu
            mobileMenu.classList.toggle("hidden");
        });
    }
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
</style>
