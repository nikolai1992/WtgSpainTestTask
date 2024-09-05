<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up()
	{
		Schema::create('comments', function (Blueprint $table) {
			$table->id();
			$table->text('content')->nullable()->default(null);
			$table->unsignedBigInteger('task_id')->nullable()->default(null);
            $table->foreign('task_id')
                ->references('id')
                ->on('tasks')
                ->onDelete('CASCADE');
			$table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('comments');
	}
};
