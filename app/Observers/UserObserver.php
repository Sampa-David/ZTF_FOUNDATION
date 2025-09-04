<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $user->registered_at = $user->created_at;
        $user->saveQuietly();
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Ne pas mettre à jour info_updated_at pour les champs de suivi d'activité
        $excludedFields = [
            'last_activity_at',
            'last_login_at',
            'is_online',
            'last_seen_at',
            'remember_token',
            'updated_at'
        ];

        $changed = array_diff_key($user->getChanges(), array_flip($excludedFields));
        
        if (!empty($changed)) {
            $user->info_updated_at = now();
            $user->saveQuietly();
        }
    }
}
