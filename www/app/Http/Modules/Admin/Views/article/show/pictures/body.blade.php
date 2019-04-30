@if (!empty($article))
    @foreach($article->pictures as $picture)
        <tr data-id="{{ $picture->id }}" data-pivot-id="{{ $picture->pivot->id }}">
            <td width="3%">
                {{ $picture->id }}
            </td>
            <td width="3%">
                {{ $picture->pivot->sort_id }}
            </td>
            <td>
                {{ $picture->pivot->caption }}
            </td>
            <td style="height: 80px; width: 80px">
                <img class="img-fluid" src="{{ asset('arts/' . $picture->path) }}">
            </td>
            <td>
                <button type="button" class="btn btn-xs btn-info btn-delete edit-picture">
                    <span class="fa fa-pencil"></span>
                </button>
                <button type="button" class="btn btn-xs btn-danger delete-picture">
                    <span class="fa fa-remove"></span>
                </button>
            </td>
        </tr>
    @endforeach
@endif