@foreach($tracking as $data)
    <tr class="tr_{{ $data['id']}}">
    <script>
    var thisid = "{{ $data['id']}}"
    var n = checkedArray.includes(thisid);
    if(n){
        $("#data_id_{{ $data['id']}}").prop('checked', true);
        if($(".tr_{{ $data['id']}}").length == 0){
            $(".tr_{{ $data['id']}}").prependTo('.data_loaded');
        }
        
    }
    </script>
        <td> <input id="data_id_{{ $data['id']}}" class="data_id" type="checkbox" value="{{ $data['id']}}" name="id[]">  </td>
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
        @if(isAdmin() || isSuperAdmin())
        <td><a href="/catalog/tracking/edit/{{$data['id']}}" class="btn btn-primary"><i class="fa fa-pen"></i></a> </td>
        @endif
    </tr>
@endforeach   
<tr>
<td style="background:#f4f6f9;" colspan="3" align="center">
{{ $tracking->links() }} 
</td>
</tr>
