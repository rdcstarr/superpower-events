<?php

namespace Rdcstarr\SuperpowerEvents;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SuperpowerEventsServiceProvider extends PackageServiceProvider
{
	public function configurePackage(Package $package): void
	{
		$package->name('superpower-events');
	}
}
