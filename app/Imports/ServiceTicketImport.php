<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\serviceTickets;
use App\Models\CategoryMapping;
use Maatwebsite\Excel\Concerns\ToModel;

class ServiceTicketImport implements ToModel
{
    protected $mode;
    public $duplicates = [];

    public function __construct($mode)
    {
        // Normalize mode (so “edit” behaves like “update”)
        $this->mode = $mode;
    }

    public function model(array $row)
    {
        /** ------------------------------
         * 1️⃣ INSERT MODE (Service Monitor Import)
         * ------------------------------ */
        if (in_array($this->mode, ['insert', 'edit'])) {

            // Skip header row
            if ($row[1] === 'Item Category' || empty($row[2])) {
                return null;
            }

            $serviceId = trim($row[2]);
            $existing = serviceTickets::where('service_id', $serviceId)->first();

            // Calculate created_on difference (if needed)
            $dateString = $row[6] ?? null;
            $today = Carbon::today();
            $givenDate = !empty($dateString) ? Carbon::createFromFormat('d.m.Y', $dateString) : null;
            $daysDifference = $givenDate ? $givenDate->diffInDays($today) : null;

            $product = trim($row[8]);
            $fieldCategory = CategoryMapping::where('product_category', $product)->value('field_category');

            // If no record → create new
            if (!$existing) {
                return serviceTickets::create([
                    'item_category'        => $row[1],
                    'service_id'           => $serviceId,
                    'sold_to_party'        => $row[3],
                    'mobile'               => $row[4],
                    'order_type'           => $row[5],
                    'created_on'           => !empty($row[6]) ? Carbon::createFromFormat('d.m.Y', $row[6])->format('Y-m-d') : null,
                    'user_status'          => $row[7],
                    'category'             => $row[8],
                    'product'              => $row[9],
                    'technician'           => $row[10],
                    'site_code'            => $row[11],
                    'call_bifurcation'     => $row[12],
                    'part_Required'        => $row[13],
'changed_on' => !empty(trim($row[14]))
    ? Carbon::createFromFormat('d.m.Y', trim($row[14]))->format('Y-m-d')
    : null,

'call_completion_date' => !empty(trim($row[15])) && preg_match('/\d{2}\.\d{2}\.\d{4}/', $row[15])
    ? Carbon::createFromFormat('d.m.Y', trim($row[15]))->format('Y-m-d')
    : null,
                    'serial_no'            => $row[16],
                    'brand'                => $row[17],
                    'sales_office'         => $row[18],
                    'confirmation_no'      => $row[19],
                    'transaction_type'     => $row[20],
                    'availability'         => $row[22],
                    'higher_level_item'    => $row[23],
                    'sla'                  => $row[24],
                    'billing'              => $row[25],
                    'bill_to_party'        => $row[26],
                    'pr_number'            => $row[27],
                    'invoice_number'       => $row[28],
                    'sto_number'           => $row[29],
                    'so_number'            => $row[30],
                    'article_code'         => $row[31],
                    'address'              => $row[32],
                    'service_characteristi'=> $row[33],
                    'product_source'       => $row[34],
                    'state'                => $row[35],
                    'city'                 => $row[36],
                    'field_category'       => $fieldCategory,
                ]);
            }

            // If record exists → update selective fields for open tickets only
            if (!in_array(trim($existing->user_status), ['DOA Confirmed', 'Cancel', 'Completed', 'Repaired By Vendor'])) {
                $existing->update([
                    'user_status' => $row[7],
                    'site_code'   => $row[11],
                    'sla'         => $row[24],
                    'changed_on'  => !empty($row[14]) ? Carbon::createFromFormat('d.m.Y', $row[14])->format('Y-m-d') : null,
                ]);

                logger("Updated open ticket {$serviceId} | New Status: {$row[7]}");
            } else {
                logger("Skipped closed ticket {$serviceId} | Status: {$existing->user_status}");
            }

            return null;
        }

        /** ------------------------------
         * 2️⃣ UPDATE MODE (Service Order Import)
         * ------------------------------ */
        if ($this->mode === 'update') {

            // Skip header
            if ($row[0] === 'Service Order ID' || empty($row[0])) {
                return null;
            }

            $serviceTicket = serviceTickets::where('service_id', trim($row[0]))->first();

            if ($serviceTicket) {
                $serviceTicket->update([
                    'sold_to_party' => $row[1],
                    'order_type'    => $row[5],
                ]);

                logger("Updated Service Order: {$row[0]} | SoldTo: {$row[1]} | OrderType: {$row[5]}");
            } else {
                logger("Service Order not found: {$row[0]}");
            }

            return null;
        }
    }
}
