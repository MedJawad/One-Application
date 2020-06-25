<?php


namespace App\Http\Controllers;


use App\Centrale;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromArray;

class CombustibleExportsSheet implements FromArray
{

    /**
     * @inheritDoc
     */
    public function array(): array
    {
        $arr = array();
        $centrales = Centrale::whereType("Barrage")->get();
        foreach ($centrales as $index => $c) {
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $infos = $c->infos;//->where('date', '=', $yesterday);
            $arr[$index] = $infos;
        }
        return $arr;
    }
}
