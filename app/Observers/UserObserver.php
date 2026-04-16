<?php

namespace App\Observers;

use App\Models\User;
use App\Services\UserRoleProfileSyncService;

class UserObserver
{
    public function __construct(
        private readonly UserRoleProfileSyncService $roleProfileSyncService
    ) {
    }

    public function created(User $user): void
    {
        $this->roleProfileSyncService->sync($user->loadMissing(['patient', 'nurse', 'doctor', 'barangayAdmin']));
    }

    public function updated(User $user): void
    {
        if (! $user->wasChanged('role')) {
            return;
        }

        $this->roleProfileSyncService->sync($user->fresh(['patient', 'nurse', 'doctor', 'barangayAdmin']));
    }
}
