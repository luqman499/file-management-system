<?php

namespace App\Helpers;

use App\Models\Dispatch;
use Illuminate\Database\Eloquent\Collection;

class DispatchHelper
{
    /**
     * Get dispatches by status with optional limit and relationships
     *
     * @param string $statusType pending|accepted|rejected
     * @param int|null $limit
     * @param array $with Relationships to eager load
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getDispatches(string $statusType, ?int $limit = null, array $with = []): Collection
    {
        $query = Dispatch::query()->with($with);

        // Apply the appropriate scope based on statusType
        match ($statusType) {
            'pending' => $query->ofPending(),
            'accepted' => $query->ofAccepted(),
            'rejected' => $query->ofRejected(),
            default => $query, // No scope applied if statusType is invalid
        };

        if ($limit) {
            $query->take($limit);
        }

        return $query->get();
    }

    /**
     * Get all dispatches with optional relationships
     *
     * @param array $with Relationships to eager load
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAllDispatches(array $with = []): Collection
    {
        return Dispatch::with($with)->get();
    }
}
