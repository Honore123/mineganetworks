<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectRisk extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function risk()
    {
        return $this->hasOne(Risk::class, 'id', 'risk_id');
    }

    public function project()
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }
}
