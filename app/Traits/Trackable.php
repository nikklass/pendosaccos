<?php

namespace App\Traits;

use Auth;

trait Trackable
{
    public static function bootTrackable()
    {
        static::creating(function ($model) {
            //$model->created_by = Auth::user()->id ?? 0;
        });

        static::updating(function ($model) {
            // bleh bleh
        });

        static::deleting(function ($model) {
            // bluh bluh
        });
    }
}