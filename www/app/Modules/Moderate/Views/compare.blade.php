<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale = 1.0">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>
<body>

<div class="container">
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
</div>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="/fancybox/jquery.fancybox.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="/fancybox/jquery.fancybox.min.js"></script>
<script>
    $(function () {
        $(".various").fancybox({
            maxWidth: 800,
            maxHeight: 600,
            fitToView: false,
            width: '70%',
            height: '70%',
            autoSize: false,
            closeClick: false,
            openEffect: 'none',
            closeEffect: 'none'
        });

    });
</script>
</body>
</html>


