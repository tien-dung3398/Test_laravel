<?php

return [
    'name' => 'User',
    /**
     * Always use lower name without custom characters, spaces, etc
     */
    'permissions' => [
        'user.browse',
        'user.create',
        'user.update',
        'user.destroy'
    ]
];