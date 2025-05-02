<header>

    @auth
        <div class="menu_profile"> 
                <div class="user_picture"> {{ substr(auth()->user()->name, 0, 1) }} </div>
            

            <nav>
                <ul>
                    <li>
                        <a href="/profile">{{ auth()->user()->name }}</a>
                    </li>
                    <li>
                        <a href="/logout">Sair</a>
                    </li>
                </ul>
            </nav>
        </div>
    @endauth

    @guest
        <x-button class='' linkto='login'>Entrar</x-button>
        <x-button class='' linkto='user-create'>Criar conta</x-button>
    @endguest
</header>

{{-- Mover para arquivo css  --}}
<Style>
div.menu_profile nav{
    display: none;
}

div.menu_profile:hover nav{
    display: block;
}
</Style>