<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    public function scopeForWeb()
    {
        return $this->where('is_app', 0);
    }

    public function scopeForApp()
    {
        return $this->where('is_app', 1);
    }
}
