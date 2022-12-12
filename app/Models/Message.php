<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'status',
        'sender_id',
        'retriever_id',
        'del_sender',
        'del_retriever',
        'read_sender',
        'read_retriever'
    ];

    public function getUserS()
    {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }
    public function getUserR()
    {
        return $this->hasOne(User::class, 'id', 'retriever_id');
    }
}
