<?php

namespace Rdcstarr\SuperpowerEvents\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Rdcstarr\SuperpowerEvents\SuperpowerEventsServiceProvider;

class TestCase extends BaseTestCase
{
	/**
	 * Return the package service providers to register.
	 *
	 * @param \Illuminate\Foundation\Application $app
	 * @return array<int, class-string>
	 */
	protected function getPackageProviders($app): array
	{
		return [SuperpowerEventsServiceProvider::class];
	}
}
