<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminLogsTable extends Migration
{
    public function up()
    {
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('action');
            $table->text('meta')->nullable();
            $table->timestamps();

            $table->index('admin_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_logs');
    }
}
