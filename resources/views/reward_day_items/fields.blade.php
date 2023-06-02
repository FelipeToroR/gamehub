<!-- Quantity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity', 'Quantity:') !!}
    {!! Form::text('quantity', null, ['class' => 'form-control']) !!}
</div>

<!-- Bag Item Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bag_item_type_id', 'Bag Item Type Id:') !!}
    {!! Form::select('bag_item_type_id', $bag_item_typeItems, null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('rewards.days.items.index', [$reward->id, $rewardDay->id]) }}" class="btn btn-default">Cancel</a>
</div>
