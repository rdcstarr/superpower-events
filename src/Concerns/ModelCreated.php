<?php

namespace Rdcstarr\SuperpowerEvents\Concerns;

use Rdcstarr\SuperpowerEvents\Events\ModelCreated as ModelCreatedEvent;

/**
 * Apply to a listener to react to the post-save `created` lifecycle.
 *
 * The consuming class must implement:
 *
 *     protected function handleModel(YourModel $model): void
 *
 * The trait reflects on the parameter type and filters before delegating.
 */
trait ModelCreated
{
	use ResolvesHandlerModel;

	/**
	 * Handle the event — filter by model type, then delegate.
	 *
	 * @param ModelCreatedEvent $event
	 * @return void
	 */
	public function handle(ModelCreatedEvent $event): void
	{
		$expected = $this->resolveHandlerModel();

		if (!$event->model instanceof $expected)
		{
			return;
		}

		$this->handleModel($event->model);
	}
}
