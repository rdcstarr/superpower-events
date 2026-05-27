<?php

namespace Rdcstarr\SuperpowerEvents\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class ModelUpdating
{
	use Dispatchable, SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @param Model $model The model about to be updated
	 */
	public function __construct(
		public readonly Model $model,
	) {
		//
	}
}
