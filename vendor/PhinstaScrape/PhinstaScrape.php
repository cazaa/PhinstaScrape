<?php

namespace PhinstaScrape;

use PhinstaScrape\Data\Value;
use PhinstaScrape\Helper\Data;

const INSTAGRAM_HOST      = 'https://www.instagram.com/';
const JSON_JAVASCRIPT_VAR = 'window._sharedData';

class PhinstaScrape
{
    private $pageContent;
    private $data;

    public function __construct($username)
    {
        $profileUrl = INSTAGRAM_HOST . $username . '/';

        $this->pageContent = file_get_contents($profileUrl);

        if ($this->pageContent === false) {
            throw new \Exception('Unable to load profile URL: ' . $profileUrl);
        }

        $this->data = $this->getData();
    }

    public function getData()
    {
        if (!is_null($this->data)) {
            return $this->data;
        }

        $pageContentLines = explode(PHP_EOL, $this->pageContent);

        foreach ($pageContentLines as $pageContentLine) {
            if (strpos($pageContentLine, JSON_JAVASCRIPT_VAR) === false) {
                continue;
            }

            $firstCurlyBracePosition = strpos($pageContentLine, '{');
            $lastCurlyBracePosition = strrpos($pageContentLine, '}');

            $json = substr(
                $pageContentLine,
                $firstCurlyBracePosition,
                $lastCurlyBracePosition - $firstCurlyBracePosition + 1
            );

            return new Data($json);
        }

        throw new \Exception('Unable to locate JSON');
    }

    public function getUser()
    {
        if (!isset($this->data->toObject()->entry_data->ProfilePage[0]->graphql->user)) {
            throw new \Exception('Unable to locate user data');
        }

        return new Value($this->data->toObject()->entry_data->ProfilePage[0]->graphql->user);
    }
}