<?php

namespace App\Services;

// use Illuminate\Contracts\Cache\Factory as Cache;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Cache;
use App\Contracts\CounterContract;

Class Counter implements CounterContract
{
   private $timeout;
   private $cache;
   private $session;
   private $supportsTags;

//    public function __construct(Cache $cache,Session $session,int $timeout)
//    {
//        $this->cache = $cache;
//        $this->session = $session;
//        $this->timeout = $timeout;
//        $this->supportsTags = method_exist($cache,'tags');
//    }

   public function increment(string $key, array $tags =null):int
   {
        $sessionId = session()->getId();
        $counterKey = "{$key}-counter";
        $usersKey = "{$key}-users";
        $users = Cache::get($usersKey,[]);
        $usersUpdate = [];
        $difference = 0;
        $now = now();

        foreach($users as $session => $lastVisit){
            
            if($now->diffInMinutes($lastVisit) >= $this->timeout){
                $difference--; 
            }else{
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if(!array_key_exists($sessionId, $users) || $now->diffInMinutes($users[$sessionId])){
            $difference++;
        }

        $usersUpdate[$sessionId] = $now;

        Cache::forever($usersKey,$usersUpdate);

        if(!Cache::has($counterKey)){
            Cache::forever($counterKey,1);
        }else{
            Cache::increment($counterKey,$difference);
        }
        
        $counter = Cache::get($counterKey);

        return $counter;
   }
}