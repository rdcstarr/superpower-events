<?php

namespace Rdcstarr\SuperpowerEvents\Concerns;

use Rdcstarr\SuperpowerEvents\Events\ModelUpdating as ModelUpdatingEvent;

/**
 * Apply to a listener to react to the pre-save `updating` lifecycle.
 *
 * The consuming class must implement:
 *
 *     protected function handleModel(YourModel $model): void
 *
 * Mutations to $model inside handleModel() persist because Eloquent hasn't
 * written the UPDATE yet. Useful for syncing derived fields (e.g. deactivated_at
 * when is_active flips) without a second query.
 */
trait ModelUpdating
{
	use ResolvesHandlerModel;

	/**
	 * Handle the event — filter by model type, then delegate.
	 *
	 * @param ModelUpdatingEvent $event
	 * @return void
	 */
	public function handle(ModelUpdatingEvent $event): void
	{
		$expected = $this->resolveHandlerModel();

		if (!$event->model instanceof $expected)
		{
			return;
		}

		$this->handleModel($event->model);
	}
}
