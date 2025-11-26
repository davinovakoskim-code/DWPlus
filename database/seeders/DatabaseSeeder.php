<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $now = Carbon::now();

        
        //USUÁRIO ADMIN
       
        if (User::where('email', 'admin@dwplus.com.br')->doesntExist()) {
             User::create([
                'name'     => 'Administrador DWPlus',
                'email'    => 'admin@dwplus.com.br',
                'password' => Hash::make('admin123'),
            ]);
            $this->command->info('Usuário Admin criado.');
        }

        
        //DEPARTAMENTOS
        
        DB::table('departments')->truncate();

        $departments = [
            ['name' => 'PF',                 'description' => 'Areá PF da Ag',           'created_at' => $now, 'updated_at' => $now],
            ['name' => 'PJ',                 'description' => 'Areá PJ da Ag',           'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sala TI',            'description' => 'Sala TI da Ag',           'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Dwplus',             'description' => 'Empresa',                 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Areá Técnica DW',    'description' => 'Mesa Técnica dos Fundos', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Aréa de Suporte DW', 'description' => 'Mesa da Areá de Suporte', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Estoque DW',         'description' => 'Estoque da Empresa',      'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Garagem DW',         'description' => 'Garagem da Empresa',      'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('departments')->insert($departments);
        $this->command->info('Departamentos criados.');

        
        //LOCAIS
        
        DB::table('locations')->truncate();

        $locations = [
            // Locais Internos Básicos
            ['name' => 'Matriz DW', 'scope' => 'Interno', 'created_at' => $now, 'updated_at' => $now],
            // Locais Externos (Clientes/Agências)
            ['name' => 'Colégio Sagrada Familia', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Minotto Contabilidade', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Giassi Ferro e Aço', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '20-2604 Sicredi Urussanga', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '12-2604 Ararangua', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Peruch Contabilidade', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '13-2604 Braço do Norte', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '14-2604 Rincão', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Centro Contabil', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'De Lorenzi Contabilidade', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Montagnoli', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Atualiza Sistemas', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'IDB do Brasil', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '30-2604 Meleiro', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '31-2604 Laguna', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '33-2604 Lauro Muller', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '06-2604 Quarta Linha', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '18-2604 Oficinas', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '15-2604 São Martinho', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '21-2604 Sideropolis', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '10-2604 Sicredi Morro da Fumaça', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '09-2604 Forquilhinha', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '19-2604 Orleans', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '11-2604 Prospera', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'TRGW Criciuma', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '17-2604 Metropolitan', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '22-2604 Cocal do Sul', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Trgw Forquilhinha', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '16-2604 Imbituba', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '24-2604 Sombrio', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '23-2604 Turvo', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sescon', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Cliente PF', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '25-2604 São Ludgero', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '26-2604 Praia do Rosa', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '27-2604 Jaguaruna', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '32-2604 Pinheirinho', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '01-2604 Sicredi Sureg', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '02-2604 Sicredi Criciúma Centro', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '34-2604 Nacoes', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '28-2604 Capivari', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '04-2604 Sicredi Rio Maina', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '03-2604 Sicredi Içara', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'EZ Certificados', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'SOS Animal', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '29-2604 Nova Veneza', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '07-2604 Tubarão', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'JD Alimentos', 'scope' => 'Externo', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('locations')->insert($locations);
        $this->command->info('Locais criados.');

        
        //GRUPOS DE EQUIPAMENTO
        
        DB::table('equipment_subgroups')->truncate();
        DB::table('equipment_groups')->truncate();

        $groups = [
            ['name' => 'Equipamento de TI', 'created_at' => $now, 'updated_at' => $now], // ID 1
            ['name' => 'Periféricos',       'created_at' => $now, 'updated_at' => $now], // ID 2
            ['name' => 'Mobiliário',        'created_at' => $now, 'updated_at' => $now], // ID 3
            ['name' => 'Ferramenta',        'created_at' => $now, 'updated_at' => $now], // ID 4
            ['name' => 'Veículo',           'created_at' => $now, 'updated_at' => $now], // ID 5
        ];

        DB::table('equipment_groups')->insert($groups);
        $this->command->info('Grupos criados.');

        
        //SUBGRUPOS DE EQUIPAMENTO
        
        $subgroups = [
            // ID 1: Equipamento de TI
            ['group_id' => 1, 'name' => 'Notebook / Laptop', 'created_at' => $now, 'updated_at' => $now],
            ['group_id' => 1, 'name' => 'Desktop / PC',      'created_at' => $now, 'updated_at' => $now],
            ['group_id' => 1, 'name' => 'Servidor',          'created_at' => $now, 'updated_at' => $now],
            ['group_id' => 1, 'name' => 'Tablet',            'created_at' => $now, 'updated_at' => $now],
            ['group_id' => 1, 'name' => 'Celular',           'created_at' => $now, 'updated_at' => $now],

            // ID 2: Periféricos
            ['group_id' => 2, 'name' => 'Monitores',                       'created_at' => $now, 'updated_at' => $now],
            ['group_id' => 2, 'name' => 'Impressoras',                     'created_at' => $now, 'updated_at' => $now],
            ['group_id' => 2, 'name' => 'Teclado & Mouse (Kits)',          'created_at' => $now, 'updated_at' => $now],
            ['group_id' => 2, 'name' => 'Headset / Fone / Microfone',      'created_at' => $now, 'updated_at' => $now],
            ['group_id' => 2, 'name' => 'Webcam / Equip. Videoconferência','created_at' => $now, 'updated_at' => $now],
            ['group_id' => 2, 'name' => 'Nobreak / Estabilizador',         'created_at' => $now, 'updated_at' => $now],
            ['group_id' => 2, 'name' => 'Dock Station / Hubs',             'created_at' => $now, 'updated_at' => $now],

            // ID 3: Mobiliário
            ['group_id' => 3, 'name' => 'Cadeira de Escritório',           'created_at' => $now, 'updated_at' => $now],
            ['group_id' => 3, 'name' => 'Mesa / Estação de Trabalho',      'created_at' => $now, 'updated_at' => $now],
            ['group_id' => 3, 'name' => 'Armário',                         'created_at' => $now, 'updated_at' => $now],
            ['group_id' => 3, 'name' => 'Sofá de Espera',                  'created_at' => $now, 'updated_at' => $now],
            ['group_id' => 3, 'name' => 'Suporte Ergonômico (Monitor/Pé)', 'created_at' => $now, 'updated_at' => $now],

            // ID 4: Ferramenta
            ['group_id' => 4, 'name' => 'Ferramenta Elétrica (Furadeira, Parafusadeira)', 'created_at' => $now, 'updated_at' => $now],
            ['group_id' => 4, 'name' => 'Ferramenta Manual (Jogos de chaves, Kits)',      'created_at' => $now, 'updated_at' => $now],
            ['group_id' => 4, 'name' => 'Equipamento de Medição',                         'created_at' => $now, 'updated_at' => $now],
            ['group_id' => 4, 'name' => 'Escada / Equip. de Acesso',                      'created_at' => $now, 'updated_at' => $now],
            ['group_id' => 4, 'name' => 'EPI (Equip. Proteção Individual)',               'created_at' => $now, 'updated_at' => $now],

            // ID 5: Veículo
            ['group_id' => 5, 'name' => 'FORD KA',  'created_at' => $now, 'updated_at' => $now],
            ['group_id' => 5, 'name' => 'FIAT UNO', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('equipment_subgroups')->insert($subgroups);
        $this->command->info('Subgrupos criados.');

        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}