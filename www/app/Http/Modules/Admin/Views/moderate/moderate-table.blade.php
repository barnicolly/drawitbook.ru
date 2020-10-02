<table class="table table-sm moderate-table">
    <thead>
    <tr>
        <td>
            #
        </td>
        <td>
            Изображение
        </td>
        <td>
            Описание
        </td>
        <td>

        </td>
        <td>
            Теги
        </td>
        <td>
        </td>
        <td>

        </td>
    </tr>
    </thead>
    <tbody>
    @foreach($images as $image)
        <tr data-id="{{ $image->id }}" data-picture-id="0">
            <td width="5%">
                {{ $image->id }}
            </td>
            <td width="15%" style="max-height: 50px;height: 50px;">
                <a data-fancybox="gallery"
                   data-caption="123"
                   itemprop="contentUrl"
                   href="{{ asset('moderate/in_moderate/' . $image->file_name) }}"
                >
                    <img itemprop="thumbnailUrl"
                         style="max-width: 100px;max-height: 100px;"
                         alt="123"
                         src="{{ asset('moderate/in_moderate/' . $image->file_name) }}"
                    />
                </a>
            </td>
            <td width="25%">
                <textarea class="form-control description" rows="2" placeholder="Описание"></textarea>
            </td>
            <td>
                <button class="btn btn-success btn-xs add-tag">
                    <span class="fa fa-plus"></span>
                </button>
            </td>
            <td>
                <div class="tags">
                    {{--первый по умолчанию--}}
                    @if (!empty($defaultTags))
                        @foreach($defaultTags as $tag)
                            <div class="tag form-group input-group"><input type="text" class="form-control" value="{{ $tag }}">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-danger btn-xs delete-tag input-group-append">
                                        <span class="fa fa-trash"></span></button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="tag form-group input-group"><input type="text" class="form-control">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-danger btn-xs delete-tag input-group-append">
                                    <span class="fa fa-trash"></span></button>
                            </div>
                        </div>
                    @endif
                </div>
            </td>
            <td width="13%">
                <button type="button" class="btn btn-success btn-xs save-image">
                    <i class="fa fa-save"></i>
                </button>
                <button type="button" class="btn btn-default btn-xs delete-image">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
            <td width="2%" class="checkbox-padding">
                <label class="container-checkbox">
                    <input type="checkbox" class="selected" value="{{ $image->id }}">
                    <span class="checkmark"></span>
                </label>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>