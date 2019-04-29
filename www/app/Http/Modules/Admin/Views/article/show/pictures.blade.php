<div id="article-pictures">
    <button type="button" class="btn btn-sm btn-link add-picture form-group" <?= (empty($article)) ? 'disabled' : '' ?>>
        Добавить
    </button>
    <table class="table table-sm">
        <thead>
        <th>#</th>
        <th>sort</th>
        <th>Caption</th>
        <th></th>
        <th></th>
        </thead>
        <tbody>
        @if (!empty($article))
            @foreach($article->pictures as $picture)
                <tr data-id="{{ $picture->id }}">
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
        </tbody>
        @endif
    </table>
</div>