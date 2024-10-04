<?php

namespace Controller;

use Controller\Controller;

class AboutController extends Controller
{
    public function index() {
        $this->display("about");
    }

    public function details() {
        $this->display("details");
    }
}
