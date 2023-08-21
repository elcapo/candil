<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tpetry\QueryExpressions\Function\Conditional\Coalesce;
use Tpetry\QueryExpressions\Function\String\Concat;
use Tpetry\QueryExpressions\Value\Value;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activists', function (Blueprint $table) {
            $grammar = DB::connection()->getQueryGrammar();

            $table->id();
            $table->string('identity_number');
            $table->enum('identity_type', ['nif', 'nie', 'other']);
            $table->string('picture_filename')->nullable();
            $table->string('first_name');
            $table->string('surname');
            $table->string('second_surname')->nullable();
            $table->string('full_name')
                ->virtualAs(
                    (new Concat([
                        'first_name',
                        new Value(' '),
                        'surname',
                        new Value(' '),
                        new Coalesce([
                            'second_surname',
                            new Value(''),
                        ]),
                    ]))->getValue($grammar)
                );
            $table->date('birth_date');
            $table->date('join_date');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('second_phone')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('zip_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activists');
    }
};
