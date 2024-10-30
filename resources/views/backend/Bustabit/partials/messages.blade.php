<div class="position-fixed top-3 end-1 z-index-2">
@if(!(isset ($errors) && count($errors) > 0) && !Session::get('success', false) && Auth::check())
    @php
        $path = str_replace('console/', '', Request::path());
        $path = str_replace('console', '', $path);
        $path = preg_replace('/[0-9]+/', '*', $path);

        $infos = [];
        $allInfos = \VanguardLTE\Info::where('link', $path)->get();
        if( count($allInfos) ){
            foreach($allInfos AS $infoItem){
                if($infoItem->user){
                    if($infoItem->user->hasRole('admin')){
                        $infos[] = $infoItem;
                    }
                    if($infoItem->user->hasRole('agent')){
                        if( in_array(auth()->user()->id, $infoItem->user->availableUsers()) ){
                            $infos[] = $infoItem;
                        }
                    }
                }
            }
        }
        if( count($infos) > 1 ){
            $infos = [$infos[rand(1, count($infos))-1]];
        }
    @endphp
    @if($infos)
        @foreach($infos as $info)
            @if($info->roles == '' || auth()->user()->hasRole(strtolower($info->roles)))
                <div class="alert alert-info alert-dismissible text-white" role="alert">
                    <span class="text-sm">{!! $info->text !!}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
        @endforeach
    @endif
@endif

@if (session('blockError'))
    <div class="alert alert-danger alert-dismissible text-white" role="alert">
        <span class="text-sm">Errors in block {{ strtoupper(session('blockError')) }}</span>
        <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endif

@if(isset ($messages) && count($messages) > 0)
    <div class="alert alert-info alert-dismissible text-white" role="alert">
        @foreach($messages->all() as $message)
            <span class="text-sm">{{ $message }}</span>
        @endforeach
        <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endif


@if(isset ($errors) && count($errors) > 0)
    <div class="alert alert-danger alert-dismissible text-white" role="alert">
        @foreach($errors->all() as $error)
            <span class="text-sm">{{ $error }}</span>
        @endforeach
        <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endif



@if(settings('siteisclosed'))
    <div class="alert alert-danger alert-dismissible text-white" role="alert">
        <span class="text-sm">@lang('app.site_is_turned_off')</span>
        <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endif



@if(Session::get('success', false))
    <?php $data = Session::get('success'); ?>
    @if (is_array($data))
        @foreach ($data as $msg)
            <div class="alert alert-success alert-dismissible text-white" role="alert">
                <span class="text-sm">{{ $msg }}</span>
                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endforeach
    @else
        <div class="alert alert-success alert-dismissible text-white" role="alert">
            <span class="text-sm">{{ $data }}</span>
            <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
@endif
</div>