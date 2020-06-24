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
                @for($i=1;$i<=24;$i++)
                    <tr>
                        <th style="border : 1px solid black;background-color: #00bbff;color: #ff3b30;text-align: center;">{{$i.'H'}}</th>
                        @foreach($barrages as $centrale)
                            @if(isset($centrale[$i.'H']))
                                <td>
                                    {{$centrale[$i.'H']}}
                                </td>
                            @else
                                <td>0</td>
                            @endif
                        @endforeach
                        <td>0</td>
                        @foreach($turbines as $centrale)
                            @if(isset($centrale[$i.'H']))
                                <td>
                                    {{$centrale[$i.'H']}}
                                </td>
                            @else
                                <td>0</td>
                            @endif
                        @endforeach
                        <td>0</td>
                        @foreach($eoliens as $centrale)
                            @if(isset($centrale[$i.'H']))
                                <td>
                                    {{$centrale[$i.'H']}}
                                </td>
                            @else
                                <td>0</td>
                            @endif
                        @endforeach
                        <td>0</td>
                        @foreach($thermiques as $centrale)
                            @if(isset($centrale[$i.'H']))
                                <td>
                                    {{$centrale[$i.'H']}}
                                </td>
                            @else
                                <td>0</td>
                            @endif
                        @endforeach
                        @foreach($cycles as $centrale)
                            @if(isset($centrale[$i.'H']))
                                <td>
                                    {{$centrale[$i.'H']}}
                                </td>
                            @else
                                <td>0</td>
                            @endif
                        @endforeach
                        @foreach($solaires as $centrale)
                            @if(isset($centrale[$i.'H']))
                                <td>
                                    {{$centrale[$i.'H']}}
                                </td>
                            @else
                                <td>0</td>
                            @endif
                        @endforeach
                        <td>0</td>
                        @foreach($inters as $centrale)
                            @if(isset($centrale[$i.'H']))
                                <td>
                                    {{$centrale[$i.'H']["recu"]}}
                                </td>
                                <td>
                                    {{$centrale[$i.'H']["fourni"]}}
                                </td>
                                <td>
                                    {{$centrale[$i.'H']["recu"]-$centrale[$i.'H']["fourni"]}}
                                </td>
                            @else
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                            @endif
                        @endforeach
                    </tr>
                @endfor
                <tr>
                    <th>Brut</th>
                    @foreach($barrages as $centrale)
                        @if(isset($centrale['Brut']))
                            <td>
                                {{$centrale['Brut']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    <td>0</td>
                    @foreach($turbines as $centrale)
                        @if(isset($centrale['Brut']))
                            <td>
                                {{$centrale['Brut']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    <td>0</td>
                    @foreach($eoliens as $centrale)
                        @if(isset($centrale['Brut']))
                            <td>
                                {{$centrale['Brut']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    <td>0</td>
                    @foreach($thermiques as $centrale)
                        @if(isset($centrale['Brut']))
                            <td>
                                {{$centrale['Brut']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    @foreach($cycles as $centrale)
                        @if(isset($centrale['Brut']))
                            <td>
                                {{$centrale['Brut']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    @foreach($solaires as $centrale)
                        @if(isset($centrale['Brut']))
                            <td>
                                {{$centrale['Brut']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    <td>0</td>
                    @foreach($inters as $centrale)
                        @if(isset($centrale['total']))
                            <td>
                                {{$centrale['total']["recu"]}}
                            </td>
                            <td>
                                {{$centrale['total']["fourni"]}}
                            </td>
                            <td>
                                {{$centrale['total']["recu"]-$centrale['total']["fourni"]}}
                            </td>
                        @else
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <th>Net</th>
                    @foreach($barrages as $centrale)
                        @if(isset($centrale['Net']))
                            <td>
                                {{$centrale['Net']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    <td>0</td>
                    @foreach($turbines as $centrale)
                        @if(isset($centrale['Net']))
                            <td>
                                {{$centrale['Net']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    <td>0</td>
                    @foreach($eoliens as $centrale)
                        @if(isset($centrale['Net']))
                            <td>
                                {{$centrale['Net']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    <td>0</td>
                    @foreach($thermiques as $centrale)
                        @if(isset($centrale['Net']))
                            <td>
                                {{$centrale['Net']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    @foreach($cycles as $centrale)
                        @if(isset($centrale['Net']))
                            <td>
                                {{$centrale['Net']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    @foreach($solaires as $centrale)
                        @if(isset($centrale['Net']))
                            <td>
                                {{$centrale['Net']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    <td>0</td>
                    @foreach($inters as $centrale)
                        @if(isset($centrale['total']))
                            <td colspan="3">
                                {{--                                {{$centrale['total']["recu"]}}--}}
                                {{--                            </td>--}}
                                {{--                            <td>--}}
                                {{--                                {{$centrale['total']["fourni"]}}--}}
                                {{--                            </td>--}}
                                {{--                            <td>--}}
                                {{$centrale['total']["fourni"]-$centrale['total']["recu"]}}
                            </td>
                        @else
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        @endif
                    @endforeach
                </tr>
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
