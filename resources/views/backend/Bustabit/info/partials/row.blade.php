<tr>        
    <td><a href="{{ route('backend.info.edit', $info_item->id) }}">/console/{{ $info_item->link }}</a></td>
    <td>{{ $info_item->title }}</td>
    <td>{{ str_replace('|', ', ', $info_item->roles) }}</td>
    <td>{{ $info_item->shops_info() }}</td>
</tr>