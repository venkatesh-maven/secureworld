<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class serviceTickets extends Model
{
        use SoftDeletes;

    

    use HasFactory;
    protected $dates = ['deleted_at'];
    public $timestamps = true;
    protected $fillable = [
        'age',
        'item_category',
        'service_id',
        'sold_to_party',	
        'mobile',
        'order_type',
        'created_on',
        'user_status',
        'category',
        'product',
        'technician',
        'site_code',
        'call_bifurcation',
        'part_Required',
        'changed_on',
        'call_completion_date',
        'serial_no',
        'brand',
        'sales_office',
        'confirmation_no',
        'transaction_type',
        'status',
        'availability',
        'higher_level_item',
        'sla',
        'billing',
        'bill_to_party',
        'pr_number',
        'invoice_number',
        'sto_number',
        'so_number',
        'article_code',
        'address',
        'service_characteristi',
        'product_source',
        'state',
        'city',
        'warranty',
        'deferment_date',
        'field_category',
        'tTechnician',
        'feedback',
        'manager',
        'comments',
        'purchase_order',
        'invoice',
        'pod',
        'grn',
        'part_required',
        'attachments'
    ];
    
    public function histories()
{
    return $this->hasMany(\App\Models\ServiceTicketHistory::class, 'service_ticket_id')->latest();
}

public function technician()
{
    return $this->belongsTo(User::class, 'technician', 'id');
}


}
