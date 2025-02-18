<?php
// app/Models/Membership.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'membership_id', 'membership_status', 'paymentstatus', 'transaction_id', 'amount', 'type', 'membership_user_type'
    ];
}
