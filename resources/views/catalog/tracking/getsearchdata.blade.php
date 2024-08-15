@foreach($tracking as $data)
    <tr>
        @if($data['delivery_status'] == "Delivered")
        <td> {{ date('M d, Y',strtotime($data['delivery_date'])) }}  </td>
        @elseif($data['delivery_status'] == "Order received by Flying High")
        <td> {{ date('M d, Y',strtotime($data['updated_at'])) }}  </td>
        @else
        <td> {{ date('M d, Y',strtotime($data['updated_at'])) }}  </td>
        @endif
        <!-- <td> {{ $data['order_number']}}  </td>
        <td> {{ $data['name']}}  </td>
        <td> {{ $data['address'] }} </td>
        <td> {{ $data['phone_number'] }} </td>
        <td> {{ $data['area'] }} </td>
        <td> {{ $data['actual_weight'] }} </td>
        <td> {{ $data['weight_cost'] }} </td>
        <td> {{ $data['cost'] }} </td>
        <td> {{ $data['declared_value'] }} </td> -->
        <td> {{ $data['delivery_status'] }} </td>
        <!-- <td> {{ $data['delivery_date'] }} </td>
        <td> {{ $data['aging'] }} </td>
        <td> {{ $data['username'] }} </td>
        <td> {{ $data['remarks'] }} </td> -->
    </tr>
@endforeach   

