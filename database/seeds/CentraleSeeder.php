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
        $barrages = ['O.E.M 1829', 'Lau t', 'EK 1769', 'ALW 1873', 'ID 1865', 'A.E.F 1866', 'M.V 1723', ' B.areg', 'H 1er  1792', 'TAK PTT 1494', 'MY  1794', 'MED 1636 1011', 'A.E.H 1773', 'AM 1662', 'AIT MESS.', 'AF 1775', 'BEO 1867', 'Tanafnit', "EL BORJ 1766", 'IMF 1732', 'DA 1733', ' Mâac', 'STEP Turbinée 1776-1777', 'STEP Pompée'];
        $thermiques = ['JLEC 1', 'JLEC 2', 'JLEC 3', 'JLEC 4', 'JLEC 5', 'JLEC 6', 'SAFIEC 1', 'SAFIEC 2'];
        $cc = ['EET', 'ABM'];
        $solaires = ['NOOR 1', 'NOOR 2', 'NOOR 3', 'NOOR 4', 'PV LAAYOUN', 'PV BOUJDOUR'];
        $eoliens = ["EOL AMOU 1762", 'CED', 'EOL Tanger', 'AFTISSAT 1570', 'HAOUMA', 'AKHFENNIR', 'Foum Eloued', 'Tarfaya', 'LAFARG Tetouan', 'Khalladi 1657'];
        $tag = ['CTJ', 'CTJ 350Mw', 'CTK  1848 1849', "C.T.M Tr 1/2 Fioul 2805", "C.T.M Tr 3/4 Ch  2806", "C.T.M Tr 3/4 Soutien Fioul", 'TAG C.T.M 30Mw 1752', 'T.Mellil 1804', 'Tan Tan', 'Tetouan  1845', 'TAG CTM 2 100Mw 1798', 'TAG CTK 100MW 1892', 'TAG20 Tanger', 'TAG20 agadir', 'Lâayoune (GD)', 'TAG Lâayoune', 'P, Usine'];

        foreach ($barrages as $nom) {
            $user = App\User::create(['username' => $nom, 'password' => bcrypt($nom), 'role' => 'user']);
            $c = App\Centrale::create(['nom' => $nom, 'type' => 'Barrage', 'user_id' => $user->id]);
        }
        foreach ($thermiques as $nom) {
            $user = App\User::create(['username' => $nom, 'password' => bcrypt($nom), 'role' => 'user']);
            $c = App\Centrale::create(['nom' => $nom, 'type' => 'Thermique a charbon', 'user_id' => $user->id]);
        }
        foreach ($cc as $nom) {
            $user = App\User::create(['username' => $nom, 'password' => bcrypt($nom), 'role' => 'user']);
            $c = App\Centrale::create(['nom' => $nom, 'type' => 'Cycle Combine', 'user_id' => $user->id]);
        }
        foreach ($solaires as $nom) {
            $user = App\User::create(['username' => $nom, 'password' => bcrypt($nom), 'role' => 'user']);
            $c = App\Centrale::create(['nom' => $nom, 'type' => 'Solaire', 'user_id' => $user->id]);
        }
        foreach ($eoliens as $nom) {
            $user = App\User::create(['username' => $nom, 'password' => bcrypt($nom), 'role' => 'user']);
            $c = App\Centrale::create(['nom' => $nom, 'type' => 'Eolien', 'user_id' => $user->id]);
        }
        foreach ($tag as $nom) {
            $user = App\User::create(['username' => $nom, 'password' => bcrypt($nom), 'role' => 'user']);
            $c = App\Centrale::create(['nom' => $nom, 'type' => 'Turbine a gaz', 'user_id' => $user->id]);
        }
//        App\User::create(['username' => 'CTJ', 'password' => bcrypt('CTJ'), 'role' => 'user']);
//        App\Centrale::create(['nom' => 'CTJ', 'type' => 'Thermique a charbon', 'user_id' => '2']);

    }
}
