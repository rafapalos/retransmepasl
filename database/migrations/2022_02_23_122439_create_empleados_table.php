<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',50);
            $table->string('apellidos',50);
            $table->string('documento',12);
            $table->string('num_documento',9);
            $table->date('fechaNacimiento');
            $table->string('estado',40);
            $table->string('empresa',40);
            $table->string('cargo',20);
            $table->foreignId('id_delegacion')
            ->contrained('delegacions')
            ->cascadeOnUpdate()
            ->nullOnDelete();
            $table->foreignId('id_cargo')
            ->contrained('cargos')
            ->cascadeOnUpdate()
            ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleados');
    }
};
