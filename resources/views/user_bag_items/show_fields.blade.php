<!-- Quantity Field -->
<div class="form-group">
    {!! Form::label('quantity', 'Quantity:') !!}
    <p>{{ $userBagItem->quantity }}</p>
</div>

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $userBagItem->user_id }}</p>
</div>

<!-- Game Instance Id Field -->
<div class="form-group">
    {!! Form::label('game_instance_id', 'Game Instance Id:') !!}
    <p>{{ $userBagItem->game_instance_id }}</p>
</div>

<!-- Bag Item Type Id Field -->
<div class="form-group">
    {!! Form::label('bag_item_type_id', 'Bag Item Type Id:') !!}
    <p>{{ $userBagItem->bag_item_type_id }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $userBagItem->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $userBagItem->updated_at }}</p>
</div>

