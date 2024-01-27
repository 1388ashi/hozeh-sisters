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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title',80);
            $table->string('subtitle',80);
            $table->text('summary');
            $table->longText('body');
            $table->string('image',100);
            $table->integer('views_count')->default(0);
            $table->boolean('featured')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamp('published_at')->nullable();
            $table->string('slug')->nullable();
            $table->string('resource_url',80)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedBigInteger(column:'user_id')->default(session()->get('user_title'));
            $table->unsignedBigInteger(column:'category_id');

            $table->foreign('category_id')
            ->references(columns:'id')
            ->on(table:'categories')
            ->onDelete(action:'cascade');
            
            
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
        Schema::dropIfExists('posts');
    }
};
