<?php
namespace Database\Seeders;

use App\Models\ZipCodes;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ZipCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ZipCodes::truncate();
        $row ='';
        try{
            Log::info("iniciando importacion");
            $txtData = fopen(base_path('database/txt/CPdescarga.txt'), 'r');
            while( !feof($txtData)){
                $row = fgets($txtData, 2048);
                $data = explode("|",$row);
                    ZipCodes::create([
                        'd_codigo' => $data['0'],
                        'd_asenta' => $data['1'],
                        'd_tipo_asenta' => $data['2'],
                        'D_mnpio' => $data['3'],
                        'd_estado' =>  $data['4'],
                        'd_ciudad' => $data['5'],
                        'd_CP' => $data['6'],
                        'c_estado' => $data['7'],
                        'c_oficina' => $data['8'],
                        'c_CP' => $data['9'],
                        'c_tipo_asenta' => $data['10'],
                        'c_mnpio' => $data['11'],
                        'id_asenta_cpcons' => $data['12'],
                        'd_zona' => $data['13'],
                        'c_cve_ciudad' => $data['14']
                    ]);
            }
            fclose($txtData);
            Log::info('importacion completa');
        }catch(Exception $ex){
            Log::error($row);
            Log::error('incidencia=>'.$ex->getMessage().'|line=>'.$ex->getLine());
        }
    }
}
 