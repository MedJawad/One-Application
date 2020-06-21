<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Productions</title>
</head>
<body>
{{--{{HTML::style('css/table.css')}}--}}
<div class="container">
    <div class="row">
        <div class="col">
            <table class="table table-bordered" style="border : 1px solid black ">
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td>RELEVES</td>
                    <td> HORAIRES</td>
                    <td> DES</td>
                    <td> PRODUCTIONS</td>
                    <td> JOURNALIERES</td>
                    <td> THERMIQUES</td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <thead>
                <tr>

                    <th scope="col" style="background-color: #00bbff;color: #ff3b30;text-align: center;"><b>Hr THF</b>
                    </th>
                    @foreach($headers as $header)
                        <th scope="col"
                            style="border : 1px solid black;background-color: #00bbff;color: #ff3b30;text-align: center;">
                            <b>{{$header}}</b></th>
                    @endforeach

                </tr>
                </thead>
                <tbody>
                @foreach($contents as $key => $content)
                    @if($key==="brut"||$key==="net")
                        <tr>
                            <th scope="row"
                                style="background-color: #ffc90b;color: #ff3b30;border : 1px solid black;text-align: center;">
                                <b>{{$key}}</b></th>
                            @foreach($content as $value)
                                <td style="background-color: #ffc90b;color: #ff3b30;border : 1px solid black;text-align: center;">{{$value}}</td>
                            @endforeach
                        </tr>
                    @else
                        <tr>
                            <th scope="row"
                                style="background-color: #00bbff;color: #ff3b30;border : 1px solid black;text-align: center;">
                                <b>{{$key}}</b></th>
                            @foreach($content as $value)
                                <td style="background-color: #00ffff;color: #ff3b30;border : 1px solid black;text-align: center;">{{$value}}</td>
                            @endforeach
                        </tr>
                    @endif


                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
</body>
</html>
