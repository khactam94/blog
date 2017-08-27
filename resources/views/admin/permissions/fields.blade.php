<!-- Name Field -->
<div class="form-group col-sm-9">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    @if($errors->has('name'))
        <p class="alert alert-danger msg">
            {{ $errors->first('name') }}
        </p>
    @endif
</div>

<!-- Display Name Field -->
<div class="form-group col-sm-9">
    {!! Form::label('display_name', 'Display Name:') !!}
    {!! Form::text('display_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-9">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.permissions.index') !!}" class="btn btn-default">Cancel</a>
</div>
