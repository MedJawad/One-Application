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
            <table border="1" style="border : 1px solid black ">
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
                        @foreach($barragesProd as $centrale)
                            @if(isset($centrale[$i.'H']))
                                <td>
                                    {{$centrale[$i.'H']}}
                                </td>
                            @else
                                <td>0</td>
                            @endif
                        @endforeach
                        <td>0</td>
                        @foreach($turbinesProd as $centrale)
                            @if(isset($centrale[$i.'H']))
                                <td>
                                    {{$centrale[$i.'H']}}
                                </td>
                            @else
                                <td>0</td>
                            @endif
                        @endforeach
                        <td>0</td>
                        @foreach($eoliensProd as $centrale)
                            @if(isset($centrale[$i.'H']))
                                <td>
                                    {{$centrale[$i.'H']}}
                                </td>
                            @else
                                <td>0</td>
                            @endif
                        @endforeach
                        <td>0</td>
                        @foreach($thermiquesProd as $centrale)
                            @if(isset($centrale[$i.'H']))
                                <td>
                                    {{$centrale[$i.'H']}}
                                </td>
                            @else
                                <td>0</td>
                            @endif
                        @endforeach
                        @foreach($cyclesProd as $centrale)
                            @if(isset($centrale[$i.'H']))
                                <td>
                                    {{$centrale[$i.'H']}}
                                </td>
                            @else
                                <td>0</td>
                            @endif
                        @endforeach
                        @foreach($solairesProd as $centrale)
                            @if(isset($centrale[$i.'H']))
                                <td>
                                    {{$centrale[$i.'H']}}
                                </td>
                            @else
                                <td>0</td>
                            @endif
                        @endforeach
                        <td>0</td>
                        @foreach($intersProd as $centrale)
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
                    <th style="background-color: #ffc90b;color: #ff3b30;border : 1px solid black;text-align: center;">
                        Brut
                    </th>
                    @foreach($barragesProd as $centrale)
                        @if(isset($centrale['Brut']))
                            <td>
                                {{$centrale['Brut']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    <td>0</td>
                    @foreach($turbinesProd as $centrale)
                        @if(isset($centrale['Brut']))
                            <td>
                                {{$centrale['Brut']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    <td>0</td>
                    @foreach($eoliensProd as $centrale)
                        @if(isset($centrale['Brut']))
                            <td>
                                {{$centrale['Brut']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    <td>0</td>
                    @foreach($thermiquesProd as $centrale)
                        @if(isset($centrale['Brut']))
                            <td>
                                {{$centrale['Brut']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    @foreach($cyclesProd as $centrale)
                        @if(isset($centrale['Brut']))
                            <td>
                                {{$centrale['Brut']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    @foreach($solairesProd as $centrale)
                        @if(isset($centrale['Brut']))
                            <td>
                                {{$centrale['Brut']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    <td>0</td>
                    @foreach($intersProd as $centrale)
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
                    <th style="background-color: #ffc90b;color: #ff3b30;border : 1px solid black;text-align: center;">
                        Net
                    </th>
                    @foreach($barragesProd as $centrale)
                        @if(isset($centrale['Net']))
                            <td>
                                {{$centrale['Net']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    <td>0</td>
                    @foreach($turbinesProd as $centrale)
                        @if(isset($centrale['Net']))
                            <td>
                                {{$centrale['Net']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    <td>0</td>
                    @foreach($eoliensProd as $centrale)
                        @if(isset($centrale['Net']))
                            <td>
                                {{$centrale['Net']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    <td>0</td>
                    @foreach($thermiquesProd as $centrale)
                        @if(isset($centrale['Net']))
                            <td>
                                {{$centrale['Net']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    @foreach($cyclesProd as $centrale)
                        @if(isset($centrale['Net']))
                            <td>
                                {{$centrale['Net']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    @foreach($solairesProd as $centrale)
                        @if(isset($centrale['Net']))
                            <td>
                                {{$centrale['Net']}}
                            </td>
                        @else
                            <td>0</td>
                        @endif
                    @endforeach
                    <td>0</td>
                    @foreach($intersProd as $centrale)
                        @if(isset($centrale['total']))
                            <td colspan="3">
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
            <table border="1">
                <tr>
                    <td></td>
                    <td colspan="9" style="background-color: #83ff00;color: #ffffff;text-align: center;">Situation
                        Combustible
                    </td>
                </tr>
                <tr>
                    <td></td>

                    <td colspan="3" style="background-color: #ffbd00;color: #ffffff;text-align: center;">Centrale</td>
                    <td colspan="1" style="background-color: #ffbd00;color: #ffffff;text-align: center;">Stock utile
                        j-1
                    </td>
                    <td colspan="1" style="background-color: #ffbd00;color: #ffffff;text-align: center;">Livraison</td>
                    <td colspan="1" style="background-color: #ffbd00;color: #ffffff;text-align: center;">Consommation
                    </td>
                    <td colspan="1" style="background-color: #ffbd00;color: #ffffff;text-align: center;">Transfert</td>
                    <td colspan="1" style="background-color: #ffbd00;color: #ffffff;text-align: center;">Stock Utile
                    </td>
                    <td colspan="1" style="background-color: #ffbd00;color: #ffffff;text-align: center;">Consom. spec.
                    </td>
                    <td colspan="1" style="background-color: #ffbd00;color: #ffffff;text-align: center;">Prod. Gazoil
                    </td>
                </tr>
                @foreach($combustibles as $nom=>$comb)
                    <tr>
                        <td></td>
                        <td>
                            {{$nom}}
                        </td>
                        <td></td>
                        <td>Fioul</td>
                        <td>0</td>
                        <td>{{$comb['livraison_fioul']}}</td>
                        <td>{{$comb['consommation_fioul']}}</td>
                        <td>{{$comb['transfert_fioul']}}</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    @if(isset($comb["livraison_charbon"]))
                        <tr>
                            <td></td>
                            <td>
                            </td>
                            <td></td>
                            <td>Charbon</td>
                            <td>0</td>
                            <td>{{$comb['livraison_charbon']}}</td>
                            <td>{{$comb['consommation_charbon']}}</td>
                            <td>{{$comb['transfert_charbon']}}</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                    @endif
                    @if(isset($comb["livraison_gazoil"]))
                        <tr>
                            <td></td>
                            <td>
                            </td>
                            <td></td>
                            <td>Gazoil</td>
                            <td>0</td>
                            <td>{{$comb['livraison_gazoil']}}</td>
                            <td>{{$comb['consommation_gazoil']}}</td>
                            <td>{{$comb['transfert_gazoil']}}</td>
                            <td>0</td>
                            <td>0</td>
                            <td>{{$comb['production_gazoil']}}</td>

                        </tr>
                    @endif
                @endforeach
            </table>
            <table border="1">
                <tr>
                    <th style="border : 1px solid black;background-color: #00bbff;color: #ff3b30;text-align: center;">
                        Nom
                    </th>
                    @foreach($barragesInfos as $nom => $b)
                        <td colspan="2"
                            style="border : 1px solid black;background-color: #00bbff;color: #ff3b30;text-align: center;">{{$nom}}</td>
                    @endforeach
                </tr>
                <tr>
                    <th style="border : 1px solid black;background-color: #00bbff;color: #ff3b30;text-align: center;">
                        Turbinage
                    </th>
                    @foreach($barragesInfos as $nom => $b)
                        @if(isset($b['turbine']))
                            <td colspan="2">{{$b['turbine']}}</td>
                        @else
                            <td colspan="2"></td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <th style="border : 1px solid black;background-color: #00bbff;color: #ff3b30;text-align: center;">
                        Irrigation
                    </th>
                    @foreach($barragesInfos as $nom => $b)
                        @if(isset($b['irrigation']))
                            <td colspan="2">{{$b['irrigation']}}</td>
                        @else
                            <td colspan="2"></td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <th style="border : 1px solid black;background-color: #00bbff;color: #ff3b30;text-align: center;">
                        Lache
                    </th>
                    @foreach($barragesInfos as $nom => $b)
                        @if(isset($b['lache']))
                            <td colspan="2">{{$b['lache']}}</td>
                        @else
                            <td colspan="2"></td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <th style="border : 1px solid black;background-color: #00bbff;color: #ff3b30;text-align: center;">
                        Cote à 24H
                    </th>
                    @foreach($barragesInfos as $nom => $b)
                        @if(isset($b['cote2']))
                            <td colspan="1">{{$b['cote']}}</td>
                            <td colspan="1">{{$b['cote2']}}</td>
                        @elseif(isset($b['cote']))
                            <td colspan="2">{{$b['cote']}}</td>
                        @else
                            <td colspan="2"></td>
                        @endif
                    @endforeach
                </tr>
                <tr></tr>
                <tr>
                    <th style="border : 1px solid black;background-color: #00bbff;color: #ff3b30;text-align: center;">
                        Volume Pompe
                    </th>
                    @foreach($barragesInfos as $nom => $b)
                        @if(isset($b['volume_pompe']))
                            <td colspan="2">{{$b['volume_pompe']}}</td>
                        @else
                            <td colspan="2"></td>
                        @endif
                    @endforeach
                </tr>
            </table>

            <table >
                <tr>
                    <th style="border : 1px solid black;background-color: #00bbff;color: #ff3b30;text-align: center;">Nom</th>
                    @foreach($thermiqueInfos as $nom => $t)
                        <td  style="border : 1px solid black;background-color: #00bbff;color: #ff3b30;text-align: center;">{{$nom}}</td>
                    @endforeach
                </tr>
                <tr>
                    <th style="border : 1px solid black;background-color: #00bbff;color: #ff3b30;text-align: center;">Autonomie Charbon</th>
                    @foreach($thermiqueInfos as $nom => $t)
                        @if(isset($t['autonomie_charbon']))
                            <td>{{$t['autonomie_charbon']}}</td>
                        @else
                            <td></td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <th style="border : 1px solid black;background-color: #00bbff;color: #ff3b30;text-align: center;">Ancien Index</th>
                    @foreach($thermiqueInfos as $nom => $t)
                        @if(isset($t['oldIndex']))
                            <td>{{$t['oldIndex']}}</td>
                        @else
                            <td></td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <th style="border : 1px solid black;background-color: #00bbff;color: #ff3b30;text-align: center;">Nouveau Index</th>
                    @foreach($thermiqueInfos as $nom => $t)
                        @if(isset($t['index']))
                            <td>{{$t['index']}}</td>
                        @else
                            <td></td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <th style="border : 1px solid black;background-color: #00bbff;color: #ff3b30;text-align: center;">Net</th>
                    @foreach($thermiqueInfos as $nom => $t)
                        @if(isset($t['oldIndex']))
                            <td>{{$t['index'] - $t['oldIndex']}}</td>
                        @elseif(isset($t['index']))
                            <td>{{$t['index']}}</td>
                        @else
                            <td></td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <th style="border : 1px solid black;background-color: #00bbff;color: #ff3b30;text-align: center;">Total</th>
{{--                    <td colspan="6">=SUM(B70;C70;D70;E70;F70;G70)</td>--}}
{{--                    <td colspan="2">=SUM(H70;I70)</td>--}}
                    <td colspan="6">=SUM(B70:G70)</td>
                    <td colspan="2">=SUM(H70:I70)</td>
                </tr>
                <tr>
                    <th style="border : 1px solid black;background-color: #00bbff;color: #ff3b30;text-align: center;">Net - Brut en %</th>
                    <td>=(BD30-B70)/BD30</td>
                    <td>=(BE30-C70)/BE30</td>
                    <td>=(BF30-D70)/BE30</td>
                    <td>=(BG30-E70)/BE30</td>
                    <td>=(BH30-F70)/BE30</td>
                    <td>=(BI30-G70)/BE30</td>
                </tr>
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
