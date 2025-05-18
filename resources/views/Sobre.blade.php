@extends('layouts.app')

@section('content')
<div class="bg-fundo py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Seção Quem Somos -->
        <div class="flex flex-col md:flex-row items-center mb-16">
            <div class="md:w-1/3 flex justify-center mb-8 md:mb-0">
                <div class="w-48">
                    <img src="/img/logo/LOGO-PRIDEPATH.svg" alt="Pride Path Logo" class="w-full">
                </div>
            </div>
            <div class="md:w-2/3">
                <h1 class="text-4xl font-bold text-purple-900 mb-8 text-center md:text-left">QUEM SOMOS?</h1>
                <div class="space-y-6 text-gray-700">
                    <p>
                         O Pride Path nasceu com o propósito de oferecer à comunidade LGBTQIA+ um espaço seguro para oferecer e contratar serviços como freelancers. Nosso objetivo é combater a marginalização social e garantir que pessoas LGBTQIA+ possam encontrar oportunidades reais de trabalho autônomo, valorizando suas habilidades e promovendo independência financeira, além de incentivar a diversidade em ambientes profissionais. 
                    </p> 
                    <p>
                         Na plataforma, usuáries podem divulgar seus serviços, contratar profissionais de maneira afirmativa e ética, além de interagir com segurança por meio de avaliações e feedbacks. Também oferecemos um sistema robusto de denúncia, no qual qualquer conta, serviço ou comentário pode ser reportado para análise. Um administrador irá avaliar cada situação individualmente e tomar as medidas cabíveis para manter o ambiente respeitoso e acolhedor para todes. 
                    </p>
                </div>
            </div>
        </div>

        <!-- Seção Nossa História -->
        <div class="mb-16">
            <div class="prose max-w-none text-gray-700 space-y-6">
                <p>
                     A ideia surgiu da percepção de que a comunidade LGBTQIA+, especialmente pessoas trans e não binárias, enfrenta dificuldades não apenas em empregos formais, mas também na prestação de serviços. A Pride Path acredita que o empreendedorismo e o trabalho autônomo podem ser ferramentas poderosas de inclusão, oferecendo autonomia, visibilidade e valorização de talentos muitas vezes ignorados pelo mercado tradicional. 
                </p> 
                <p>
                     O projeto, iniciado por estudantes do curso de Sistemas para Internet, ganhou força com o apoio de pessoas comprometidas com a equidade social. Nosso time de desenvolvedores e colaboradores acredita que a tecnologia pode ser usada para transformar realidades e oferecer novas formas de acesso à renda e reconhecimento. A ideia central é garantir que a identidade de gênero e orientação sexual jamais sejam barreiras para o sucesso profissional. 
                </p>
                <p>
                    Atualmente, a Pride Path também se conecta com empresas e coletivos interessados em promover transformações sociais reais. Embora nosso foco inicial seja o trabalho freelancer, temos planos para, em breve, expandir a plataforma para a publicação de vagas de emprego afirmativas. Mais do que criar um espaço exclusivo, queremos colaborar na construção de um mundo mais inclusivo, onde cada pessoa seja valorizada por suas competências e respeitada por quem é. 
                </p>
            </div>
        </div>

        <!-- Seção Contato -->
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/3 mb-8 md:mb-0">
                <h2 class="text-3xl font-bold text-purple-900 mb-4 text-center md:text-left">ENTRE EM CONTATO CONOSCO</h2>
                <p class="text-gray-700 mb-4">
                    Tem alguma dúvida ou sugestão? Entre em contato conosco através do formulário ao lado.
                </p>
                <div class="flex space-x-4 justify-center md:justify-start">
                    <a href="#" class="text-purple-600 hover:text-purple-800">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="#" class="text-purple-600 hover:text-purple-800">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="#" class="text-purple-600 hover:text-purple-800">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="md:w-2/3 w-full">
                <form action="https://formspree.io/f/mgvkddgg" method="POST" class="bg-gray-50 p-6 rounded-lg shadow-md">
                    <div class="mb-4">
                        <label for="name" class="sr-only">Nome</label>
                        <input type="text" name="name" id="name" placeholder="Nome" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="sr-only">Email</label>
                        <input type="email" name="email" id="email" placeholder="Email" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="sr-only">Telefone</label>
                        <input type="tel" name="phone" id="phone" placeholder="Telefone"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div class="mb-6">
                        <label for="message" class="sr-only">Mensagem</label>
                        <textarea name="message" id="message" rows="5" placeholder="Mensagem" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-500 text-white py-3 px-4 rounded-md hover:bg-blue-600 transition-colors duration-300 uppercase font-medium">
                        Enviar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Script para validação do formulário
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const message = document.getElementById('message');
        
        let isValid = true;
        
        if (name.value.trim() === '') {
            isValid = false;
            name.classList.add('border-red-500');
        } else {
            name.classList.remove('border-red-500');
        }
        
        if (email.value.trim() === '' || !email.value.includes('@')) {
            isValid = false;
            email.classList.add('border-red-500');
        } else {
            email.classList.remove('border-red-500');
        }
        
        if (message.value.trim() === '') {
            isValid = false;
            message.classList.add('border-red-500');
        } else {
            message.classList.remove('border-red-500');
        }
        
        if (!isValid) {
            event.preventDefault();
        }
    });
</script>
@endpush
