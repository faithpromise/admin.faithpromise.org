<?php

namespace App\Models;

use FaithPromise\Shared\Models\Staff;
use FaithPromise\Shared\Models\User as BaseUser;

class User extends BaseUser {

    protected $fillable = ['first_name', 'last_name', 'name', 'email', 'password', 'fellowship_one_user_id'];
    protected $appends = ['thumb'];
    protected $visible = ['first_name', 'last_name', 'thumb'];

    public function staff() {
        return $this->hasOne(Staff::class, 'email', 'email');
    }

    public function getThumbAttribute() {

        if ($this->Staff) {
            return image_url('sm', 'quarter', $this->Staff->image);
        }

        return "http://www.gravatar.com/avatar/" . md5(strtolower(trim($this->email))) . "?s=200";
    }

    public function getNameAttribute() {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getFirstNameAttribute() {
        return $this->Staff ? $this->Staff->first_name : $this->getOriginal('first_name');
    }

    public function getLastNameAttribute() {
        return $this->Staff ? $this->Staff->last_name : $this->getOriginal('last_name');
    }

    public function toClient() {

        $visible = $this->visible;

        $user = $this->setVisible(['first_name', 'last_name', 'email', 'thumb'])->toArray();

        $this->setVisible($visible);

        return $user;
    }

}
