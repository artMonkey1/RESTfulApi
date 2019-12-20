<?php

namespace App\Models;

class Chief extends User
{
    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
