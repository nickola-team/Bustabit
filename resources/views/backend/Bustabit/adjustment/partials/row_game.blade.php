@foreach ($adjustment['cat'] as $cat)
	@if ($loop->index > 0)
	<tr>
	@endif
	
	@if(Request::get('cat') == '')
	<td>
		@if($cat['provider'] == 'major')
		<p class="text-sm font-weight-normal mb-0">GB슬롯</p>
		@elseif($cat['provider'] == 'self')
		<p class="text-sm font-weight-normal mb-0"></p>
		@endif
	</td>
	@endif

	<td >
		@if (!$total && auth()->user()->hasRole('admin') && Request::get('cat') == '')
		<a href="{{route('backend.adjustment_game', ['cat'=>$cat['category_id'], 'date' => $cat['date'], 'type'=>$cat['type'], 'provider'=>$cat['provider']] ) }}"> 
			<p class="text-sm font-weight-bold mb-0 {{$total ? 'text-danger' : ''}}">{{$cat['title'] }}</p>
		</a>
		@else
		<p class="text-sm font-weight-normal mb-0 {{$total ? 'text-danger' : ''}}">{{$cat['title'] }}</p>
		@endif
	</td>
	<td ><p class="text-sm font-weight-normal mb-0 {{$total ? 'text-danger' : ''}}">{{ number_format($cat['totalbet'],0) }} </p></td>
	<td ><p class="text-sm font-weight-normal mb-0 {{$total ? 'text-danger' : ''}}">{{ number_format($cat['totalwin'],0)}}</p></td>
	<td ><p class="text-sm font-weight-normal mb-0 {{$total ? 'text-danger' : ''}}">{{ number_format($cat['totalbet'] - $cat['totalwin'],0)}}</p></td>
	<td ><p class="text-sm font-weight-normal mb-0 {{$total ? 'text-danger' : ''}}">{{ number_format($cat['totalcount'])}}</p></td>
	<td ><p class="text-sm font-weight-normal mb-0 {{$total ? 'text-danger' : ''}}">{{ number_format($cat['total_deal'],0)}}</p></td>
	<td ><p class="text-sm font-weight-normal mb-0 {{$total ? 'text-danger' : ''}}">{{ number_format($cat['total_mileage'],0)}}</p></td>
	<td ><p class="text-sm font-weight-normal mb-0 {{$total ? 'text-danger' : ''}}">{{ number_format($cat['total_deal'] - $cat['total_mileage'],0)}}</p></td>

	@if ($loop->index > 0)
	</tr>
	@endif
@endforeach