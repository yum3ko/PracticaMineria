<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetallesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('historial_id')->unsigned();
			$table->string('url');
			$table->string('palabra_clave');
			$table->integer('coincidencias');
			$table->timestamps();

			$table->foreign('historial_id')->references('id')->on('historial');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('detalles');
	}

}
