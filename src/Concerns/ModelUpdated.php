<?php

namespace Rdcstarr\SuperpowerEvents\Concerns;

use Rdcstarr\SuperpowerEvents\Events\ModelUpdated as ModelUpdatedEvent;

/**
 * Apply to a listener to react to the post-save `updated` lifecycle.
 *
 * The consuming class must implement:
 *
 *     protected function handleModel(YourModel $model): void
 *
 * The trait reflects on the parameter type and filters before delegating.
 */
trait ModelUpdated
{
	use ResolvesHandlerModel;

	/**
	 * Handle the event — filter by model type, then delegate.
	 *
	 * @param ModelUpdatedEvent $event
	 * @return void
	 */
	public function handle(ModelUpdatedEvent $event): void
	{
		$expected = $this->resolveHandlerModel();

		if (!$event->model instanceof $expected)
		{
			return;
		}

		$this->handleModel($event->model);
	}
}
