<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utils {
   private $clave  = 'hVIJyHLgu63tLNPdYcXR0K5zTkFmGY12GNRdcNiF';
  //valida peticion
  public function valReq($hash,$msj){
   $validoHash = hash('sha256', $msj.$this->clave);
   if ($validoHash == $hash) {
     return true;
   }else{
     return false;
   }
  }
  public function genHash($msj){
    $validoHashResponse = hash('sha256', $msj.$this->clave);
    return $validoHashResponse;
  }
}
