<?php

namespace App\Exports;

use App\LogDetails;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class LogDetailsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    // protected $id;
    // protected $from;
    // protected $to;

    // function __construct($id,$from,$to) {
    //         $this->id = $id;
    //         $this->from = $from;
    //         $this->to = $to;
    // }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // if(!empty($this->from) && !empty($this->to)){

        //     // $logdetails = LogDetails::where(function($query) use($keywords){
        //     //     $query->orWhereBetween("created_at", [$this->from, $this->to]);
        //     // })->get();    

        //     return LogDetails::where(function($query) use($keywords){
        //         $query->orWhereBetween("created_at", [$this->from, $this->to]);
        //     })->get()([
        //         'user_id', 'qty_assigned'
        //     ]);
        // }else{
            return LogDetails::all();
        // }
        
    }

    public function headings(): array
    {
        return [
        	'#',
            'Log ID',
            'User ID',
            'Drop Off Point',
            'X Coordinate',
            'Y Coordinate',
            'Transaction Type',
            'Qty Dropped',
            'Qty Remainings',
            'Qty Remarks',
            'Image Link',
            'Status',
            'Created At',
            'Updated At',


        ];
    }
}
