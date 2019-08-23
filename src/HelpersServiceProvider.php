<?php

	namespace Kosmosx\Helpers;

	use Illuminate\Support\ServiceProvider;

	class HelpersServiceProvider extends ServiceProvider
	{
		const COMMANDS = array(
			\Kosmosx\Helpers\Console\PublishConfig::class,
			\Kosmosx\Helpers\Console\CreateProvider::class,
			\Kosmosx\Helpers\Console\CreateTransformer::class,
			\Kosmosx\Helpers\Console\CreateApiController::class,
			\Kosmosx\Helpers\Console\CreateRepositroy::class,
		);

		/**
		 * Register any application services.
		 *
		 * @return void
		 */
		public function register()
		{
			$this->app->alias(\Kosmosx\Helpers\Status\StatusFactoryFacade::class, 'StatusFactory');
			$this->app->alias(\Kosmosx\Helpers\Status\StatusFacade::class, 'Status');

			$this->app->bind('service.status', 'Kosmosx\Helpers\Status\StatusService');
			$this->app->singleton('factory.support', 'Kosmosx\Helpers\Status\StatusFactory');

			$this->commands(self::COMMANDS);
		}
	}
