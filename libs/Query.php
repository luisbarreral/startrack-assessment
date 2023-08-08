<?php
class Query
{
    private $id;
    private $name;
    private $created_at;
    private $updated_at;

    function __construct($name)
    {
        $this->setName($name);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id 
     * @return self
     */
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name 
     * @return self
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

	/**
	 * @return mixed
	 */
	public function getCreated_at() {
		return $this->created_at;
	}

	/**
	 * @return mixed
	 */
	public function getUpdated_at() {
		return $this->updated_at;
	}
}

?>