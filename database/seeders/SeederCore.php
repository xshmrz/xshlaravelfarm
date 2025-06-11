<?php
    namespace Database\Seeders;
    use EnumUserIsVendor;
    use Illuminate\Database\Seeder;
    class SeederCore extends Seeder {
        public function run() : void {
            $location                  = Location()->whereNotNull(parent_id)->pluck(id);
            $user                      = User();
            $user->first_name          = 'Root';
            $user->last_name           = 'Demo';
            $user->email               = 'root@demo.com';
            $user->password            = md5('123456');
            $user->gsm                 = fake()->numerify('532#######');
            $user->role                = \EnumUserRole::Root;
            $user->status              = \EnumUserStatus::Active;
            $user->can_login_panel     = \EnumUserCanLoginPanel::No;
            $user->can_login_dashboard = \EnumUserCanLoginDashboard::Yes;
            $user->save();
            for ($iUser = 0; $iUser < 10; $iUser++) {
                $user              = User();
                $user->location_id = fake()->randomElement($location);
                $user->first_name  = fake()->firstName;
                $user->last_name   = fake()->lastName;;
                $user->email               = \Str::slug($user->first_name.'-'.$user->last_name).'@demo.com';
                $user->password            = md5('123456');
                $user->gsm                 = fake()->numerify('532#######');
                $user->role                = \EnumUserRole::User;
                $user->status              = \EnumUserStatus::Active;
                $user->can_login_panel     = \EnumUserCanLoginPanel::No;
                $user->can_login_dashboard = \EnumUserCanLoginDashboard::No;
                $user->is_vendor           = EnumUserIsVendor::Yes;
                $user->save();
                for ($iField = 0; $iField < rand(0, 5); $iField++) {
                    $field              = Field();
                    $field->location_id = fake()->randomElement($location);
                    $field->user_id     = $user->id;
                    $field->name        = fake()->words(rand(2, 3), true);
                    $field->area        = rand(123, 999);
                    $field->save();
                }
            }
        }
    }
