<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Design Gráfico', 'description' => 'Criação de logotipos, banners, cartões de visita e materiais gráficos.'],
            ['name' => 'Desenvolvimento Web', 'description' => 'Criação de sites, landing pages, lojas virtuais e sistemas web.'],
            ['name' => 'Marketing Digital', 'description' => 'Gestão de redes sociais, tráfego pago, SEO e campanhas de marketing.'],
            ['name' => 'Redação e Tradução', 'description' => 'Produção de textos, artigos, revisão e tradução para diversos idiomas.'],
            ['name' => 'Áudio e Música', 'description' => 'Produção musical, edição de áudio, locuções e jingles.'],
            ['name' => 'Vídeo e Animação', 'description' => 'Edição de vídeo, animações 2D/3D, motion graphics e vídeos promocionais.'],
            ['name' => 'Programação e Tecnologia', 'description' => 'Desenvolvimento de softwares, apps, bots e integrações de sistemas.'],
            ['name' => 'Negócios e Consultoria', 'description' => 'Consultoria empresarial, planejamento estratégico e plano de negócios.'],
            ['name' => 'Suporte Virtual', 'description' => 'Atendimento ao cliente, assistente virtual e serviços administrativos.'],
            ['name' => 'Moda e Estilo', 'description' => 'Consultoria de imagem, moda, maquiagem e personal stylist.'],
            ['name' => 'Artesanato e Handmade', 'description' => 'Produtos artesanais, personalizados e feitos à mão.'],
            ['name' => 'Fotografia', 'description' => 'Edição de fotos, retoques, ensaios fotográficos e manipulação de imagens.'],
            ['name' => 'Educação e Tutoria', 'description' => 'Aulas particulares, mentoria, cursos online e materiais educativos.'],
            ['name' => 'Esportes e Bem-Estar', 'description' => 'Treinos personalizados, nutrição, yoga e meditação.'],
            ['name' => 'Games', 'description' => 'Design de jogos, programação, mods e ilustrações para games.'],
        ]);
        
    }
}
