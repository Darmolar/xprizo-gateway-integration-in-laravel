<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    //
    public $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjU4MjkiLCJ1c2VyTmFtZSI6InN0ZXBoYW5pZTEiLCJyb2xlIjoiQWdlbnQiLCJyb2xlTmFtZSI6IkFnZW50IiwiYWNjZXNzIjoie1wiNTg0MVwiOjJ9IiwiaGFzaCI6IjEwMi44OS40NC42IiwiZXhwIjoxNjk0NzA1NzE3LCJpc3MiOiJ4cHJpem8uY29tIiwiYXVkIjoieHByaXpvLmNvbSJ9.KUomAEzjkroTC9CHrU8L2FhL6VIvvgrgVwp_UrpACNE";

    public function home(){
        return view('home');
    }
    
    public function requestFund(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'requestAmount' => 'required|gt:0', 
                'requestCurrency' => 'required',  
            ]);
            if ($validator->fails()) { 
                return response()->json(['status' => 0, 'msg' => $validator->errors()->first(), 'data' => $validator->errors()], 403);
            }

            $data = [ 
                "name" => "New Stephinie",
                "accountId" => 1542,
                "description" => "lol",
                "reference" => uniqid(), 
                "amount" => $request->requestAmount,
                "currencyCode"  => $request->requestCurrency,
            ]; 

            $url = 'https://xprizo.azurewebsites.net/api/';
            $route = 'Merchant/RequestPaymentRedirect';
            $response_data = Http::withHeaders([ 
                'Authorization' => "Bearer ".$this->token
            ])->post($url . $route, $data);
            
            $res_body = json_decode($response_data->body());
            if ($response_data->successful()) {  

                session($data);
                return response()->json(['status' => 1, 'msg' => $request['res_msg'], 'data' => $res_body ]);
            } else { 
                return response()->json(['status' => 0, 'msg' => $res_body , 'data' => $response_data->body(), 'new' => $data ]);
            }

        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function listenForWebhookPayment(Request $request){
        try {
            $reference = session('reference');
            if($request->statusType === 2 && $request->status === 'Accepted'){
                if($reference === $request->transaction->reference){
                    return response()->json(['status' => 0, 'msg' => 'Transaction successful', 'data' => $request->transaction ], 200);
                }
            }else{
                return response()->json(['status' => 0, 'msg' => 'Transaction not successful' ], 403);
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
    
}