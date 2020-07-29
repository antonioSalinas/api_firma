<?php

namespace App\Http\Controllers;

use \Firebase\JWT\JWT;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use File;



class FirmaController extends Controller
{
   
    public function getFirma(Request $request)
    {
        $idFile=date('Ymdhis');
        $req=json_decode($request->getContent());
        $file = $request->file('archivo');
        $request->file('archivo')->store('local');
        $nombre = $file->getClientOriginalName();
       // echo($nombre);
        Storage::disk('local')->put($idFile.'archivo.pdf',file_get_contents($file));
        $file=Storage::disk('local')->get($idFile.'archivo.pdf');
        $layout=Storage::disk('local')->get('layout.txt');
        $firma=Storage::disk('local')->get('firma.jpg');
        $layout = str_replace('archivo64',base64_encode($firma),$layout);
        $minutos= date('i')+5;
        $fileToSend=array(
            "content-type"  => ("application/pdf"),
            "content"       => base64_encode($file),
            "description"   => "descripcion testing",
            "checksum"      => (hash('sha256',$file)),
            //"layout"        => ($layout)
        );
        $key = "abcd";
    
        $payload = array(
                "purpose" => "Desatendido",
                "entity" => "Subsecretaría General de La Presidencia",
                "expiration" => date('Y-m-d').'T'.date('H').':'.$minutos.':'.date('s'),
                "run" => "22222222"
                );
         $jwt = JWT::encode($payload, $key);
         $jsonToSend= array(
             "api_token_key" => "sandbox",
             "token"         => $jwt,
             "files"         => array($fileToSend)
         );        
         
         $decoded = JWT::decode($jwt, $key, array('HS256'));
        $body=collect();
        $body=json_encode($jsonToSend);
        try{
            //habilitar esta librería
        //     $client= new Client();
        //     $res = $client->post('https://api.firma.test.digital.gob.cl/firma/v2/files/tickets', [
        //    // $res = $client->post('http://localhost/api_firma/public/showPost', [
                
        //         'headers'=>[             
        //             'cache-control' => 'no-cache',
        //             'content-type' => 'application/json' ,
        //             'Request-Timeout'    => "5000",
        //             'Keep-Alive' => '10000',
        //             'Accept-Encoding' => 'gzip'
                          
        //         ],
        //          'body'=>$body
        //     ]);
        //    var_dump($res);
           
       $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.firma.test.digital.gob.cl/firma/v2/files/tickets",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>$body,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
              ),
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);
            //echo $response;

        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }
        $res=json_decode($response);
        $firmado=$res->files[0]->content;
        
        Storage::disk('local')->put($idFile."firmado.pdf",base64_decode($firmado));
       
        return Storage::download($idFile."firmado.pdf",$idFile."firmado.pdf",["content-type" => "application/pdf"]);
    }
    function testFirma(){

        return view('testing');
    }
    
}