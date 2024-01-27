<?php

use App\Models\MenuGroup;
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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MenuGroup::class)->constrained()->cascadeOnDelete();
            $table->nullableMorphs('linkable');
            $table->text('link')->nullable();
            $table->string('title',70)->unique();
            $table->unsignedInteger('order')->nullable();
            $table->boolean('new_tab')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
