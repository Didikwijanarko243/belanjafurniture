<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Consultation extends Model
{
    protected $fillable = [
        'session_id', 'status', 'whatsapp_message', 'admin_notes',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(ConsultationItem::class);
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }
}
