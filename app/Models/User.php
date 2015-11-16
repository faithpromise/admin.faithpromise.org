<?php

namespace App\Models;

use FaithPromise\Shared\Models\User as BaseUser;

class User extends BaseUser {

    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'fellowship_one_user_id'];
    protected $appends = ['thumb', 'first_name', 'last_name'];

    public function staff() {
        return $this->hasOne('FaithPromise\Shared\Models\Staff', 'email', 'email');
    }

    public function getThumbAttribute() {
        return image_url('sm', 'quarter', $this->Staff->image);
    }

    public function getFirstNameAttribute() {
        return $this->Staff->first_name;
    }

    public function getLastNameAttribute() {
        return $this->Staff->last_name;
    }

    public function toClient() {

        $visible = $this->visible;

        $user = $this->setVisible(['first_name', 'last_name', 'email', 'thumb'])->toArray();

        $this->setVisible($visible);

        return $user;
    }

}
