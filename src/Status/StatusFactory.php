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
		 *
		 * @return StatusService
		 */
		public static function fail(?int $statusCode = null, $data = array(), string $message = null): StatusService {
			return StatusService::set(false, $statusCode, $data, $message);
		}

		/**
		 *    Helper function to wrap StatusService return.
		 *
		 * @param array         $data
		 *    The data this service is returing.
		 * @param null          $statusCode
		 * @param string|string $message
		 *    A message.
		 *
		 * @return ServiceStatus
		 */
		public static function success(?int $statusCode = null, $data = array(), string $message = null): StatusService {
			return StatusService::set(true, $statusCode, $data, $message);
		}
	}