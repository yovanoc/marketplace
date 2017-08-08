<?php

namespace App;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\HasApprovals;

use Illuminate\Database\Eloquent\{
    Model,
    SoftDeletes
};

class File extends Model
{
    use SoftDeletes, HasApprovals;

    const APPROVAL_PROPERTIES = [
        'title', 'overview_short', 'overview'
    ];

    protected $fillable = [
        'title', 'overview_short', 'overview', 'price', 'live', 'approved', 'finished'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($file) {
            $file->identifier = uniqid(true);
        });
    }

    public function getRouteKeyName()
    {
        return 'identifier';
    }

    public function getUploadsList()
    {
        return $this->uploads()->approved()->get()->pluck('path')->toArray();
    }

    public function visible()
    {
        if (auth()->user()->isTheSameAs($this->user)) {
            return true;
        }

        if (auth()->user()->isAdmin()) {
            return true;
        }

        return $this->live && $this->approved;
    }

    public function matchesSale(Sale $sale)
    {
        return $this->sales->contains($sale);
    }

    public function scopeFinished(Builder $builder)
    {
        return $builder->where('finished', true);
    }

    public function isFree()
    {
        return $this->price == 0;
    }

    public function calculateCommission()
    {
        return (config('marketplace.sales.commission') / 100) * $this->price;
    }

    public function uploads()
    {
        return $this->hasMany(Upload::class);
    }

    public function mergeApprovalProperties()
    {
        $this->update(array_only(
            $this->approvals->first()->toArray(),
            self::APPROVAL_PROPERTIES
        ));
    }

    public function approve()
    {
        $this->updateToBeVisible();
        $this->approveAllUploads();
    }

    /**
     * Approve all uploads of this file.
     */
    public function approveAllUploads()
    {
        $this->uploads()->update([
            'approved' => true
        ]);
    }

    public function deleteAllApprovals()
    {
        $this->approvals()->delete();
    }

    public function deleteUnapprovedUploads()
    {
        $this->uploads()->unapproved()->delete();
    }

    public function updateToBeVisible()
    {
        $this->update([
            'live' => true,
            'approved' => true
        ]);
    }

    public function approvals()
    {
        return $this->hasMany(FileApproval::class);
    }

    public function createApproval(array $approvalProperties)
    {
        $this->approvals()->create($approvalProperties);
    }

    public function needsApproval(array $approvalProperties)
    {
        if ($this->currentPropertiesDifferToGiven($approvalProperties)) {
            return true;
        }

        if ($this->uploads()->unapproved()->count()) {
            return true;
        }

        return false;
    }

    protected function currentPropertiesDifferToGiven(array $properties)
    {
        return array_only($this->toArray(), self::APPROVAL_PROPERTIES) != $properties;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
