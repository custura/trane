<?php

namespace Custura\Trane\Models\Team;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Appointment
 * @package App
 * @property int $id
 * @property string $title
 * @property string $notes
 * @property Carbon $scheduled_at
 * @property string priority
 */

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'team_appointments';

    protected $fillable = [
        'title',
        'notes',
        'scheduled_at',
        'start_at',
        'end_at',
        /*'duration',
        'work_duration',
        'pause',*/
        'client_id',
        'task_id',
        'priority',
        'team_id',
        'user_id',
        'project_id',
        'created_by',
        'aproved_by',
    ];

    protected $dates = [
        'scheduled_at',
    ];
}
