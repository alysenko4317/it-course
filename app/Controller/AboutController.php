<?php

namespace Controller;

use Controller\Controller;  // Ensure you import the base Controller class

class AboutController extends Controller
{
    public function index() {
        $this->display("about");
    }

    public function details() {
        $this->display("details");
    }
}
