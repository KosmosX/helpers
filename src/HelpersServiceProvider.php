<?php

	namespace Kosmosx\Helpers;

	use Illuminate\Support\ServiceProvider;

	class HelpersServiceProvider extends ServiceProvider
	{
		/**
		 * Register any application services.
		 *
		 * @return void
		 */
		public function register()
		{
			class_alias(\Kosmosx\Helpers\Status\StatusFactoryFacade::class, 'StatusFactory');
			class_alias(\Kosmosx\Helpers\Status\StatusFacade::class, 'Status');

			$this->app->bind('service.status', 'Kosmosx\Helpers\Status\StatusService');
			$this->app->singleton('factory.support', 'Kosmosx\Helpers\Status\StatusFactory');
		}
	}
