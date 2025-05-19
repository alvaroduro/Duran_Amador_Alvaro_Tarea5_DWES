<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Crear tabla logs
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->time('hora');
            $table->string('usuario', 100);
            $table->string('operacion', 100);
            $table->timestamps();
        });

        // Crear procedimiento almacenado
        DB::unprepared('
            DROP PROCEDURE IF EXISTS insertar_log;
        ');

        DB::unprepared('
            CREATE PROCEDURE insertar_log (
                IN p_usuario VARCHAR(100),
                IN p_operacion VARCHAR(100)
            )
            BEGIN
                INSERT INTO logs (fecha, hora, usuario, operacion)
                VALUES (CURDATE(), CURTIME(), p_usuario, p_operacion);
            END
        ');
    }

    public function down(): void
    {
        // Eliminar procedimiento y tabla
        DB::unprepared('DROP PROCEDURE IF EXISTS insertar_log');
        Schema::dropIfExists('logs');
    }
};
