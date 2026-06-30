<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

class GoogleCalendarService
{
    protected Calendar $service;
    protected string $calendarId;

    public function __construct()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/google-credentials.json')); // Service Account JSON
        $client->addScope(Calendar::CALENDAR);

        $this->service = new Calendar($client);
        $this->calendarId = config('services.google.calendar_id');
    }

    public function criarEvento(array $dados): Event
    {
        $isProfunda = $dados['service'] === 'profunda' || str_contains(strtolower($dados['service']), 'profunda');

        if ($isProfunda) {
            // Evento de dia inteiro
            $event = new Event([
                'summary' => "Limpeza Profunda — {$dados['name']}",
                'description' => "Cliente: {$dados['name']}\nTel: {$dados['phone']}\nEmail: {$dados['email']}\nNotas: {$dados['notes']}",
                'start' => ['date' => $dados['booking_date']],
                'end'   => ['date' => $dados['booking_date']],
            ]);
        } else {
            // Evento com hora (1h de duração)
            $startDT = "{$dados['booking_date']}T{$dados['booking_time']}:00";
            $endHour = sprintf('%02:00', ((int) explode(':', $dados['booking_time'])[0]) + 1);
            $endDT   = "{$dados['booking_date']}T{$endHour}:00";

            $event = new Event([
                'summary' => "Limpeza — {$dados['name']}",
                'description' => "Cliente: {$dados['name']}\nTel: {$dados['phone']}\nEmail: {$dados['email']}\nServiço: {$dados['service']}\nNotas: {$dados['notes']}",
                'start' => ['dateTime' => $startDT, 'timeZone' => 'Europe/Lisbon'],
                'end'   => ['dateTime' => $endDT,   'timeZone' => 'Europe/Lisbon'],
            ]);
        }

        return $this->service->events->insert($this->calendarId, $event);
    }
}
