<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    protected $table = 'collected_tickets';
    protected $primaryKey = 'ticket_id';
    // protected $dateFormat = 'U';
    // public const CREATED_AT = 'created_date';
    // public const UPDATED_AT = 'updated_date';
}
