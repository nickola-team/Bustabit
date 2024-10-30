<div class="row mt-3">
    <div class="col-md-6">
        <div class="input-group input-group-static">
            <label>@lang('app.title')</label>
            <input type="text" class="form-control" id="title" name="name" placeholder="@lang('app.title')" required value="{{ $edit ? $shop->name : old('name') }}">
        </div>
    </div>

    @if($edit && count($blocks))
    <div class="col-md-6">
        <div class="input-group input-group-static">
            <label for="device">
                @lang('app.status')
            </label>
            {!! Form::select('is_blocked', $blocks, $edit ? $shop->is_blocked : old('is_blocked'), ['class' => 'form-control']) !!}
        </div>
    </div>
    @endif
</div>
<div class="row mt-3">
    <div class="col-md-4">
        <div class="input-group input-group-static">
        <label>롤링%</label>
        <input type="number"  step="0.01" class="form-control" id="deal_percent" name="deal_percent" value="{{ $edit ? $shop->deal_percent : '0' }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group input-group-static">
        <label>라이브롤링%</label>
        <input type="number"  step="0.01" class="form-control" id="table_deal_percent" name="table_deal_percent" value="{{ $edit ? $shop->table_deal_percent : '0' }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group input-group-static">
        <label>벳윈%</label>
        <input type="number"  step="0.01" class="form-control" id="ggr_percent" name="ggr_percent" value="{{ $edit ? $shop->ggr_percent : '0' }}">
        </div>
    </div>    
</div>

<div class="row mt-3 mb-5">
    @if(auth()->user()->hasRole('admin'))
    <div class="col-md-3 col-xs-6">
        <div class="input-group input-group-static">
            <label>@lang('app.percent')%</label>
            @php
                $percents = array_combine(\VanguardLTE\Shop::$values['percent'], \VanguardLTE\Shop::$values['percent']);
            @endphp
            {!! Form::select('percent', $percents, ($edit ? $shop->percent : old('percent')) ?:'90', ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6 col-xs-6">
        <label>GB게임사 금지</label>
        <select class="form-control selectpicker" name="banned_categories[]" id="banned_categories" multiple="multiple" style="width: 100%">
            <option value="pragmatic_slot" {{ in_array("pragmatic_slot", $banned_categories) ? 'selected="selected"' : '' }}>프라그마틱 슬롯</option>
            <option value="booongo_slot" {{ in_array("booongo_slot", $banned_categories) ? 'selected="selected"' : '' }}>부운고 슬롯</option>
            <option value="cq9_slot" {{ in_array("cq9_slot", $banned_categories) ? 'selected="selected"' : '' }}>씨큐 슬롯</option>
        </select>
    </div>
    @endif
</div>

    <div class="col-md-6"  style="display: none;">
        <div class="input-group input-group-static">
            <label> @lang('app.frontend')</label>
            {!! Form::select('frontend', $directories, ($edit ? $shop->frontend : old('frontend'))?:'Default', ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="col-md-6"  style="display: none;">
        <div class="input-group input-group-static">
            <label> @lang('app.order')</label>
            @php
                $orders = array_combine(\VanguardLTE\Shop::$values['orderby'], \VanguardLTE\Shop::$values['orderby']);
            @endphp
            {!! Form::select('orderby', $orders, $edit ? $shop->orderby : old('orderby'), ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="col-md-6"  style="display: none;">
        <div class="input-group input-group-static">
            <label> @lang('app.currency')</label>
            @php
                $currencies = array_combine(\VanguardLTE\Shop::$values['currency'], \VanguardLTE\Shop::$values['currency']);
            @endphp
            {!! Form::select('currency', $currencies, ($edit ? $shop->currency : old('currency'))?:'KRW', ['class' => 'form-control']) !!}
        </div>
    </div>