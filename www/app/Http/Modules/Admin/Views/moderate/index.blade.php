@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-9">

            <table class="table">
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
                        Запросы
                    </td>
                    <td>

                    </td>
                </tr>
                </thead>
                <tbody>
                @foreach($images as $image)
                    <tr data-id="{{ $image->id }}">
                        <td>
                            {{ $image->id }}
                        </td>
                        <td style="max-height: 100px;height: 100px;">
                            <a data-fancybox="gallery"
                               data-caption="123"
                               itemprop="contentUrl"
                               href="{{ asset('moderate/in_moderate/' . $image->file_name) }}"
                            >
                                <img itemprop="thumbnailUrl"
                                     style="height: 100px; max-width: 200px;"
                                     alt="123"
                                     src="{{ asset('moderate/in_moderate/' . $image->file_name) }}"
                                />
                            </a>
                        </td>
                        <td></td>
                        <td>
                            @if ($image->queries()->count())
                                @foreach($image->queries as $query)
                                    <p>
                                        {{ $query->query }}
                                    </p>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger">-</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-3" style="right: 0;position: fixed">
            <div style="padding-top: 20px">
                <button type="button" class="btn btn-danger">Удалить выбранные</button>
            </div>
        </div>
    </div>
@endsection