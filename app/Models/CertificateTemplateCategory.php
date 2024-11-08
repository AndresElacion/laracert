<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateTemplateCategory extends Model
{
    protected $guarded = [];

    public function events()
    {
        return $this->hasMany(Event::class, 'certificate_template_category_id');
    }
}
