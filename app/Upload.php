<?php

namespace App;
use App\Traits\HasApprovals;

use Illuminate\Database\Eloquent\{
    Model,
    SoftDeletes
};

class Upload extends Model
{
    use SoftDeletes, HasApprovals;

    protected $fillable = [
        'filename', 'size', 'approved'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function getPathAttribute()
    {
        return storage_path('app/files/' . $this->file->identifier . '/' . $this->filename);
    }
}
