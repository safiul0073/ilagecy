<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'caller_id',
        'task',
    ];



    public const TIMELINE_ACTION = [
        'EDIT_NOTE' => 'edited the note.',
        'EDIT_STATUS' => 'changed the caller status.',
        'EDIT_CONFIRM' => 'confirmed the lead.',
    ];

    public function caller()
    {
        return $this->belongsTo(User::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
