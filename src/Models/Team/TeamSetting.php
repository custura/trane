<?php

namespace Custura\Trane\Models\Team;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Team;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamSetting extends Model
{
    use HasFactory;

    protected $table = 'team_settings';

    protected $fillable = [
        'team_id',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
