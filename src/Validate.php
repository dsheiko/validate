<?php
namespace Dsheiko;

use RuntimeException;
use Dsheiko\Validate\ValidateContractTrait;
use Dsheiko\Validate\ValidateMapTrait;
use Dsheiko\Validate\ValidateAbstract;

class Validate
{
    const MANDATORY = "mandatory";
    const OPTIONAL = "optional";

    private $messages = [];
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
     * @return \Dsheiko\Validate\ValidateAbstract
     */
    public function factory($name): ValidateAbstract
    {
        $className = "\\Dsheiko\\Validate\\" . ucfirst($name);
        if (!\class_exists($className)) {
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
     * @return \Dsheiko\Validate
     */
    public function __call(string $name, array $arguments): Validate
    {
        $validator = $this->factory($name);
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
    public function setValid(bool $isValid)
    {
        $this->isValid = $isValid;
    }

    /**
     * Setter
     *
     * @param string $message
     */
    public function pushMessage(string $message)
    {
        $this->messages[] = $message;
    }

    /**
     * Is the chain valid?
     *
     * @return boolean
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }

    /**
     * Gets messages of all the validators included into the chain
     *
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
