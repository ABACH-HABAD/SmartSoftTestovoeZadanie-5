<?php

namespace App\Templates;

class Template
{

    /**
     * @var string
     */
    private $file_name = '';

    /**
     * @var array|null
     */
    private $variables = null;

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->file_name;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setFileName($value)
    {
        $this->file_name = $value;
    }

    /**
     * @return array|null
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * @param array $value
     * @return void
     */
    public function setVariables($value)
    {
        $this->variables = $value;
    }

    /**
     * @return string
     */
    public function view(): string
    {
        $file_name = $this->getFileName();

        $variables = $this->getVariables();

        if ($variables) {
            foreach ($variables as $key => $value) {
                $$key = $value;
            }
        }

        ob_start();
        include $file_name;
        return ob_get_clean();
    }
}
