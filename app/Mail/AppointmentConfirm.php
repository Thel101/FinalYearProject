<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use App\Models\DoctorAppointment;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppointmentConfirm extends Mailable
{
    use Queueable, SerializesModels;

    public $doctorAppointment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(DoctorAppointment $doctorAppointment)
    {
        $this->doctorAppointment = $doctorAppointment;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from : new Address('polyclinicteam@gmail.com', 'Poly Clinic Team'),
            subject: 'Appointment Confirm'
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'email.appointmentConfirm',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
