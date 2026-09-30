<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offices', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        $officeNames = collect();

        if (Schema::hasTable('users') && Schema::hasColumn('users', 'office')) {
            $officeNames = $officeNames->merge(
                DB::table('users')
                    ->whereNotNull('office')
                    ->where('office', '<>', '')
                    ->pluck('office')
            );
        }

        if (Schema::hasTable('whitelisted_users') && Schema::hasColumn('whitelisted_users', 'office')) {
            $officeNames = $officeNames->merge(
                DB::table('whitelisted_users')
                    ->whereNotNull('office')
                    ->where('office', '<>', '')
                    ->pluck('office')
            );
        }

        $officeNames
            ->filter()
            ->unique()
            ->values()
            ->each(function (string $officeName): void {
                DB::table('offices')->insertOrIgnore([
                    'name' => $officeName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });

        Schema::table('users', function (Blueprint $table): void {
            $table->foreignId('office_id')
                ->nullable()
                ->after('office')
                ->constrained('offices')
                ->nullOnDelete();

            $table->foreignId('functional_div_id')
                ->nullable()
                ->after('office_id')
                ->constrained('functional_div')
                ->nullOnDelete();
        });

        DB::table('users')
            ->orderBy('id')
            ->get(['id', 'office'])
            ->each(function ($user): void {
                $officeId = DB::table('offices')
                    ->where('name', $user->office)
                    ->value('id');

                if ($officeId) {
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['office_id' => $officeId]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('functional_div_id');
            $table->dropConstrainedForeignId('office_id');
        });

        Schema::dropIfExists('offices');
    }
};
