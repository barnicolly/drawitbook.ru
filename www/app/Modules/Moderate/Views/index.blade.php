<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale = 1.0">
    <style>
        body {
            /*background: url(//subtlepatterns.com/patterns/scribble_light.png);*/
            font-family: Calluna, Arial, sans-serif;
            /*min-height: 1000px;*/
        }

        #columns {
            column-width: 320px;
            column-gap: 15px;
            width: 90%;
            max-width: 1100px;
            margin: 50px auto;
        }

        div#columns figure {
            background: #fefefe;
            border: 2px solid #fcfcfc;
            box-shadow: 0 1px 2px rgba(34, 25, 25, 0.4);
            margin: 0 2px 15px;
            padding: 15px;
            padding-bottom: 10px;
            transition: opacity .4s ease-in-out;
            display: inline-block;
            column-break-inside: avoid;
        }

        div#columns figure img {
            width: 100%;
            height: auto;
            border-bottom: 1px solid #ccc;
            padding-bottom: 15px;
            margin-bottom: 5px;
        }

        div#columns figure figcaption {
            font-size: .9rem;
            color: #444;
            line-height: 1.5;
        }

        div#columns small {
            font-size: 1rem;
            float: right;
            text-transform: uppercase;
            color: #aaa;
        }

        div#columns small a {
            color: #666;
            text-decoration: none;
            transition: .4s color;
        }

        div#columns:hover figure:not(:hover) {
            opacity: 0.4;
        }

        @media screen and (max-width: 750px) {
            #columns {
                column-gap: 0px;
            }

            #columns figure {
                width: 100%;
            }
        }
    </style>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="columns">
                @foreach($images as $image)
                    <figure>
                        <img src="{{ asset('kartinki/' . $image->file_name) }}">
                        <figcaption>Belle, based on 1770’s French court fashion</figcaption>
                    </figure>
                @endforeach
                <small>Art &copy; <a href="//clairehummel.com">Claire Hummel</a></small>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


</body>
</html>


