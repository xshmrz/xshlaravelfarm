<?php
    namespace App\Http\Controllers\Api\Core;
    use Illuminate\Http\Request;
    use App\Helpers\Validation;
    use App\Http\Controllers\Controller;
    class Field extends Controller {
        public function index() {
            $field         = Field();
            $queryBuilder = new \Bjerke\ApiQueryBuilder\QueryBuilder($field, \request());
            $queryBuilder = $queryBuilder->build();
            if (\request()->has("pagination") && \request()->get("pagination") == "true") {
                if (\request()->has("per_page")) {
                    return responseOk(["message" => trans("app.İşlem Başarılı"), "data" => $queryBuilder->paginate(\request()->get("per_page"))->appends(\request()->except('page'))]);
                }
                else {
                    return responseOk(["message" => trans("app.İşlem Başarılı"), "data" => $queryBuilder->paginate()->appends(\request()->get('page'))]);
                }
            }
            else {
                return responseOk(["message" => trans("app.İşlem Başarılı"), "data" => $queryBuilder->get()]);
            }
        }
        public function store(Request $request) {
            $data = $request->all();
            if (method_exists(Validation::class, "FieldStore")) {
                $validator = Validation::FieldStore($data);
            }
            else {
                $validator = \Validator::make($data, []);
            }
            if ($validator->fails()) {
                return responseUnprocessableEntity(["message" => $validator->errors()->first()]);
            }
            else {
                $field = Field();
                $field->fill($data);
                $field->save();
                return responseOk(["message" => trans("app.İşlem Başarılı"), "data" => $field->toArray()]);
            }
        }
        public function show($id) {
            $field = Field()->find($id);
            if (empty($field)) {
                return responseNotFound(["message" => trans("app.Kayıt Bulunamadı"), "data" => []]);
            }
            return responseOk(["message" => trans("app.İşlem Başarılı"), "data" => $field]);
        }
        public function update(Request $request, $id) {
            $data = $request->all();
            if (method_exists(Validation::class, "FieldUpdate")) {
                $validator = Validation::FieldUpdate($data);
            }
            else {
                $validator = \Validator::make($data, []);
            }
            if ($validator->fails()) {
                return responseUnprocessableEntity(["message" => $validator->errors()->first()]);
            }
            else {
                $field = Field()->find($id);
                if (empty($field)) {
                    return responseNotFound(["message" => trans("app.Kayıt Bulunamadı"), "data" => []]);
                }
                $field->fill($data);
                $field->save();
                return responseOk(["message" => trans("app.İşlem Başarılı"), "data" => $field->toArray()]);
            }
        }
        public function destroy($id) {
            $field = Field()->find($id);
            if (empty($field)) {
                return responseNotFound(["message" => trans("app.Kayıt Bulunamadı"), "data" => []]);
            }
            $field->delete();
            return responseOk(["message" => trans("app.İşlem Başarılı"), "data" => $field->toArray()]);
        }
    }
