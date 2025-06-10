<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WhatsAppValidationController extends Controller
{
    public function check(Request $request)
    {
        if ($request->input('action') === 'check_whatsapp' && $request->has('whatsapp_number')) {
            $whatsapp_number = $request->input('whatsapp_number');

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://whatsapp-number-validator3.p.rapidapi.com/WhatsappNumberHasItBulkWithToken",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    'phone_numbers' => [$whatsapp_number]
                ]),
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "x-rapidapi-host: whatsapp-number-validator3.p.rapidapi.com",
                    "x-rapidapi-key: c36fdc5c72msh33221350d083c0cp17419djsn13704ba9c869"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                return response()->json(['error' => 'cURL Error #:' . $err], 500);
            } else {
                // Parse the response to check if it's valid JSON
                $decoded = json_decode($response);
                if (json_last_error() === JSON_ERROR_NONE) {
                    // If it's valid JSON, return it directly
                    return response()->json($decoded);
                } else {
                    // If not valid JSON, return as plain text
                    return response($response);
                }
            }
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }
}