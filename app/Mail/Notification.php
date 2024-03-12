<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Notification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $nama_pemohon;

    protected $jumlah;

    protected $cabang;

    protected $catatan;

    protected $nama_barang;

    // protected $deadline;
    public function __construct($nama_pemohon, $cabang, $jumlah, $catatan, $nama_barang )
    {
        $this->nama_pemohon = $nama_pemohon;
        $this->jumlah = number_format(floatval($jumlah));
        $this->cabang = $cabang;
        $this->catatan = $catatan;
        $this-> nama_barang =  $nama_barang ;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Pengajuan barang')
            ->from('noreplyinvoluntir@gmail.com', 'J&T')
            ->view('emails.pengajuanbarang')
            ->with([
                'nama_pemohon' => $this->nama_pemohon,
                'cabang' => $this->cabang,
                'jumlah' => number_format(floatval($this->jumlah)),
                'catatan' => $this->catatan,
                'barang' => $this->nama_barang,
               
            ]);
    }
}