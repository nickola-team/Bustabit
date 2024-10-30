<tr>        
    <td><p class="text-sm font-weight-normal mb-0">{{$notice->title}}</p></td>
	<td><p class="text-sm font-weight-normal mb-0">{{ $notice->date_time }}</p></td>
    <td>
        <p class="text-sm font-weight-normal mb-0">{{\VanguardLTE\Notice::lists()[$notice->type]}}</p>
    </td>
    @if (auth()->user()->hasRole('admin'))
    <td><p class="text-sm font-weight-normal mb-0">{{$notice->writer?$notice->writer->username:'알수없음'}}</p></td>
    @endif
    <td><span class="badge badge-sm {{ $notice->active==1?'bg-success':'bg-secondary' }}" title="{{ $notice->active==1?'활성':'비활성' }}"> </span></td>
    <td>
        <a href="{{ route('backend.notice.edit', $notice->id) }}">
            <button class="btn bg-gradient-success btn-sm mb-0">편집</button>
        </a>
    </td>
</tr>