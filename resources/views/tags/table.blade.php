<table class="table table-responsive" id="tags-table">
    <thead>
        <th>Name</th>
    </thead>
    <tbody>
    @foreach($tags as $tag)
        <tr>
            <td>{!! $tag->name !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>