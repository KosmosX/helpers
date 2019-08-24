<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 03/08/18
	 * Time: 14.02
	 */
	if (!function_exists('config_path')) {
		/**
		 * Get the configuration path.
		 *
		 * @param string $path
		 *
		 * @return string
		 */
		function config_path($path = '')
		{
			return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
		}
	}

	if (!function_exists('logger_path')) {
		/**
		 * Get the logger_path path.
		 *
		 * @param string $path
		 *
		 * @return string
		 */
		function logger_path($path = '')
		{
			return app()->storagePath() . '/logs' . ($path ? '/' . $path : $path);
		}
	}

	if (!function_exists('framework')) {
		/**
		 * Get version of framework
		 *
		 * @return string
		 */
		function framework(): string
		{
			$version = app()->version();
			if (str_contains($version, 'Lumen'))
				return 'Lumen';

			return 'Laravel';
		}
	}

	if (!function_exists('is_lumen')) {
		/**
		 * Detect framework
		 *
		 * @return string
		 */
		function is_lumen(): string
		{
			return framework() === 'Lumen' ? true : false;
		}
	}

	if (!function_exists('is_laravel')) {
		/**
		 * Detect framework
		 *
		 * @return string
		 */
		function is_laravel(): string
		{
			return framework() === 'Laravel' ? true : false;
		}
	}

	if (!function_exists('register_alias')) {
		/**
		 * @param string $class
		 * @param string $alias
		 * @return bool
		 */
		function register_alias(string $class, string $alias): bool
		{
			if (class_exists($alias))
				return false;

			class_alias($class, $alias);

			return true;
		}
	}

	if (!function_exists('get_config_env')) {
		/**
		 * Get elements of the config file with APP_ENV environment
		 *
		 *
		 * Example will be get config and env is APP_ENV=develop:
		 * get_config_env('api.cors') => config('api.cors.develop')
		 *
		 * Example will be get config and env is APP_ENV=production:
		 * get_config_env('api.cors') => config('api.cors.production')
		 *
		 * Example will be get config and env is APP_ENV=production and default 'standard':
		 * get_config_env('api.cors')
		 *  => config('api.cors.production') if is not empty
		 *  => config('api.cors.standard')   if production is empty
		 *
		 * @param string $config
		 * @param null|string $default
		 *
		 * @return array
		 */
		function get_config_env(string $config, ?string $default = null): array
		{
			$get = config($config . '.' . env('APP_ENV')) ?: array();

			if (empty($get) && null != $default)
				return config($config . '.' . $default) ?: array();

			return $get;
		}
	}