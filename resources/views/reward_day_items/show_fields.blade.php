<!-- Quantity Field -->
<div class="form-group">
    {!! Form::label('quantity', 'Quantity:') !!}
    <p>{{ $rewardDayItem->quantity }}</p>
</div>

<!-- Bag Item Type Id Field -->
<div class="form-group">
    {!! Form::label('bag_item_type_id', 'Bag Item Type Id:') !!}
    <p>{{ $rewardDayItem->bag_item_type_id }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $rewardDayItem->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $rewardDayItem->updated_at }}</p>
</div>

