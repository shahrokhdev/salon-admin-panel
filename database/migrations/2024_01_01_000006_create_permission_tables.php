<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $teams = config('permission.teams');

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('guard_name')->default('web');
            $table->timestamps();
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('guard_name')->default('web');
            $table->timestamps();
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
            $table->unsignedBigInteger(config('permission.column_names.model_morph_key'));
            $table->string(config('permission.column_names.model_type'));
            $table->foreignId(config('permission.column_names.role_pivot_key'))
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key'])->nullable();
                $table->index([$columnNames['team_foreign_key']]);
            }

            $table->primary(
                [
                    config('permission.column_names.model_morph_key'),
                    config('permission.column_names.model_type'),
                    config('permission.column_names.role_pivot_key'),
                ],
                'model_has_permissions_primary'
            );
        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
            $table->unsignedBigInteger(config('permission.column_names.model_morph_key'));
            $table->string(config('permission.column_names.model_type'));
            $table->foreignId(config('permission.column_names.role_pivot_key'))
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key'])->nullable();
                $table->index([$columnNames['team_foreign_key']]);
            }

            $table->primary(
                [
                    config('permission.column_names.model_morph_key'),
                    config('permission.column_names.model_type'),
                    config('permission.column_names.role_pivot_key'),
                ],
                'model_has_roles_primary'
            );
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->foreignId(config('permission.column_names.role_pivot_key'))
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');
            $table->foreignId(config('permission.column_names.permission_pivot_key'))
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->primary(
                [
                    config('permission.column_names.role_pivot_key'),
                    config('permission.column_names.permission_pivot_key'),
                ],
                'role_has_permissions_primary'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableNames = config('permission.table_names');

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
};
