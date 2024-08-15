@foreach($tracking as $data)
    <tr>
        <td> {{ $data['date']}}  </td>
        <td> {{ $data['order_number']}}  </td>
        <td> {{ $data['name']}}  </td>
        <td> {{ $data['address'] }} </td>
        <td> {{ $data['phone_number'] }} </td>
        <td> {{ $data['area'] }} </td>
        <td> {{ $data['actual_weight'] }} </td>
        <td> {{ $data['weight_cost'] }} </td>
        <td> {{ $data['cost'] }} </td>
        <td> {{ $data['declared_value'] }} </td>
        <td> {{ $data['delivery_status'] }} </td>
        <td> {{ $data['aging'] }} </td>
        <td> {{ $data['username'] }} </td>
        <td> {{ $data['remarks'] }} </td>
    </tr>
@endforeach   
<tr>
<td style="background:#f4f6f9;" colspan="3" align="center">
{{ $tracking->links() }} 
</td>
</tr>
