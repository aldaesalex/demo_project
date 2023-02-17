<?php

namespace App\Http\Controllers;

use App\Http\Requests\ZipCodeRequest;
use App\Models\ZipCodes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ZipCodeController extends Controller
{

    public function search(ZipCodeRequest $request, $code)
    {
        try {
            $response = [];
            $statusCode  = config("constants.HTTP_STATUS_INTERNAL_SERVER_ERROR");
            $requestValid =  $request->validated();
            if (count($requestValid) == 0) {
                $data = ZipCodes::select(
                    'd_codigo',
                    'd_ciudad',
                    'c_estado',
                    'd_estado',
                    'id_asenta_cpcons',
                    'd_asenta',
                    DB::RAW('UPPER(d_zona) as d_zona'),
                    'd_tipo_asenta',
                    'c_mnpio',
                    'd_mnpio'
                )
                    ->where('d_codigo', '=', trim($code))->get();
                $statusCode = (count($data) > 0) ? config("constants.HTTP_STATUS_OK") : config("constants.HTTP_STATUS_NOT_FOUND");
                if (count($data) > 0) {
                    $entity=[trans('messages.key')=> ($data[0]->c_estado!=null) ? intval($data[0]->c_estado) : null,
                        trans('messages.name')=> ($data[0]->d_estado!=null) ?  mb_strtoupper($data[0]->d_estado) : null,
                        trans('messages.code')=>null];
                }
                $settlements=[];
                foreach ($data as $row) {
                    $settlements[] = [
                        trans('messages.key') => ($row->id_asenta_cpcons!=null) ? intval($row->id_asenta_cpcons) : null,
                        trans('messages.name') => ($row->d_asenta!=null) ? mb_strtoupper($row->d_asenta) : null,
                        trans('messages.zone_type') => (($row->d_zona!=null) ? $row->d_zona : null),
                        trans('messages.settlement_type') => [trans('messages.name') => $row->d_tipo_asenta],
                    ];
                }
                $root = [trans('messages.zip_code')=>trim(str_pad($code,5,'0',STR_PAD_LEFT)),
                trans('messages.locality')=> ($data[0]->d_ciudad!=null) ? mb_strtoupper($data[0]->d_ciudad) : "",
                trans('messages.federal_entity')=>$entity,
                trans('messages.settlements')=>$settlements,
                trans('messages.municipality') => [trans('messages.key') => (($row->c_mnpio!=null) ? intval($row->c_mnpio) : null),
                trans('messages.name') => (($row->d_mnpio!=null) ? mb_strtoupper($row->d_mnpio) : null)]
            ];

            }
            return response()->json($root, $statusCode);
        } catch (Exception $exception) {
            Log::info('incidence=>' . $exception->getLine() . "|" . $exception->getMessage());
            return response()->json([
                'status' => config("constants.HTTP_STATUS_INTERNAL_SERVER_ERROR"),
                'message' => trans('messages.incidence')
            ]);
        }
    }
}
