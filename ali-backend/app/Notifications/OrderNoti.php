<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderNoti extends Notification
{
    use Queueable;

    public $shopuser;

    public $order;

    public $act;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($shopuser, $order, $act)
    {
        $this->shopuser = $shopuser;
        $this->order = $order;
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
            'order' => $this->order,
            'act'  => $this->act,
        ];
    }
}
