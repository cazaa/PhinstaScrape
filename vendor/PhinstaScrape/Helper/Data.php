<?php

namespace PhinstaScrape\Helper;

class Data
{
    private $json;
    private $object;

    public function __construct($json)
    {
        $this->json = $json;
        $this->object = json_decode($json);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid JSON string');
        }
    }

    public function toObject()
    {
        return $this->object;
    }

    public function toJson()
    {
        return $this->json;
    }

    public function __toString()
    {
        return $this->json;
    }
}