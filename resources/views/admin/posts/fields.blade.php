<div class="form-group col-sm-12">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
    @if($errors->has('title'))
        <p class="alert alert-danger msg">
            {{ $errors->first('title') }}
        </p>
    @endif
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
    @if($errors->has('content'))
        <p class="alert alert-danger msg">
            {{ $errors->first('content') }}
        </p>
    @endif
</div>
<div class="form-group col-sm-12">
    {!! Form::label('categories', 'Categories:') !!}
    {!! Form::text('categories', empty($post->categories) ? '' : implode(',', $post->categories->pluck('name')->toArray()), ['class' => 'form-control', 'id'=>'categorytoken', 'placeholder'=>'Categories']) !!}
</div>
<div class="form-group col-sm-12">
    {!! Form::label('tags', 'Tag:') !!}
    <div class="input-group input-group-sm">
        {!! Form::text('tags', empty($post->tags) ? '': implode(',', $post->tags->pluck('name')->toArray()), ['class' => 'form-control', 'id'=>'tagtoken', 'placeholder'=>'Tags']) !!}
        <span class="input-group-btn">
            <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#add-tag-modal">Add Tag</button>
        </span>
    </div>
</div>
<div class="form-group col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status', $statuses, null, ['class' => 'form-control']) !!}
</div>
{!! Form::submit('submit', ['class' => 'btn btn-success']) !!}
<a href="{!! route('admin.posts.index') !!}" class="btn btn-default">Cancel</a>

<div class="modal fade" id="add-tag-modal" style="padding-right: 16px;" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">ADD TAG</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" placeholder="Tag">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-left" >Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>