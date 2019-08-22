<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 30/07/18
	 * Time: 14.53
	 */

	namespace Kosmosx\Helpers\Console;

	use Illuminate\Console\Command;
	use Illuminate\Http\File;
	use Illuminate\Support\Facades\Storage;

	class CreateProvider extends Command
	{
		/**
		 * The console command name.
		 *
		 * @var string
		 */
		protected $signature = "make:kosmosx:provider";

		/**
		 * The console command description.
		 *
		 * @var string
		 */
		protected $description = "Create provider files";


		/**
		 * Execute the console command.
		 *
		 * @return mixed
		 */
		public function handle()
		{
			$name = $this->ask('Name provider?');

			$fileContents = <<<EOT
<?php

	namespace App\Providers;

	use Illuminate\Support\ServiceProvider;

	class {$name}ServiceProvider extends ServiceProvider
	{
		
		/**
		 * Boot the authentication services for the application.
		 *
		 */
		public function boot() {
			\$this->bootConfig();
		}
		
		/**
		 * Register any application services.
		 *
		 * @return void
		 */
		public function register()
		{
			\$this->registerAlias();
			\$this->registerSystem();
			\$this->registerServices();
			\$this->registerMiddleware();
			\$this->registerProviders();
		}

		/**
		 * Register system providers Kernel/Console/Filesystem etc..
		 */
		protected function registerSystem() {}

		/**
		 * Register Services
		 */
		protected function registerServices() {}

		/**
		 * Register middleware
		 */
		protected function registerMiddleware() {}

		/**
		 * Register providers dependency
		 */
		protected function registerProviders() {}

		/**
		 * Load alias
		 */
		protected function registerAlias() {}

		/**
		 * Load config
		 */
		protected function bootConfig() {}
	}
EOT;

			$file_destination = 'app/Providers/' . $name . 'ServiceProvider.php';


			$file = Storage::disk('command')->put($file_destination, $fileContents);

			if ($file) {
				$this->info('Created new Provider ' . $name . 'ServiceProvider.php in App\Providers');
				$this->info('Add this in config/manager.php: ');
				$this->line('\'' . strtolower($name) . '\' => ' . '\\App\\Providers\\' . $name . 'ServiceProvider::class,');
			} else {
				$this->info('Something went wrong');
			}
		}

	}