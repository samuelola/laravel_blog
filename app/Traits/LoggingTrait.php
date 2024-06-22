<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait LoggingTrait{

    public function report($info){
        Log::info($info);
    }
}