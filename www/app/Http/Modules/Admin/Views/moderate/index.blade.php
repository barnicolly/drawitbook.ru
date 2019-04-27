@extends('layouts.base')

@push('scripts')
    <script src="{{ buildUrl('build/js/admin.min.js') }}" defer></script>
@endpush
@push('styles')
    <link rel="stylesheet" href="{{ buildUrl('build/css/admin.min.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-9">
            <table class="table moderate-table">
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
                            <button type="button" class="btn btn-success save-image">
                                <i class="fa fa-save"></i>
                            </button>
                            <button type="button" class="btn btn-default delete-image">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                        <td width="5%" class="checkbox-padding">
                            <label class="container-checkbox">
                                <input type="checkbox" class="selected" value="{{ $image->id }}">
                                <span class="checkmark"></span>
                            </label>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-3" style="right: 0;position: fixed">
            Количество записей для модерации: {{ $countNonModeratedRecords }}
            <div style="padding-top: 20px">
                <div class="form-group">
                    <button type="button" class="btn btn-info btn-sm refresh-page">Обновить страницу</button>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-info btn-sm save-all">Сохранить все</button>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-info btn-sm select-all">Выбрать все</button>
                </div>
                <div class="form-group operation-with-selected" style="display: none">
                    <button type="button" class="btn btn-danger btn-sm delete-selected">Удалить выбранные</button>
                </div>
                <div class="form-group operation-with-selected" style="display: none">
                    <button type="button" class="btn btn-default btn-sm unselect-all">Снять выделение</button>
                </div>
            </div>
            <div>
                <table>
                    <tbody>
                    @foreach($popular as $tag)
                        <tr>
                            <td class="content popular-tag">{{ $tag }}</td>
                            <td>
                                <button type="button" class=" btn btn-xs copyToClipboard">
                                    <span class="fa fa-copy"></span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
