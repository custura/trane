<?php

namespace Custura\Trane\Models\Team;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Custura\Trane\Team as TraneTeam;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamRole extends TraneTeam
{
    use HasFactory;

    protected $table = 'team_roles';

    protected $fillable = [
        'team_id',
        'key',
        'name',
        'description',
        'permissions',
        'status',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}


/*
    @if ($team->roles->isNotEmpty())
        @foreach ($team->roles->sortBy('name') as $role)
        <div class="ml-4">{{ $role->name }}</div>
        @endforeach
    @endif
 */

 /*
 @if ($team->selectUserRoles->isNotEmpty())
    <div class="col-span-6 lg:col-span-4">
        <x-label for="role" value="{{ __('Role') }}" />
        <x-input-error for="role" class="mt-2" />

        <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
            @if ($team->selectUserRoles->isNotEmpty())
                    @foreach ($team->selectUserRoles as $index => $role)
                    <button type="button" class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 {{ $index > 0 ? 'border-t border-gray-200 focus:border-none rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                                    wire:click="$set('addTeamMemberForm.role', '{{ $role->key }}')">
                        <div class="{{ isset($addTeamMemberForm['role']) && $addTeamMemberForm['role'] !== $role->key ? 'opacity-50' : '' }}">
                            <!-- Role Name -->
                            <div class="flex items-center">
                                <div class="text-sm text-gray-600 {{ $addTeamMemberForm['role'] == $role->key ? 'font-semibold' : '' }}">
                                    {{ $role->name }}
                                </div>

                                @if ($addTeamMemberForm['role'] == $role->key)
                                    <svg class="ml-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>

                            <!-- Role Default? -->
                            @if ($role->default == '1')
                                <div class="mt-2 text-xs text-red-600 text-left">
                                    {{ __('Default Role') }}
                                </div>
                            @endif
                            <!-- Role Description -->
                            <div class="mt-2 text-xs text-gray-600 text-left">
                                {{ $role->description }}
                            </div>
                        </div>
                    </button>
                @endforeach
            @endif
        </div>
    </div>
@endif
*/
