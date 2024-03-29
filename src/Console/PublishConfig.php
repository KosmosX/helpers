<?php

	namespace Kosmosx\Helpers\Console;

	use Illuminate\Console\Command;
	use Illuminate\Filesystem\Filesystem;

	class PublishConfig extends Command
	{
		/**
		 * The name and signature of the console command.
		 *
		 * @var string
		 */
		protected $signature = 'publish:kosmosx:helpers {--force : Overwrite any existing files.}';

		/**
		 * The console command description.
		 *
		 * @var string
		 */
		protected $description = 'Publishes configuration file to config directory of app';

		/**
		 * Filesystem instance for fs operations
		 *
		 * @var Filesystem
		 */
		protected $files;

		/**
		 * A list of files (source => destination)
		 *
		 * @var array
		 */
		protected $fileMap = [];

		public function __construct(Filesystem $files)
		{
			parent::__construct();
			$this->files = $files;

			$fromPath =  str_replace('Console','config',__DIR__);

			$this->fileMap = [
				$fromPath.'/filesystems.php' => app()->basePath('config/filesystems.php'),
				$fromPath.'/api.php' => app()->basePath('config/api.php'),
			];
		}

		/**
		 * Execute the console command.
		 *
		 * @return mixed
		 */
		public function handle()
		{
			foreach ($this->fileMap as $from => $to) {
				if ($this->files->exists($to) && !$this->option('force')) {
					continue;
				}
				$this->createParentDirectory(dirname($to));
				$this->files->copy($from, $to);
				$this->status($from, $to, 'File');
			}
		}

		/**
		 * Create the directory to house the published files if needed.
		 *
		 * @param  string $directory
		 * @return void
		 */
		protected function createParentDirectory($directory)
		{
			if (!$this->files->isDirectory($directory)) {
				$this->files->makeDirectory($directory, 0755, true);
			}
		}

		/**
		 * Write a status message to the console.
		 *
		 * @param  string $from
		 * @param  string $to
		 * @return void
		 */
		protected function status($from, $to)
		{
			$from = str_replace(base_path(), '', realpath($from));
			$to = str_replace(base_path(), '', realpath($to));
			$this->line("<info>Copied File</info> <comment>[{$from}]</comment> <info>To</info> <comment>[{$to}]</comment>");
		}

	}
