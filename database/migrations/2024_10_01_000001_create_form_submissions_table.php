<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormSubmissionsTable extends Migration
{
    public function up()
    {
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_definition_id')->constrained();
            $table->bigInteger('user_id')->nullable(); // user associated to this submission, if available
            $table->string('key'); // Key for retrieve submission (controlled by application)
            $table->json('data'); // Store submitted data in JSON
            $table->timestamps();

            $table->comment('created by uspdev-laravel-forms');
            // $table->foreign('form_definition_id')->references('id')->on('form_submissions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_submissions');
    }
}
