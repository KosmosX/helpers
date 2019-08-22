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

	class CreateApiController extends Command
	{
		/**
		 * The console command name.
		 *
		 * @var string
		 */
		protected $signature = "make:kosmosx:controller  {--directory=App\\Http\\Controller} {--name=} {--extend=} {--pathExtend=} {--repository=}";

		/**
		 * The console command description.
		 *
		 * @var string
		 */
		protected $description = "Create api controller files";


		/**
		 * Execute the console command.
		 *
		 * @return mixed
		 */
		public function handle()
		{
			$fileExtendNamespace = '';
			$fileRepositoryNamespace = '';
			$fileRepository = '';

			if ($opt_dir = $this->option('directory'))
				$path = $opt_dir;
			else
				$path = $this->ask('Directory (after App\Http\Controller)?');
			$namespacePath = 'app\Http\Controller\\' . $path;

			if ($opt_name = $this->option('name'))
				$name = $opt_name . 'Controller';
			else
				$name = $this->ask('Controller name?') . 'Controller';

			$namespace = $namespacePath . '\\' . $name;

			if ($opt_extend = $this->option('extend'))
				$extend = $opt_extend;
			else
				$extend = $this->ask('Name of extended controller? (press enter to skip)');
			if ($extend != null) {
				if ($opt_pathEx  = $this->option('pathExtend'))
					$namespacePathExtend  = $opt_pathEx;
				else
					$namespacePathExtend = $this->ask('Path of extended controller? (write . if have the same path of Controller)');
				if ($namespacePathExtend == null || $namespacePathExtend == '.')
					$fileExtendNamespace = 'use ' . $namespacePath . '\\' . $extend . ';';
				else
					$fileExtendNamespace = 'use App\Http\Controller\\' . $namespacePathExtend . '\\' . $extend . ';';
			}

			if ($opt_repository  = $this->option('repository'))
				$repository  = $opt_repository;
			else
				$repository = $this->ask('Repository  to connect to controller? (press enter to skip)');
			if ($repository != null) {
				$repository .= 'Repository';
				$fileRepositoryNamespace = 'use App\Repositories\\' . $repository . ';';
				$fileRepository = <<< EOT
	private \$model;
		
		public function __construct()
		{
			parent::__construct();
			\$this->model = app({$repository}::class);
		}
EOT;
			}

			$fileContents = <<<EOT
<?php

	namespace {$namespacePath};

	{$fileExtendNamespace}
	{$fileRepositoryNamespace}
	use Illuminate\Http\Request;

	class {$name} extends {$extend}
	{
		{$fileRepository}
		
		/**
		 * Display a listing of resource.
		 *
		 * Get a JSON representation of all item.
		 *
		 * @Get url
		 * @Versions 
		 * @Response 
		 */
		public function index() {}

		/**
		 * Show
		 *
		 * Get a JSON representation of item.
		 *
		 * @Get url
		 * @Versions 
		 * @Request 
		 * @Response 
		 */
		public function show(\$id) {}


		/**
		 * Create
		 *
		 * Get a JSON representation of item .
		 *
		 * @Get /create
		 * @Versions 
		 * @Request()
		 * @Response
		 */
		public function create(Request \$request) {}

		/**
		 * Store
		 *
		 * Get a JSON representation of new item.
		 *
		 * @Post url
		 * @Versions 
		 * @Request(request)
		 * @Response
		 */
		public function store(Request \$request) {}

		/**
		 * Edit
		 *
		 * Get a JSON representation of update.
		 *
		 * @Get /{id}/edit
		 * @Versions 
		 * @Request {id}
		 * @Response
		 */
		public function edit(\$id) {}

		/**
		 * Update
		 *
		 * Get a JSON representation of update.
		 *
		 * @Put /{id}
		 * @Versions 
		 * @Request (request, id)
		 * @Response
		 */
		public function update(Request \$request, \$id) {}

		/**
		 * Delete
		 *
		 * Get a JSON representation of delete
		 *
		 * @Delete /{id}
		 * @Versions version
		 * @Request {id}
		 * @Response
		 */
		public function delete(\$id) {}
	}

EOT;


			if (!Storage::exists($namespacePath))
				Storage::disk('command')->makeDirectory($namespacePath);

			//$file_destination =  $dir_location . '/RestController.php';
			//Storage::disk('command')->put($file_destination, $this->contentsBaseController($version));
			//$this->info('Created new ApiBaseController.');
			//$this->info('Created new directory for api version: '. $version .'.');

			$file = Storage::disk('command')->put($namespace . '.php', $fileContents);

			if ($file) {
				$this->info('Created new rest controller: ' . $name . ' in ' . $namespacePath . ' directory');
			} else {
				$this->info('Something went wrong');
			}
		}
	}