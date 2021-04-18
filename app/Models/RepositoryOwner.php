<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RepositoryOwner extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'repository_owner';
}
