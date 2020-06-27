<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProductNoti extends Notification
{
    use Queueable;

    public $shopuser;

    public $product;

    public $act;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($shopuser, $product, $act)
    {
        $this->shopuser = $shopuser;
        $this->product = $product;
        $this->act = $act;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'shopuser' => $this->shopuser,
            'product' => $this->product,
            'act'  => $this->act,
        ];
    }
}
