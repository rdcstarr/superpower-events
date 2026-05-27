<?php

namespace Rdcstarr\SuperpowerEvents\Concerns;

use Rdcstarr\SuperpowerEvents\Events\ModelDeleted as ModelDeletedEvent;

/**
 * Apply to a listener to react to the post-delete `deleted` lifecycle.
 *
 * The consuming class must implement:
 *
 *     protected function handleModel(YourModel $model): void
 *
 * The trait reflects on the parameter type and filters before delegating.
 */
trait ModelDeleted
{
	use ResolvesHandlerModel;

	/**
	 * Handle the event — filter by model type, then delegate.
	 *
	 * @param ModelDeletedEvent $event
	 * @return void
	 */
	public function handle(ModelDeletedEvent $event): void
	{
		$expected = $this->resolveHandlerModel();

		if (!$event->model instanceof $expected)
		{
			return;
		}

		$this->handleModel($event->model);
	}
}
