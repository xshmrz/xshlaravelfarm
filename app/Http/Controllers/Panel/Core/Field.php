<?php
    namespace App\Http\Controllers\Panel\Core;
    use Illuminate\Http\Request;
    use App\Helpers\Validation;
    use App\Http\Controllers\Controller;
    use Validator;
    use Str;
    class Field extends Controller {
        public function index() {
            render_view($this->data);
        }
        public function create() {
            render_view($this->data);
        }
        public function store(Request $request) {
            $data = $request->all();
            if (method_exists(Validation::class, "FieldStore")) {
                $validator = Validation::FieldStore($data);
            }
            else {
                $validator = Validator::make($data, []);
            }
            if ($validator->fails()) {
                session()->flash('validation', Str::title($validator->errors()->first()));
                return redirect()->back()->withInput();
            }
            $field = Field();
            $field->fill($data);
            $field->save();
            session()->flash('success', trans("app.İşlem Başarılı"));
            return $request->has("redirect") ? redirect()->to($request->get("redirect")) : redirect()->route("panel.field.edit", $field->id);
        }
        public function show($id) {
            $this->data["id"] = $id;
            render_view($this->data);
        }
        public function edit($id) {
            $this->data["id"] = $id;
            render_view($this->data);
        }
        public function update(Request $request, $id) {
            $data = $request->all();
            if (method_exists(Validation::class, "FieldUpdate")) {
                $validator = Validation::FieldUpdate($data);
            }
            else {
                $validator = Validator::make($data, []);
            }
            if ($validator->fails()) {
                session()->flash('validation', Str::title($validator->errors()->first()));
                return redirect()->back()->withInput();
            }
            $field = Field()->find($id);
            if (!$field) {
                session()->flash('validation', trans("app.Kayıt Bulunamadı"));
                return redirect()->route("panel.field.index");
            }
            $field->fill($data);
            $field->save();
            session()->flash('success', trans("app.İşlem Başarılı"));
            return $request->has("redirect") ? redirect()->to($request->get("redirect")) : redirect()->route("panel.field.edit", $id);
        }
        public function destroy($id) {
            $field = Field()->find($id);
            if ($field) {
                $field->delete();
                session()->flash('success', trans("app.İşlem Başarılı"));
            }
            else {
                session()->flash('validation', trans("app.Kayıt Bulunamadı"));
            }
            return request()->has("redirect") ? redirect()->to(request()->get("redirect"))->withInput() : redirect()->route("panel.field.index")->withInput();
        }
    }
