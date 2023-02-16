<?php

namespace App\Traits;

use App\Models\Team;
use App\Models\TeamContact;

trait CreateTeamContact {

    public function verifyAndCreateTeamContact($team_id,  $handle, $website) {
        
        // Check if a team exists with this value
        if (Team::find($team_id) == null) return null;

        return TeamContact::create(['team_id' => $team_id,
        'handle' => $handle, 
        'website' => $website]);
    }
}


