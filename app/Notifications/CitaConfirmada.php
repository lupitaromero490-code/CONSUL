<?php

namespace App\Notifications;

use App\Models\Cita;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CitaConfirmada extends Notification
{
    use Queueable;

    public function __construct(public Cita $cita) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('✅ Tu cita ha sido confirmada - CONSUL')
            ->greeting('Hola, ' . $notifiable->name . '!')
            ->line('Tu cita médica ha sido **confirmada** exitosamente.')
            ->line('**Doctor:** ' . $this->cita->doctor->user->name)
            ->line('**Especialidad:** ' . $this->cita->doctor->especialidad->nombre)
            ->line('**Fecha:** ' . \Carbon\Carbon::parse($this->cita->fecha)->format('d/m/Y'))
            ->line('**Hora:** ' . $this->cita->hora_inicio . ' - ' . $this->cita->hora_fin)
            ->line('**Motivo:** ' . ($this->cita->motivo ?? 'No especificado'))
            ->action('Ver mis citas', url('/citas'))
            ->line('Por favor llega 10 minutos antes de tu cita.')
            ->salutation('Atentamente, el equipo de CONSUL 🏥');
    }
}