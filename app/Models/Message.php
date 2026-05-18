<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'inquiry_id',
        'user_id',
        'message',
        'attachment_path',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods

    public function isRead()
    {
        return $this->read_at !== null;
    }

    public function markAsRead()
    {
        if (!$this->isRead()) {
            $this->update(['read_at' => now()]);
        }
    }
}

