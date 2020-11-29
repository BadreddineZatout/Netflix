<?php


namespace App\Models\Core\Auth\Traits\Method;


trait UserStatus
{
    public function isActive()
    {
        return optional($this->status)->name == 'status_active';
    }

    public function isInvited()
    {
        return optional($this->status)->name == 'status_invited';
    }

    public function isInactive()
    {
        return optional($this->status)->name == 'status_inactive';
    }
}