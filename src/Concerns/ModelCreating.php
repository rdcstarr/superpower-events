<?php

namespace Rdcstarr\SuperpowerEvents\Concerns;

use Rdcstarr\SuperpowerEvents\Events\ModelCreating as ModelCreatingEvent;

/**
 * Apply to a listener to react to the pre-save `creating` lifecycle.
 *
 * The consuming class must implement:
 *
 *     protected function handleModel(YourModel $model): void
 *
 * Mutations to $model inside handleModel() persist because Eloquent hasn't
 * written the row yet. Useful for defaulting fields, normalizing values,
 * or generating UUIDs without a second UPDATE query.
 */
trait ModelCreating
{
	use ResolvesHandlerModel;

	/**
	 * Handle the event — filter by model type, then delegate.
	 *
	 * @param ModelCreatingEvent $event
	 * @return void
	 */
	public function handle(ModelCreatingEvent $event): void
	{
		$expected = $this->resolveHandlerModel();

		if (!$event->model instanceof $expected)
		{
			return;
		}

		$this->handleModel($event->model);
	}
}
