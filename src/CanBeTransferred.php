<?php

namespace Custura\Trane;

use Custura\Trane\Trane;

trait CanBeTransferred
{
    /**
     * Transfers the teams ownership to the given user.
     *
     * @param  \App\Models\User  $from
     * @param  \App\Models\User  $to
     */
    public function transfer($from, $to)
    {
        $this->users()->detach($to);

        if (! is_null(Trane::findRole('admin'))) {
            $this->users()->attach(
                $from, ['role' => 'admin']
            );
        }

        $this->owner()->associate($to);

        $this->save();
    }
}
