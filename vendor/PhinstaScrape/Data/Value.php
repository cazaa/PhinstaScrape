<?php

namespace PhinstaScrape\Data;

class Value
{
    private $dataObject;

    public function __construct($dataObject)
    {
        $this->dataObject = $dataObject;
    }

    public function __call($name, $arguments)
    {
        if (!ctype_alnum($name)) {
            throw new \Exception('Invalid method name ' . $name);
        }

        $method = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));

        $methodPrefix = substr($method, 0, strpos($method, '_'));

        $methodArgument = ltrim(substr($method, strlen($methodPrefix)), '_');

        switch ($methodPrefix) {
            case 'get':
                return $this->get($methodArgument, $name);
            case 'exists':
                return $this->exists($methodArgument);
            default:
                throw new \Exception('Unknown method ' . $name);
        }
    }

    private function get($value, $name)
    {
        if (!$this->exists($value)) {
            throw new \Exception('Magic class does not have method ' . $name);
        }

        if (is_object($this->dataObject->{$value})) {
            return new Value($this->dataObject->{$value});
        }

        if (is_array($this->dataObject->{$value})) {
            $returnArray = [];

            foreach ($this->dataObject->{$value} as $arrayValue) {
                $returnArray[] = new Value($arrayValue);
            }

            return $returnArray;
        }

        return $this->dataObject->{$value};
    }

    private function exists($value)
    {
        return isset($this->dataObject->{$value});
    }
}