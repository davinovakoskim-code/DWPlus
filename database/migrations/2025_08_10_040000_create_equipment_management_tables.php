<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        
        Schema::create('equipment_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        
        Schema::create('equipment_subgroups', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('group_id')
                ->constrained('equipment_groups')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('name');
            $table->timestamps();
        });

        
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('scope')->nullable(); 
            $table->timestamps();
        });

        
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('asset_code')->unique();
            $table->string('name');
            $table->text('description')->nullable();

            
            $table->foreignId('group_id')
                ->nullable() 
                ->constrained('equipment_groups')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            

           
            $table->foreignId('subgroup_id')
                ->nullable() 
                ->constrained('equipment_subgroups')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('status')->default('Disponível');

            
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

            $table->boolean('is_rented')->default(false); 
            $table->string('attachment_filename')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipments');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('equipment_subgroups');
        Schema::dropIfExists('equipment_groups');
    }
};