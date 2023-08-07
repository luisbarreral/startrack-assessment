<?php
final class Result 
{
    private $state, $message;

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
}

?>