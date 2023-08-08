<?php
final class Result 
{
    private $state, $message, $data;

	/**
	 * @return mixed
	 */
	public function getState() {
		return $this->state;
	}
	
	/**
	 * @param mixed $state 
	 * @return self
	 */
	public function setState($state): self {
		$this->state = $state;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getMessage() {
		return $this->message;
	}
	
	/**
	 * @param mixed $message 
	 * @return self
	 */
	public function setMessage($message): self {
		$this->message = $message;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getData() {
		return $this->data;
	}
	
	/**
	 * @param mixed $data 
	 * @return self
	 */
	public function setData($data): self {
		$this->data = $data;
		return $this;
	}
}

?>