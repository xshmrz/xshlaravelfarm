<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    return new class extends Migration {
        public function up() {
            Schema::create("location", function (Blueprint $table) {
                $table->id();
                $table->string("name")->nullable();
                $table->decimal("lat", 11, 8)->nullable();
                $table->decimal("lng", 11, 8)->nullable();
                $table->timestamps();
                $table->softDeletes();
                $table->string("parent_id")->nullable();
                $table->string("parent_name")->nullable();
            });
            Schema::create("user", function (Blueprint $table) {
                $table->id();
                $table->foreignId("location_id")->nullable()->references('id')->on("location");
                $table->string("email")->nullable();
                $table->string("password")->nullable();
                $table->string("first_name")->nullable();
                $table->string("last_name")->nullable();
                $table->string("gsm")->nullable();
                $table->enum("gender", EnumUserGender::asArray())->default(EnumUserGender::I_Do_Not_Want_To_Specify);
                $table->enum("role", EnumUserRole::asArray())->default(EnumUserRole::User);
                $table->enum("status", EnumUserStatus::asArray())->default(EnumUserStatus::Active);
                $table->enum("can_login_panel", EnumUserCanLoginPanel::asArray())->default(EnumUserCanLoginPanel::No);
                $table->enum("can_login_dashboard", EnumUserCanLoginDashboard::asArray())->default(EnumUserCanLoginDashboard::No);
                $table->enum("is_vendor", EnumUserIsVendor::asArray())->default(EnumUserIsVendor::No);
                $table->json("upload")->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
            Schema::create("field", function (Blueprint $table) {
                $table->id();
                $table->foreignId("location_id")->nullable()->references('id')->on("location");
                $table->foreignId("user_id")->nullable()->references('id')->on("user");
                $table->string("name")->nullable();
                $table->decimal("area", 11, 8)->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
        public function down() {
            Schema::dropIfExists("field");
            Schema::dropIfExists("user");
            Schema::dropIfExists("location");
        }
    };
