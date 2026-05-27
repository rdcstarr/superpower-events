<?php

namespace Rdcstarr\SuperpowerEvents\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class ModelCreated
{
	use Dispatchable, SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @param Model $model The freshly created model
	 */
	public function __construct(
		public readonly Model $model,
	) {
		//
	}
}
