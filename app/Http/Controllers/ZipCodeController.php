<?php

namespace App\Http\Controllers;

use App\Http\Requests\ZipCodeRequest;
use App\Models\ZipCodes;
use Exception;
use Illuminate\Http\Request;
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
                $data = ZipCodes::where('d_codigo', '=', trim($code))->get();
                $statusCode = (count($data) > 0) ? config("constants.HTTP_STATUS_OK") : config("constants.HTTP_STATUS_NOT_FOUND");
                foreach ($data as $row) {
                    $response[] = [
                        trans('messages.zip_code')  => $row->d_codigo,
                        trans('messages.settlement') => $row->d_asenta,
                        trans('messages.municipality') => $row->D_mnpio,
                        trans('messages.city') => $row->d_ciudad,
                        trans('messages.state') => $row->d_estado,
                        trans('messages.zone') => $row->d_zona,
                        trans('messages.status_key') => $row->c_estado
                    ];
                }
            }
            return response()->json($response, $statusCode);
        } catch (Exception $exception) {
            Log::info('incidence=>' . $exception->getLine() . "|" . $exception->getMessage());
            return response()->json([
                'status' => config("constants.HTTP_STATUS_INTERNAL_SERVER_ERROR"),
                'message' => trans('messages.incidence')
            ]);
        }
    }
}
