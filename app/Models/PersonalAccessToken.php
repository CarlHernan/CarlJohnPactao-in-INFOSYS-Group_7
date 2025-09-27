<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    // This model extends Laravel Sanctum's PersonalAccessToken
    // No additional configuration needed as it uses the default implementation
}
