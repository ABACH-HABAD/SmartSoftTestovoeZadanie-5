<?php

namespace App\Controllers;

use App\Templates\Template;

abstract class Controller
{
    /**
     * @param string $file_name
     * @param array|null $vars
     * @return string
     */
    public function template($file_name, $variables = null): string
    {
        $template = new Template();
        $template->setFileName($file_name);
        $template->setVariables($variables);

        return $template->view();
    }

    /**
     * @return string
     */
    public function view(): string
    {
        return $this->header() . $this->layout() .  $this->footer();
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->header() . $this->error() . $this->Footer();
    }

    /**
     * @return string
     */
    protected function header(): string
    {
        return $this->template("/../Templates/Main/header.html");
    }

    /**
     * @return string
     */
    protected abstract function layout(): string;

    /**
     * @return string
     */
    protected function footer(): string
    {
        return $this->template("/../Templates/Main/footer.html");
    }

    /**
     * @return string
     */
    protected function error(): string
    {
        return $this->template("/../Templates/Main/error.php");
    }
}
