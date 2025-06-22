<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class CustomVerifyProfile extends Notification implements ShouldQueue
{
    use Queueable;

    protected $pendingData;

    public function __construct($pendingData)
    {
        $this->pendingData = $pendingData; 
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        // Menentukan pesan berdasarkan field yang diubah
        $fields = [];
        if (isset($this->pendingData['email'])) {
            $fields[] = 'email';
        }
        if (isset($this->pendingData['nomor_telepon'])) {
            $fields[] = 'nomor telepon';
        }
        $fieldText = count($fields) > 1 ? implode(' dan ', $fields) : $fields[0] ?? 'profil';

        return (new MailMessage)
            ->subject('Verifikasi Perubahan Profil')
            ->line("Klik tombol di bawah ini untuk memverifikasi {$fieldText} Anda.")
            ->action('Verifikasi Profil', $verificationUrl)
            ->line('Jika Anda tidak meminta perubahan ini, abaikan email ini.');
    }

    protected function verificationUrl($notifiable)
    {
        // Buat hash gabungan dari email dan/atau nomor telepon
        $hashInput = '';
        if (isset($this->pendingData['email'])) {
            $hashInput .= $this->pendingData['email'];
        }
        if (isset($this->pendingData['nomor_telepon'])) {
            $hashInput .= $this->pendingData['nomor_telepon'];
        }

        // Jika tidak ada email atau nomor telepon, gunakan ID pengguna untuk keamanan
        $hashInput = $hashInput ?: $notifiable->getKey();

        return URL::temporarySignedRoute(
            'verification.verify.profile',
            Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($hashInput),
            ]
        );
    }
}
