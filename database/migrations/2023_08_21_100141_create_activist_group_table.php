<?php

use App\Models\Person;
use App\Models\Group;
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
        Schema::create('activist_group', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Person::class);
            $table->foreignIdFor(Group::class);
            $table->enum('status', [
                'in_practice',
                'active',
                'inactive',
            ]);
            $table->date('join_date');
            $table->date('leave_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activist_group');
    }
};
