@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12 form-group">
            Количество записей для модерации: {{ $countNonModeratedRecords }}
        </div>
        <div class="col-md-9">
            <table class="table">
                <thead>
                <tr>
                    <td>
                        #
                    </td>
                    <td>
                    </td>
                    <td>
                        Изображение
                    </td>
                    <td>
                        Описание
                    </td>
                    <td>
                        Теги
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
                        <td width="5%">
                            <input type="checkbox" value="{{ $image->id }}">
                        </td>
                        <td width="15%" style="max-height: 50px;height: 50px;">
                            <a data-fancybox="gallery"
                               data-caption="123"
                               itemprop="contentUrl"
                               href="{{ asset('moderate/in_moderate/' . $image->file_name) }}"
                            >
                                <img itemprop="thumbnailUrl"
                                     style="max-width: 100px;"
                                     alt="123"
                                     src="{{ asset('moderate/in_moderate/' . $image->file_name) }}"
                                />
                            </a>
                        </td>
                        <td width="35%">
                            <textarea class="form-control description" rows="2" placeholder="Описание"></textarea>
                        </td>
                        <td>
                            <div class="form-group">
                                <button class="btn btn-success btn-sm add-tag">
                                    <span class="fa fa-plus"></span>
                                </button>
                            </div>
                            <div class="tags">
                                {{--первый по умолчанию--}}
                                <div class="tag form-group input-group"><input type="text" class="form-control">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-danger delete-tag input-group-append"><span
                                                    class="fa fa-trash"></span></button>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td width="15%">
                            <button type="button" class="btn btn-success btn-sm save-image">
                                <i class="fa fa-save"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-sm delete-image">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-3" style="right: 0;position: fixed">
            <div style="padding-top: 20px">
                <button type="button" class="btn btn-danger btn-sm">Удалить выбранные</button>
                <button type="button" class="btn btn-danger btn-sm refresh-page">Обновить</button>
            </div>
        </div>
    </div>
@endsection
