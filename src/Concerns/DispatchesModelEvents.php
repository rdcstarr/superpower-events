<?php

namespace Rdcstarr\SuperpowerEvents\Concerns;

use Rdcstarr\SuperpowerEvents\Events\ModelCreated;
use Rdcstarr\SuperpowerEvents\Events\ModelCreating;
use Rdcstarr\SuperpowerEvents\Events\ModelDeleted;
use Rdcstarr\SuperpowerEvents\Events\ModelDeleting;
use Rdcstarr\SuperpowerEvents\Events\ModelUpdated;
use Rdcstarr\SuperpowerEvents\Events\ModelUpdating;

trait DispatchesModelEvents
{
	/**
	 * Boot the trait — fan out generic lifecycle events (pre- and post-save).
	 *
	 * Wraps each dispatch in a void closure so that pre-save hooks (which use
	 * `until()` and halt on any non-null return) do not short-circuit other
	 * `creating`/`updating`/`deleting` callbacks registered on the model.
	 *
	 * @return void
	 */
	public static function bootDispatchesModelEvents(): void
	{
		static::creating(function ($model): void
		{
			ModelCreating::dispatch($model);
		});

		static::created(function ($model): void
		{
			ModelCreated::dispatch($model);
		});

		static::updating(function ($model): void
		{
			ModelUpdating::dispatch($model);
		});

		static::updated(function ($model): void
		{
			ModelUpdated::dispatch($model);
		});

		static::deleting(function ($model): void
		{
			ModelDeleting::dispatch($model);
		});

		static::deleted(function ($model): void
		{
			ModelDeleted::dispatch($model);
		});
	}
}
