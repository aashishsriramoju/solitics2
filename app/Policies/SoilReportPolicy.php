<?php

namespace App\Policies;

use App\Models\SoilReport;
use App\Models\User;

class SoilReportPolicy
{
    public function view(User $user, SoilReport $soilReport): bool
    {
        return $user->id === $soilReport->user_id;
    }

    public function delete(User $user, SoilReport $soilReport): bool
    {
        return $user->id === $soilReport->user_id;
    }
}
