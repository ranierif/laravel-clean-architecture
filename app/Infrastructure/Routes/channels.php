<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.UserEntity.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
