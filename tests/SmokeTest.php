<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Rdcstarr\SuperpowerEvents\Events\ModelCreated;
use Rdcstarr\SuperpowerEvents\Events\ModelCreating;

it('dispatches ModelCreating and ModelCreated when a model with DispatchesModelEvents is saved', function ()
{
	Schema::create('widgets', function (Blueprint $table)
	{
		$table->id();
		$table->string('name');
		$table->timestamps();
	});

	Event::fake([ModelCreating::class, ModelCreated::class]);

	$widget = new class extends \Illuminate\Database\Eloquent\Model
	{
		use \Rdcstarr\SuperpowerEvents\Concerns\DispatchesModelEvents;

		protected $table    = 'widgets';
		protected $guarded  = [];
	};

	$widget->fill(['name' => 'first'])->save();

	Event::assertDispatched(ModelCreating::class, fn($e) => $e->model->name === 'first');
	Event::assertDispatched(ModelCreated::class, fn($e) => $e->model->name === 'first');
});
