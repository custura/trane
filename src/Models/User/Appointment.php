<?php

namespace Custura\Trane\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'privat_appointments';

    protected $fillable = [
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
    ];

    public function user(): BelongsTo
    {
    	return $this->belongsTo(User::class);
    }
}
