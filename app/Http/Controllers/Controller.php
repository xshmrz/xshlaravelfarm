<?php
    namespace App\Http\Controllers;
    use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\Routing\Controller as BaseController;
    class Controller extends BaseController {
        use AuthorizesRequests, ValidatesRequests;
        public array $data = [];
        public function __construct() {
            $this->data["appHeaderTitle"]      = config("app.name");
            $this->data["appHeaderBackButton"] = true;
        }
    }
