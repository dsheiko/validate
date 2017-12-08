<?php
namespace Dsheiko;

use RuntimeException;
use Dsheiko\Validate\ValidateContractTrait;
use Dsheiko\Validate\ValidateMapTrait;

class Validate
{
    const MANDATORY = "mandatory";
    const OPTIONAL = "optional";

    private $messages = array();
    private $isValid = true;

    use ValidateContractTrait,
        ValidateMapTrait;

    /**
     * Validator factory
     *
     * ->String($password, ["minLength" => 1])
     *
     * @param string $name
     *
     * @return \Validate\ValidateAbstract
     */
    public function factory($name)
    {
        $className = "\\Dsheiko\\Validate\\" . ucfirst($name);
        if (!class_exists($className)) {
            throw new RuntimeException("Validator {$className} not found");
        }
        return new $className();
    }

    /**
     * Factory alias
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return \Validate\ValidateAbstract
     */
    public function __call($name, array $arguments)
    {
        $validator = $this->factory($name);
        if (!$validator) {
            return $this;
        }
        $value = isset($arguments[0]) ? $arguments[0] : null;
        $options = isset($arguments[1]) ? $arguments[1] : [];
        $validator->add($this, $value, $options);
        return $this;
    }

    /**
     * Setter
     *
     * @param bool $isValid
     */
    public function setValid($isValid)
    {
        $this->isValid = $isValid;
    }

    /**
     * Setter
     *
     * @param array $message
     */
    public function pushMessage($message)
    {
        $this->messages[] = $message;
    }

    /**
     * Is the chain valid?
     *
     * @return boolean
     */
    public function isValid()
    {
        return $this->isValid;
    }

    /**
     * Gets messages of all the validators included into the chain
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
