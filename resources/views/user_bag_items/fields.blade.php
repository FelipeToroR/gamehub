<!-- Quantity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity', 'Quantity:') !!}
    {!! Form::text('quantity', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::text('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Game Instance Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('game_instance_id', 'Game Instance Id:') !!}
    {!! Form::text('game_instance_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Bag Item Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bag_item_type_id', 'Bag Item Type Id:') !!}
    {!! Form::text('bag_item_type_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('userBagItems.index') }}" class="btn btn-default">Cancel</a>
</div>
