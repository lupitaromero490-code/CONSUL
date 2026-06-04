<?php

namespace App\Notifications;

use App\Models\Cita;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecordatorioCita extends Notification
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
            ->subject('🔔 Recordatorio de cita mañana - CONSUL')
            ->greeting('Hola, ' . $notifiable->name . '!')
            ->line('Te recordamos que tienes una cita médica **mañana**.')
            ->line('**Doctor:** ' . $this->cita->doctor->user->name)
            ->line('**Especialidad:** ' . $this->cita->doctor->especialidad->nombre)
            ->line('**Fecha:** ' . \Carbon\Carbon::parse($this->cita->fecha)->format('d/m/Y'))
            ->line('**Hora:** ' . $this->cita->hora_inicio . ' - ' . $this->cita->hora_fin)
            ->line('**Motivo:** ' . ($this->cita->motivo ?? 'No especificado'))
            ->action('Ver mis citas', url('/citas'))
            ->line('⚠️ Si necesitas cancelar tu cita, hazlo con anticipación.')
            ->line('Por favor llega 10 minutos antes de tu cita.')
            ->salutation('Atentamente, el equipo de CONSUL 🏥');
    }
}