<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
    use SoftDeletes, Blameable;
}
