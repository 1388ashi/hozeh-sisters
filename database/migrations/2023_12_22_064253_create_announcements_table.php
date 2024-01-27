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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title',80);
            $table->text('summary');
            $table->longText('body');
            $table->string('image',100);
            $table->integer('views_count')->default(0);
            $table->boolean('status')->default(1);
            $table->string('slug')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedBigInteger(column:'user_id')->default(session()->get('user_title'));
            
            
            $table->foreign('user_id')
            ->references(columns:'id')
            ->on(table:'users')
            ->onDelete(action:'cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
