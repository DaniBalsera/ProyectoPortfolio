<?php 

namespace App\Controllers;

class BaseController
{
    protected function renderHTML($viewPath, $data = [])
    {
        if (is_array($data)) {
            extract($data);
        }
        include $viewPath;
    }
}

?>