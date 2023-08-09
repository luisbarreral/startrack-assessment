<?php
class Cache
{
    private $key, $data, $time;

    function __construct($key, $data, $time = null)
    {
        $this->setKey($key);
        $this->setData($data);
        $this->setTime($time);
    }

	/**
	 * @return mixed
	 */
	public function getKey() {
		return $this->key;
	}
	
	/**
	 * @param mixed $key 
	 * @return self
	 */
	public function setKey($key): self {
		$this->key = $key;
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

	/**
	 * @return mixed
	 */
	public function getTime() {
		return $this->time;
	}
	
	/**
	 * @param mixed $time 
	 * @return self
	 */
	public function setTime($time): self {
		$this->time = $time;
		return $this;
	}
}

?>