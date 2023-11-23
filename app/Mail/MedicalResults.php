<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\ServiceMedicalRecords;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use League\OAuth1\Client\Server\Server;
use Illuminate\Contracts\Queue\ShouldQueue;

class MedicalResults extends Mailable
{
    use Queueable, SerializesModels;

    public $record;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ServiceMedicalRecords $record)
    {
        $this->record = $record;
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
            subject: 'Medical Results'
        );
    }

    public function build()
    {

        $pdfPath = "public/".$this->record->result_file;
        // dd($pdfPath);
        if(Storage::exists($pdfPath)) {
            $pdfContents = Storage::get($pdfPath);

        // Get the file name from the path
        $fileName = basename($pdfPath);

        $recipientEmail = Session::get('email');
        $name = Session::get('name');
        $date = Session::get('date');
        // dd($name);

        return $this->from('polyclinicteam@gmail.com', 'Poly Clinic Team')
            ->subject('Medical Results')
            ->view('emails.medicalResult',compact('name', 'date'))
            ->attachData($pdfContents, $fileName, [
                'mime' => 'application/pdf',
            ])
            ->to($recipientEmail);
        }
        else{
            dd('error');
        }
        // Get the contents of the PDF file

    }
}
