<div class="form-group col-sm-12">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-12">
    {!! Form::textarea('content', null, ['class' => 'ckeditor', 'id' => 'posteditor']) !!}
    <script type="text/javascript">
    	var config = {
			extraPlugins: 'codesnippet',
			codeSnippet_theme: 'monokai_sublime',
			height: 356
		};
        CKEDITOR.replace( 'posteditor',config);
    </script>
</div>
<div class="form-group col-sm-12">
    {!! Form::label('categories', 'Categories:') !!}
    {!! Form::text('categories', null, ['class' => 'form-control', 'id'=>'categorytoken', 'placeholder'=>'Categories']) !!}
</div>
<div class="form-group col-sm-12">
    {!! Form::label('tags', 'Tag:') !!}
    {!! Form::text('tags', null, ['class' => 'form-control', 'id'=>'tagtoken', 'placeholder'=>'Tags']) !!}
</div>
{!! Form::submit('submit', ['class' => 'btn btn-success']); !!}
<a href="{!! route('posts.index') !!}" class="btn btn-default">Cancel</a>