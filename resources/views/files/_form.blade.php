<div class="card-body">
    <div class="form-group row">
        {!! Form::label('file_name', 'File Name', ['class' => 'col-sm-2 col-form-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('file_name', null, ['class' => 'form-control', 'required', 'placeholder' => "Enter file name"]) !!}
        </div>
        @error('file_name')
        <p class="text-danger text-xs mt-1">
            {{ $message }}
        </p>
        @enderror
    </div>

    <div class="form-group row">
        {!! Form::label('file', 'File Upload', ['class' => 'col-sm-2 col-form-label']) !!}
        <div class="col-sm-10">
            {!! Form::file('file', ['class' => 'form-control-file', 'required']) !!}
        </div>
        @error('file')
        <p class="text-danger text-xs mt-1">
            {{ $message }}
        </p>
        @enderror
    </div>
</div>
