<?php

use Illuminate\Database\Seeder;

class CentraleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $barrages = [
            ['nom' => 'O.E.M 1829', 'subtype' => 'normal'],
            ['nom' => 'Lau t', 'subtype' => 'normal'],
            ['nom' => 'EK 1769', 'subtype' => 'normal'],
            ['nom' => 'ALW 1873', 'subtype' => 'normal'],
            ['nom' => 'ID 1865', 'subtype' => 'normal'],
            ['nom' => 'A.E.F 1866', 'subtype' => '+cote'],
            ['nom' => 'M.V 1723', 'subtype' => 'normal'],
            ['nom' => 'B.areg', 'subtype' => 'normal'],
            ['nom' => 'H 1er  1792', 'subtype' => 'normal'],
            ['nom' => 'TAK PTT 1494', 'subtype' => 'normal'],
            ['nom' => 'MY  1794', 'subtype' => 'normal'],
            ['nom' => 'MED 1636 1011', 'subtype' => 'normal'],
            ['nom' => 'A.E.H 1773', 'subtype' => 'normal'],
            ['nom' => 'AM 1662', 'subtype' => 'normal'],
            ['nom' => 'AIT MESS.', 'subtype' => 'normal'],
            ['nom' => 'AF 1775', 'subtype' => 'normal'],
            ['nom' => 'BEO 1867', 'subtype' => 'normal'],
            ['nom' => 'Tanafnit', 'subtype' => '-cote'],
            ['nom' => "EL BORJ 1766", 'subtype' => '-cote'],
            ['nom' => 'IMF 1732', 'subtype' => 'onlyVolumePompe'],
            ['nom' => 'DA 1733', 'subtype' => 'onlyVolumePompe'],
            ['nom' => 'Mâac', 'subtype' => 'onlyVolumePompe'],
            ['nom' => 'STEP Turbinée 1776-1777', 'subtype' => 'onlyProductionCote'],
            ['nom' => 'STEP Pompée', 'subtype' => 'onlyProductionCote'],
        ];
        $thermiques = [
            ['nom' => 'JLEC 1', 'subtype' => '-autonomie'],
            ['nom' => 'JLEC 2', 'subtype' => '-autonomie'],
            ['nom' => 'JLEC 3', 'subtype' => 'normal'],
            ['nom' => 'JLEC 4', 'subtype' => 'normal'],
            ['nom' => 'JLEC 5', 'subtype' => 'normal'],
            ['nom' => 'JLEC 6', 'subtype' => 'normal'],
            ['nom' => 'SAFIEC 1', 'subtype' => 'normal'],
            ['nom' => 'SAFIEC 2', 'subtype' => '-autonomie'],
        ];
        $cc = [['nom' => 'EET', 'subtype' => 'normal'], ['nom' => 'ABM', 'subtype' => 'normal']];
        $solaires = [
            ['nom' => 'NOOR 1', 'subtype' => 'normal'],
            ['nom' => 'NOOR 2', 'subtype' => 'normal'],
            ['nom' => 'NOOR 3', 'subtype' => 'normal'],
            ['nom' => 'NOOR 4', 'subtype' => 'normal'],
            ['nom' => 'PV LAAYOUN', 'subtype' => 'normal'],
            //['nom' => 'PV BOUJDOUR', 'subtype' => 'normal']
        ];
        $eoliens = [
            ['nom' => "EOL AMOU 1762", 'subtype' => 'normal'],
            ['nom' => 'CED', 'subtype' => 'normal'],
            ['nom' => 'EOL Tanger', 'subtype' => 'normal'],
            ['nom' => 'AFTISSAT 1570', 'subtype' => 'normal'],
            ['nom' => 'HAOUMA', 'subtype' => 'normal'],
            ['nom' => 'AKHFENNIR', 'subtype' => 'normal'],
            ['nom' => 'Foum Eloued', 'subtype' => 'normal'],
            ['nom' => 'Tarfaya', 'subtype' => 'normal'],
            ['nom' => 'LAFARG Tetouan', 'subtype' => 'normal'],
            ['nom' => 'Khalladi 1657', 'subtype' => 'normal'],
        ];
        $tag = [
            ['nom' => 'CTJ', 'subtype' => 'normal'],
            ['nom' => 'CTJ 350Mw', 'subtype' => '+charbon'],
            ['nom' => 'CTK  1848 1849', 'subtype' => 'normal'],
            ['nom' => "C.T.M Tr 1/2 Fioul 2805", 'subtype' => 'normal'],
            ['nom' => "C.T.M Tr 3/4 Ch  2806", 'subtype' => '+charbon'],
            ['nom' => "C.T.M Tr 3/4 Soutien Fioul", 'subtype' => 'normal'],
            ['nom' => 'TAG C.T.M 30Mw 1752', 'subtype' => 'normal'],
            ['nom' => 'T.Mellil 1804', 'subtype' => 'normal'],
            ['nom' => 'Tan Tan', 'subtype' => 'normal'],
            ['nom' => 'Tetouan  1845', 'subtype' => 'normal'],
            ['nom' => 'TAG CTM 2 100Mw 1798', 'subtype' => '+gazoil'],
            ['nom' => 'TAG CTK 100MW 1892', 'subtype' => '+gazoil'],
            ['nom' => 'TAG20 Tanger', 'subtype' => 'normal'],
            ['nom' => 'TAG20 agadir', 'subtype' => 'normal'],
            ['nom' => 'Lâayoune (GD)', 'subtype' => 'normal'],
            ['nom' => 'TAG Lâayoune', 'subtype' => '+gazoil'],
            ['nom' => 'P, Usine', 'subtype' => 'normal'],
        ];
        $inter = [['nom' => 'I.M.A', 'subtype' => 'normal'], ['nom' => 'I.M.E', 'subtype' => 'normal']];
        foreach ($barrages as $c) {
            $user = App\User::create(['username' => $c["nom"], 'password' => bcrypt($c["nom"]), 'role' => 'user']);
            App\Centrale::create(['nom' => $c["nom"], 'type' => 'Barrage', 'subtype' => $c["subtype"], 'user_id' => $user->id]);
        }
        foreach ($thermiques as $c) {
            $user = App\User::create(['username' => $c["nom"], 'password' => bcrypt($c["nom"]), 'role' => 'user']);
            App\Centrale::create(['nom' => $c["nom"], 'type' => 'Thermique a charbon', 'subtype' => $c["subtype"], 'user_id' => $user->id]);

        }
        foreach ($cc as $c) {
            $user = App\User::create(['username' => $c["nom"], 'password' => bcrypt($c["nom"]), 'role' => 'user']);
            App\Centrale::create(['nom' => $c["nom"], 'type' => 'Cycle Combine', 'subtype' => $c["subtype"], 'user_id' => $user->id]);

        }
        foreach ($solaires as $c) {
            $user = App\User::create(['username' => $c["nom"], 'password' => bcrypt($c["nom"]), 'role' => 'user']);
            App\Centrale::create(['nom' => $c["nom"], 'type' => 'Solaire', 'subtype' => $c["subtype"], 'user_id' => $user->id]);
        }
        foreach ($eoliens as $c) {
            $user = App\User::create(['username' => $c["nom"], 'password' => bcrypt($c["nom"]), 'role' => 'user']);
            App\Centrale::create(['nom' => $c["nom"], 'type' => 'Eolien', 'subtype' => $c["subtype"], 'user_id' => $user->id]);
        }
        foreach ($tag as $c) {
            $user = App\User::create(['username' => $c["nom"], 'password' => bcrypt($c["nom"]), 'role' => 'user']);
            App\Centrale::create(['nom' => $c["nom"], 'type' => 'Turbine a gaz', 'subtype' => $c["subtype"], 'user_id' => $user->id]);
        }
        foreach ($inter as $c) {
            $user = App\User::create(['username' => $c["nom"], 'password' => bcrypt($c["nom"]), 'role' => 'user']);
            App\Centrale::create(['nom' => $c["nom"], 'type' => 'Interconnexion', 'subtype' => $c["subtype"], 'user_id' => $user->id]);
        }
//        App\User::create(['username' => 'CTJ', 'password' => bcrypt('CTJ'), 'role' => 'user']);
//        App\Centrale::create(['nom' => 'CTJ', 'type' => 'Thermique a charbon', 'user_id' => '2']);

    }
}
