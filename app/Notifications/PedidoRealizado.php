<?php

namespace App\Notifications;

use App\Models\Pedido;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PedidoRealizado extends Notification {
    /**
     * @var Pedido
     */
    public $pedido;

    /**
     * Create a new notification instance.
     *
     * @param Pedido $pedido
     */
    public function __construct( Pedido $pedido ) {
        $this->pedido = $pedido;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via( $notifiable ) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return MailMessage
     */
    public function toMail( $notifiable ) : MailMessage {
        return (new MailMessage)
            ->success()
            ->subject('Aqui está o seu pedido!')
            ->line("Olá {$this->pedido->cliente->nome}! Recebemos o seu pedido.")
            ->line('Confira abaixo os dados do seu pedido')
            ->line(view('pedidos.email', ['pedido' => $this->pedido]));
    }
}
