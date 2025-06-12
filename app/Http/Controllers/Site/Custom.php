<?php
    namespace App\Http\Controllers\Site;
    use App\Http\Controllers\Controller;
    class Custom extends Controller {
        public function profile() {
            $this->data["appHeader"] = trans("app.Ayarlar");
            render_view($this->data);
        }
        public function profileField() {
            render_view($this->data);
        }
        public function profileSeason() {
            render_view($this->data);
        }
    }
