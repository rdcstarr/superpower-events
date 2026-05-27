<?php

namespace Rdcstarr\SuperpowerEvents\Concerns;

use Rdcstarr\SuperpowerEvents\Events\ModelDeleting as ModelDeletingEvent;

/**
 * Apply to a listener to react to the pre-delete `deleting` lifecycle.
 *
 * The consuming class must implement:
 *
 *     protected function handleModel(YourModel $model): void
 *
 * Fires before the row is actually deleted — useful for cleanup that needs
 * the model still present (e.g. detaching relations, archiving).
 */
trait ModelDeleting
{
	use ResolvesHandlerModel;

	/**
	 * Handle the event — filter by model type, then delegate.
	 *
	 * @param ModelDeletingEvent $event
	 * @return void
	 */
	public function handle(ModelDeletingEvent $event): void
	{
		$expected = $this->resolveHandlerModel();

		if (!$event->model instanceof $expected)
		{
			return;
		}

		$this->handleModel($event->model);
	}
}
