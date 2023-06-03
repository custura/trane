<?php

use Custura\Trane\Features;

return [
    'stack' => 'livewire',
    'middleware' => ['web'],
    'features' => [Features::accountDeletion()],
    'profile_photo_disk' => 'public',
];
