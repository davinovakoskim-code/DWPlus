<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabela de Grupos (Ex: TI, Mobiliário)
        Schema::create('equipment_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Tabela de Subgrupos (Ex: Notebook, Cadeira)
        Schema::create('equipment_subgroups', function (Blueprint $table) {
            $table->id();
            // Relaciona com o grupo principal
            $table->foreignId('group_id')
                ->constrained('equipment_groups')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('name');
            $table->timestamps();
        });

        // Tabela de Departamentos (Ex: RH, Financeiro)
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Tabela de Locais (Ex: Matriz, Filial RJ)
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('scope')->nullable(); // Interno/Externo
            $table->timestamps();
        });

        // Tabela Principal de Equipamentos
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('asset_code')->unique(); // Código do patrimônio
            $table->string('name');
            $table->text('description')->nullable();

            // --- ADICIONADO: Relacionamento direto com Grupo ---
            $table->foreignId('group_id')
                ->nullable() // Pode ser nulo se quiser
                ->constrained('equipment_groups')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            // --------------------------------------------------

            // Relacionamento com Subgrupo
            $table->foreignId('subgroup_id')
                ->nullable() // Importante ser nullable caso só se selecione o grupo
                ->constrained('equipment_subgroups')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('status')->default('Disponível');

            // Relacionamentos de Localização e Departamento
            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('location_id')
                ->nullable()
                ->constrained('locations')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->boolean('is_rented')->default(false); // Usei 'is_rented' para padronizar com seu código
            $table->string('attachment_filename')->nullable();

            // --- ADICIONADO: Quem criou e alterou ---
            // Essas colunas são usadas no seu controller
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            // ----------------------------------------

            $table->timestamps();
        });
    }

    public function down(): void
    {
        // A ordem de exclusão é importante por causa das chaves estrangeiras
        Schema::dropIfExists('equipments');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('equipment_subgroups');
        Schema::dropIfExists('equipment_groups');
    }
};