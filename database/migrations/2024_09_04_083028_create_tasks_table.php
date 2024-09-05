<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up()
	{
		Schema::create('tasks', function (Blueprint $table) {
			$table->id();
			$table->string('title')->nullable()->default(null);
			$table->text('description')->nullable()->default(null);
			$table->string('status')->nullable()->default(null);
            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');
            $table->unsignedBigInteger('team_id')->nullable()->default(null);
            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('set null');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('tasks');
	}
};
