<?php
use App\Repositories\Carts;

if(! function_exists('idFormat')){
    function idFormat($nominal){
        $value = "Rp." .number_format($nominal, 0 , ',' , ',' );
        return $value;
    }
}

if (!function_exists('getCountCart')){
    function getCountCart(){
        return Carts::countAllBySession();
    }
}

if (!function_exists('getCodeTransaction')){
    function getCodeTransaction(){
        return "USM-TRX-".time();
    }
}

if (!function_exists('getCustSessions')){
    function getCustSessions(){
        return Session::get('customers');
    }
}

if (!function_exists('getCustSession')){
    function storeCustSession($customers){
        $session = new stdClass();
        $session->id = $customers->id;
        $session->name = $customers->name;
        $session->email = $customers->email;

        session(['customers'=> $session]);
    }
}
