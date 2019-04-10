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
                        <td style="max-height: 50px;height: 50px;">
                            <a data-fancybox="gallery"
                               data-caption="123"
                               itemprop="contentUrl"
                               href="{{ asset('moderate/in_moderate/' . $image->file_name) }}"
                            >
                                <img itemprop="thumbnailUrl"
                                     style="height: 50px; max-width: 100px;"
                                     alt="123"
                                     src="{{ asset('moderate/in_moderate/' . $image->file_name) }}"
                                />
                            </a>
                        </td>
                        <td></td>
                        <td>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger">
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
                <button type="button" class="btn btn-danger">Удалить выбранные</button>
            </div>
        </div>
    </div>
@endsection

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="/fancybox/jquery.fancybox.min.css" type="text/css" media="screen" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="/fancybox/jquery.fancybox.min.js"></script>
