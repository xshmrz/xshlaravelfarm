<?php
    namespace App\Http\Controllers\Api;
    use App\Http\Controllers\Controller;
    class Home extends Controller {
        public function index() {
            app_view($this->data);
        }
    }
