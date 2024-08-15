<?php
  
namespace App\Exports;
  
use App\User;
use App\Tracking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
  
class TrackingPerRiderExport implements FromCollection, WithHeadings
{
    protected $user_id;
    protected $date_from;
    protected $date_to;

    public function __construct($user_id,$date_from,$date_to)
    {
        $this->user_id = $user_id;
        $this->date_from = $date_from;
        $this->date_to = $date_to;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $output = array();
        if($this->user_id){
            $trackings = Tracking::whereIn('delivery_status',['In Transit'])->where('user_id',$this->user_id)->get();
        }else if(!empty($this->date_to) && !empty($this->date_from)){
            $trackings = Tracking::whereIn('delivery_status',['In Transit'])->whereBetween('date',[$this->date_from,$this->date_to])->where('user_id',$this->user_id)->get();
        }else{
            $trackings = Tracking::whereIn('delivery_status',['In Transit'])->where('user_id',$this->user_id)->get();
        }
        
        $count=1;
        foreach ($trackings as $tracking)
        {
            $user = User::find($tracking->user_id);
            
          $output[] = [
            $count,
            $tracking->date,
            '-',
            $tracking->order_number,
            $tracking->name,
            $tracking->address,
            $tracking->phone,
            $tracking->area,
            $tracking->remarks,
            $user->username,
            $tracking->updated_at,
          ];

          $count++;
        }
        return collect($output);
    }

    public function headings(): array
    {
        return [
            '-',
            'Date',
            'TRACKING',
            'Order Number',
            'Name',
            'ADDRESS',
            'PHONE',
            'AREA',
            'Remarks',
            'Rider',
            'Updated At'
        ];
    }
}