<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormDefinitionsTable extends Migration
{
    public function up()
    {
        Schema::create('form_definitions', function (Blueprint $table) {
            $table->comment('created by uspdev-laravel-forms');
            $table->id();
            $table->string('name')->unique();
            $table->string('group');
            $table->string('description')->nullable();
            $table->json('fields')->nullable(); // JSON structure of the form
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_definitions');
    }
}
