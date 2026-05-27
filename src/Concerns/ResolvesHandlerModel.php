<?php

namespace Rdcstarr\SuperpowerEvents\Concerns;

use LogicException;
use ReflectionMethod;

trait ResolvesHandlerModel
{
	/** @var array<class-string, class-string> */
	private static array $handlerModelCache = [];

	/**
	 * Resolve the expected model class from handleModel()'s first parameter type.
	 *
	 * @return string
	 */
	protected function resolveHandlerModel(): string
	{
		$self = static::class;

		if (isset(self::$handlerModelCache[$self]))
		{
			return self::$handlerModelCache[$self];
		}

		$type = (new ReflectionMethod($this, 'handleModel'))
			->getParameters()[0]
			?->getType()
			?->getName();

		throw_unless(
			filled($type),
			LogicException::class,
			$self . '::handleModel() must declare a typed model parameter.'
		);

		return self::$handlerModelCache[$self] = $type;
	}
}
