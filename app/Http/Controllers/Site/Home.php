<?php
    namespace App\Http\Controllers\Site;
    use App\Http\Controllers\Controller;
    class Home extends Controller {
        public function index() {
            $this->data['title'] = 'Home';
            render_view($this->data);
        }
    }
