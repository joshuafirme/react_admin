<?php

namespace App\Imports;

use App\User;
use App\Tracking;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Carbon\Carbon;
class TrackingImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return Tracking|null
     */
    public function model(array $row)
    {
        return new Tracking([
           'date'     =>    Carbon::parse(($row[1] - 25569) * 86400)->format('Y-m-d'),
           'order_number'    => $row[3], 
           'name' => $row[4],
           'address' => @$row[5],
           'phone_number' => @$row[6],
           'area' => @$row[7],
           'actual_weight' => @$row[8],
           'weight_cost' => @$row[9],
           'cost' => @$row[10],
           'declared_value' => @$row[11],
           'delivery_status' => "In Transit",
           'aging' => @$row[14],
           'remarks' => @$row[15],
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}