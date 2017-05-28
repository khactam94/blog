<table class="table table-responsive" id="categories-table">
    <thead>
        <th>Name</th>
    </thead>
    <tbody>
    @foreach($categories as $category)
        <tr>
            <td>{!! $category->name !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<center>{{ $categories->links()}}</center>
