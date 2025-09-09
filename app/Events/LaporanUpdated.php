<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Laporan;

class LaporanUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $laporan;

    /**
     * Create a new event instance.
     */
    public function __construct(Laporan $laporan)
    {
        $this->laporan = $laporan;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn()
    {
        // Send to the user who owns the laporan
        return new PrivateChannel('user.' . $this->laporan->user_id);
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->laporan->id,
            'user_id' => $this->laporan->user_id,
            'user_name' => $this->laporan->user ? $this->laporan->user->name : '',
            'surat_id' => $this->laporan->surat_id,
            'surat_name' => $this->laporan->suratRelasi ? $this->laporan->suratRelasi->nama : '',
            'ayat_halaman' => $this->laporan->ayat_halaman,
            'tanggal' => $this->laporan->tanggal,
            'keterangan' => $this->laporan->keterangan,
        ];
    }
}
