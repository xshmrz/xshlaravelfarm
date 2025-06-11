<?php
    use BenSampo\Enum\Enum;
    abstract class BaseEnum extends Enum {
        public static function translation($key) : mixed {
            return static::setTranslation()[$key] ?? $key;
        }
        public static function color($key) : mixed {
            return static::setColor()[$key] ?? 'secondary';
        }
        public static function select() : array {
            $data   = static::asArray();
            $select = [];
            foreach ($data as $value) {
                $select[$value] = static::translation($value);
            }
            return $select;
        }
        // SHOULD BE OVERRIDDEN IN CHILD CLASSES
        protected static function setTranslation() : array {
            return [];
        }
        protected static function setColor() : array {
            return [];
        }
    }
    final class EnumUpload extends BaseEnum {
        const Profile  = "profile";
        const Cover    = "cover";
        const Gallery  = "gallery";
        const Document = "document";
        public static function multiple($key) : mixed {
            return [
                       self::Profile  => false,
                       self::Cover    => false,
                       self::Gallery  => true,
                       self::Document => true,
                   ][$key];
        }
    }
    final class EnumUserStatus extends BaseEnum {
        const Passive = 1;
        const Active  = 2;
        protected static function setTranslation() : array {
            return [
                self::Passive => trans('app.Pasif'),
                self::Active  => trans('app.Aktif'),
            ];
        }
        protected static function setColor() : array {
            return [
                self::Passive => 'danger',
                self::Active  => 'success',
            ];
        }
    }
    final class EnumUserGender extends BaseEnum {
        const Male                     = 1;
        const Female                   = 2;
        const I_Do_Not_Want_To_Specify = 3;
        protected static function setTranslation() : array {
            return [
                self::Male                     => trans('app.Erkek'),
                self::Female                   => trans('app.Kadın'),
                self::I_Do_Not_Want_To_Specify => trans('app.Belirtmek İstemiyorum'),
            ];
        }
    }
    final class EnumUserRole extends BaseEnum {
        const User  = 1;
        const Admin = 2;
        const Root  = 3;
        protected static function setTranslation() : array {
            return [
                self::User  => trans('app.Kullanıcı'),
                self::Admin => trans('app.Yönetici'),
                self::Root  => trans('app.Root'),
            ];
        }
        protected static function setColor() : array {
            return [
                self::User  => 'success',
                self::Admin => 'warning',
                self::Root  => 'danger',
            ];
        }
    }
    final class EnumUserCanLoginPanel extends BaseEnum {
        const No  = 1;
        const Yes = 2;
        protected static function setTranslation() : array {
            return [
                self::No  => trans('app.Hayır'),
                self::Yes => trans('app.Evet'),
            ];
        }
        protected static function setColor() : array {
            return [
                self::No  => 'danger',
                self::Yes => 'success',
            ];
        }
    }
    final class EnumUserCanLoginDashboard extends BaseEnum {
        const No  = 1;
        const Yes = 2;
        protected static function setTranslation() : array {
            return [
                self::No  => trans('app.Hayır'),
                self::Yes => trans('app.Evet'),
            ];
        }
        protected static function setColor() : array {
            return [
                self::No  => 'danger',
                self::Yes => 'success',
            ];
        }
    }

    final class EnumUserIsVendor extends BaseEnum {
        const No  = 1;
        const Yes = 2;
        protected static function setTranslation() : array {
            return [
                self::No  => trans('app.Hayır'),
                self::Yes => trans('app.Evet'),
            ];
        }
        protected static function setColor() : array {
            return [
                self::No  => 'warning',
                self::Yes => 'success',
            ];
        }
    }
