<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 27/12/18
	 * Time: 13.32
	 */

	namespace Kosmosx\Helpers\Status;

	use Kosmosx\Helpers\Status\StatusService;

	class StatusFactory
	{
		/**
		 *    Helper function to wrap ServiceStatus return.
		 *
		 * @param int $statusCode
		 *    The status code to be passed to ServiceStatus.
		 * @param        array
		 *    Custom data.
		 * @param string $message
		 *    A message.
		 * @param array|null  $validate
		 *
		 * @return \Kosmosx\Helpers\Status\StatusService
		 */
		public static function fail(?int $statusCode = null, $data = array(), string $message = null, ?array $validate = array()): StatusService {
			return StatusService::set(false, $statusCode, $data, $message, $validate);
		}

		/**
		 *    Helper function to wrap StatusService return.
		 *
		 * @param int|null    $statusCode
		 * @param array       $data
		 * @param string|null $message
		 * @param array|null  $validate
		 *
		 * @return \Kosmosx\Helpers\Status\StatusService
		 */
		public static function success(?int $statusCode = null, $data = array(), string $message = null, ?array $validate = array()): StatusService {
			return StatusService::set(true, $statusCode, $data, $message, $validate);
		}
	}