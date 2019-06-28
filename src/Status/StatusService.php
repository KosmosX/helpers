<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 27/12/18
	 * Time: 11.11
	 */

	namespace Kosmosx\Helpers\Status;


	use Illuminate\Support\Arr;

	class StatusService
	{
		/**
		 * @var bool
		 */
		protected $success;

		/**
		 * @var array
		 */
		protected $data;

		/**
		 * @var array
		 */
		protected $validate;

		/**
		 * @var string
		 */
		protected $message;

		/**
		 * @var string
		 */
		protected $statusCode;

		/**
		 *  Default constructor.
		 *
		 * @param bool   $success
		 * @param int    $statusCode
		 * @param array  $data
		 * @param string $message
		 * @param array|null $validate
		 */
		public function __construct(bool $success = null, ?int $statusCode = null, $data = array(), ?string $message = null, ?array $validate = array()) {
			$this->success = $success;
			$this->data = $data;
			$this->statusCode = $statusCode;
			$this->message = $message;
			$this->validate = $validate;
		}

		/**
		 *
		 *  Instances factory.
		 *
		 * @param bool   $success
		 * @param int    $statusCode
		 * @param array  $data
		 * @param string $message
		 *
		 * @return StatusService
		 *    The instance.
		 */
		public static function set(bool $success, ?int $statusCode = null, $data = array(), ?string $message = null): StatusService {
			return new StatusService($success, $statusCode, $data, $message);
		}

		/**
		 * @param null $keys
		 *
		 * @return array
		 */
		public function data($keys = null) {
			return $this->search($this->data,$keys);
		}

		/**
		 * @param null $keys
		 *
		 * @return array
		 */
		public function validate($keys = null) {
			return $this->search($this->validate,$keys);
		}

		/**
		 *
		 * @param $stack
		 * @param string|array $keys
		 *    Optional key in the data associative array.
		 *    Key maybe use DOT notation
		 *
		 * @return array
		 *    The data array or the requested item if $key is set.
		 */
		protected function search($stack, $keys) {
			if (false == is_array($stack) || null == $keys)
				return $stack;

			if (true === is_string($keys))
				$keys = (array)$keys;

			$data = array();

			foreach ($keys as $key)
				$data[last(explode('.', $key))] = Arr::get($stack, $key, null);

			return $data;
		}

		/**
		 * @param $data
		 *
		 * @return array
		 */
		public function setData($data) {
			$this->data = $data;

			return $this;
		}

		/**
		 * @param array|null $validate
		 * @param bool       $setFailStatus
		 *
		 * @return array|null
		 */
		public function setValidate(?array $validate, bool $setFailStatus = true) {
			if(true === $setFailStatus)
				$this->success = false;

			$this->validate = $validate;

			return $this;
		}

		/**
		 * @param int $withStatusCode
		 *    The status code to be searched.
		 *
		 * @return bool
		 *    TRUE if service method failed.
		 *    When $with is provided, returns TRUE when
		 *    method failed (AND) with the specified
		 *    status code.
		 */
		public function isFail(int $withStatusCode = null): bool {
			if ($withStatusCode) {
				return !$this->success && $withStatusCode === $this->statusCode;
			}

			return !$this->success;
		}

		/**
		 * @return bool
		 */
		public function isValidate(){
			return $this->validate ? true : false;
		}

		/**
		 * @return string
		 *        The message.
		 */
		public function message(): ?string {
			return $this->message;
		}

		/**
		 * @param string $message
		 *
		 * @return null|string
		 */
		public function setMessage(string $message): ?string {
			$this->message = $message;
			return $this;
		}

		/**
		 * @return int
		 *        The service status.
		 */
		public function status(): ?int {
			return $this->statusCode;
		}

		/**
		 * @param int $statusCode
		 *
		 * @return int|null
		 */
		public function setStatus(int $statusCode): ?int {
			$this->statusCode = $statusCode;
			return $this;
		}

		/**
		 * @param string $with
		 *    The status code to be searched.
		 *
		 * @return bool
		 *    TRUE if service method ran successfully.
		 *    When $with is provided, returns TRUE when
		 *    method ran successfully AND with the specified
		 *    status code.
		 */
		public function isSuccess(int $withStatusCode = null): bool {
			if ($withStatusCode) {
				return $this->success && $withStatusCode === $this->statusCode;
			}

			return $this->success;
		}

		public function __toString() {
			$toString = json_encode($this->toArray(), JSON_FORCE_OBJECT);
			return $toString;
		}

		public function toArray() {
			return array(
				'success' => $this->success,
				'data' => $this->data,
				'message' => $this->message,
				'status_code' => $this->statusCode,
			);
		}

	}