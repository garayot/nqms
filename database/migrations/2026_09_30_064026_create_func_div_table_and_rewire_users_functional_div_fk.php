<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('func_div', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->timestamps();

            $table->index('name');
        });

        if (Schema::hasTable('functional_div')) {
            DB::table('functional_div')
                ->orderBy('id')
                ->get(['id', 'name'])
                ->each(function ($row): void {
                    DB::table('func_div')->insert([
                        'id' => $row->id,
                        'name' => $row->name,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                });
        }

        Schema::table('users', function (Blueprint $table): void {
            $table->dropForeign(['functional_div_id']);
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->foreign('functional_div_id')
                ->references('id')
                ->on('func_div')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropForeign(['functional_div_id']);
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->foreign('functional_div_id')
                ->references('id')
                ->on('functional_div')
                ->nullOnDelete();
        });

        Schema::dropIfExists('func_div');
    }
};
