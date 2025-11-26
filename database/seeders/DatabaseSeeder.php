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