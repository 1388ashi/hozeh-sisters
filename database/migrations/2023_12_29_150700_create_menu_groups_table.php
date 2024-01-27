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
        Schema::create('menu_groups', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('name')->unique();
            $table->timestamps();
        });

        $data['label'] = 'هدر';
        $data['name'] = 'header';
        $menuGroup = MenuGroup::create($data);

        $data['label'] = 'فوتر';
        $data['name'] = 'footer';
        $menuGroup = MenuGroup::create($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_groups');
    }
};
