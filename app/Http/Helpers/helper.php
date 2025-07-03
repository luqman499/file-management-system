<?php

function getDispatchStatus($status)
    {
        $statuses = [
            0 => 'Submitted',
            1 => 'Approved',
            2 => 'Rejected',
            3 => 'Returned',
            4 => 'Recommended',
        ];

    return $statuses[$status] ?? 'Unknown';
    }
