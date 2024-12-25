<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;

class LoadCartAfterLogin
{
    public $user;

    /**
     * Create the event listener.
     * @param UserLoggedIn $event
     * @return void
     */


    /**
     * Handle the event.
     */
    public function handle(UserLoggedIn $event): void
    {
        // Ambil user yang login
        $user = $event->user;

        // Ambil data dari pivot table berdasarkan user_id
        $cartItems = $user->products()->get(['product_id', 'quantity'])->toArray();

        // Simpan data cart ke session
        Session::put('cart', $cartItems);
    }
}
