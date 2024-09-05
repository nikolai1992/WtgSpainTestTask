<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up()
	{
		Schema::create('team_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');
            $table->unsignedBigInteger('team_id')->nullable()->default(null);
            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('CASCADE');
		});
	}

	public function down()
	{
		Schema::dropIfExists('team_user');
	}
};
