{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <!-- Required meta tags -->--}}
{{--    <meta charset="utf-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">--}}
{{--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>--}}
{{--    <!-- Bootstrap CSS -->--}}
{{--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"--}}
{{--          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">--}}

{{--    <title>Productions</title>--}}
{{--</head>--}}
{{--<body>--}}
{{--{{HTML::style('css/table.css')}}--}}
{{--<div class="container">--}}
{{--    <div class="row">--}}
{{--        <div class="col">--}}
{{--            <table class="table table-bordered" style="border : 1px solid black ">--}}
{{--                <thead>--}}
{{--                <th>HR</th>--}}
{{--                @foreach($headers as $header)--}}
{{--                    <th>{{$header}}</th>--}}
{{--                @endforeach--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                @for($i=1;$i<=24;$i++)--}}
{{--                                        <tr>--}}
{{--                                            @foreach($headers as $header)--}}
{{--                                                @if(isset($contents[$i.'H'][$header]))--}}
{{--                                                    <td>--}}
{{--                                                        {{$contents[$i.'H'][$header]}}--}}
{{--                                                    </td>--}}
{{--                                                @else--}}
{{--                                                    <td>0</td>--}}
{{--                                                @endif--}}
{{--                                            @endforeach--}}
{{--                                        </tr>--}}
{{--                    <tr>--}}
{{--                    <th>{{$i.'H'}}</th>--}}


{{--                        @foreach($headers as $h)--}}
{{--                            @if(isset($turbines[$i.'H'][$h]))--}}
{{--                                <td>{{$turbines[$i.'H'][$h]}}</td>--}}
{{--                            @elseif(isset($barrages[$i.'H'][$h]))--}}
{{--                                <td>{{$barrages[$i.'H'][$h]}}</td>--}}
{{--                            @elseif(isset($eoliens[$i.'H'][$h]))--}}
{{--                                <td>{{$eoliens[$i.'H'][$h]}}</td>--}}
{{--                            @elseif(isset($thermiques[$i.'H'][$h]))--}}
{{--                                <td>{{$thermiques[$i.'H'][$h]}}</td>--}}
{{--                            @elseif(isset($cycles[$i.'H'][$h]))--}}
{{--                                <td>{{$cycles[$i.'H'][$h]}}</td>--}}
{{--                            @elseif(isset($solaires[$i.'H'][$h]))--}}
{{--                                <td>{{$solaires[$i.'H'][$h]}}</td>--}}
{{--                            @elseif(isset($inters[$i.'H'][$h]))--}}
{{--                                <td>{{$inters[$i.'H'][$h]["recu"]}}</td>--}}
{{--                                <td>{{$inters[$i.'H'][$h]["fourni"]}}</td>--}}
{{--                                <td>{{$inters[$i.'H'][$h]["recu"] - $inters[$i.'H'][$h]["fourni"]}}</td>--}}
{{--                            @else--}}
{{--                                <td>0</td>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                        @endfor--}}
{{--                    </tr>--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<!-- Optional JavaScript -->--}}
{{--<!-- jQuery first, then Popper.js, then Bootstrap JS -->--}}
{{--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"--}}
{{--        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"--}}
{{--        crossorigin="anonymous"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"--}}
{{--        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"--}}
{{--        crossorigin="anonymous"></script>--}}
{{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"--}}
{{--        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"--}}
{{--        crossorigin="anonymous"></script>--}}
{{--</body>--}}
{{--</html>--}}
