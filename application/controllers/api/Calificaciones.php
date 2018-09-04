<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * controlador de Calificaciones
 * @author Antonio Cruz Arias
 * @uses calificaciones
 * @package calificaciones
 * @copyright Copyright (c) 2018, Antonio Cruz Arias
*/
require APPPATH . '/libraries/REST_Controller.php';

class Calificaciones extends REST_Controller {
   private $data;
   // TODO:Esta clave se enviara para validar que es el sistema de calificaciones el que esta realizando la peticion al webservice
   //private $claveSistema = "SwEmLMQxyjWHPrfEffZi";

   public function __construct() {
      parent::__construct();
      //Codeigniter : Write Less Do More
      // Configure limits on our controller methods
      // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
      $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
      $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
      $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
      $this->load->model('calificaciones_model');
      $this->load->library('utils');
   }
   /**
    * función qu permite guardar una calificacion
    * @param hash (token de validacion)
    * @param idSistema (clave de sistema que consume el ws)
    * @param datos (json con los datos a guardar)
    * @uses calificaciones_model::getCalificacionBy
    * @uses calificaciones_model::postCalificaciones
    * @return Salida Json con respuesta: estatus,mensaje y hash 
    */
   public function cCalificaciones_post(){
      $hash    = (string)$this->post('hash');
      $claveSistema  = (string)$this->post('idSistema');
      $data = (string)$this->post('datos');

      if ($this->utils->valReq($hash,$claveSistema.$data)) {
         $datos = json_decode($data);
         if (!empty($datos)) {
            $datosAlumno = array('id_t_usuarios'=> $datos->id_t_usuarios,
                              'id_t_materias'=>$datos->id_t_materias,
                              'calificacion' => $datos->calificacion,
                              'fecha_registro' => date('Y-m-d')
                             );
            $buscaCalificacion = $this->calificaciones_model->getCalificacionBy(array('c.id_t_materias' => $datos->id_t_materias));
            if (empty($buscaCalificacion)) {
               $idCalificacion = $this->calificaciones_model->postCalificaciones($datosAlumno);
               if ($idCalificacion>0) {
                  $validoHashResponse  =  $this->utils->genHash($idCalificacion.'0'.'OK');
                  $datosAlumno = [
                     'success' => 'ok',
                     'msg' => 'calificacion registrada',
                     'hash' => $validoHashResponse
                  ];
                  $this->response($datosAlumno, 200); // OK (200) being the HTTP response code
               }else {
                  // Set the response and exit
                  $this->response([
                     'success' => 'error',
                     'msg' => 'datos no encontrados'
                  ], 204); // The server successfully processed the request, though no content is returned
               }
            }else{
               // Set the response and exit
               $this->response([
                  'success' => 'error',
                  'msg' => 'La materia ya tiene registro'
               ], 204); // The server successfully processed the request, though no content is returned
            }      
         }else {
            // Set the response and exit
            $this->response([
               'success' => 'error',
               'msg' => 'datos no encontrados'
            ], 204); // The server successfully processed the request, though no content is returned
         }
      }else{
         $this->response([
           'success' => 'error',
           'msg' => 'Acceso Denegado'
         ],401);//The user is unauthorized to access the requested resource
      }
   }

   /**
    * función qu permite guardar una calificacion
    * @param hash (token de validacion)
    * @param idSistema (clave de sistema que consume el ws)
    * @param idAlumno (id del alumno a buscar calificaciones)
    * @uses calificaciones_model::getCalificaciones
    * @return Salida Json con respuesta: estatus,mensaje y hash 
    */
   public function rCalificaciones_get() {
      $hash    = (string)$this->get('hash');
      $stringClaveSistema  = (string)$this->get('idSistema');
      $intIdAlumno = (int)$this->get('idAlumno');
      $sum = 0.0;
      $count = 0;
      $promedio = 0.0;
      //validaciones
      if ($this->utils->valReq($hash,$stringClaveSistema.$intIdAlumno)) {
         $calificaciones = $this->calificaciones_model->getCalificaciones($intIdAlumno);
         $count = count($calificaciones);
         if (!empty($calificaciones)) {
            foreach ($calificaciones as $key => $v) {
               $sum =  $sum + $v->calificacion;
               $datos[] = array('id_t_usuarios' => $v->id_t_usuarios,
                                  'nombre' => $v->nombre,
                                  'apellido' => $v->ap_paterno,
                                  'materia' => $v->materia,
                                  'calificacion' => $v->calificacion,
                                  'fecha_registro'=> $v->fecha_registro
                                  );
            }
            $promedio = $sum/$count;
            $data = $datos;
            $data['promedio'] = $promedio;

            $primCadena = json_encode($data[0]);
            $validoHashResponse  =  $this->utils->genHash($primCadena.'0'.'OK');
            $calificaciones = [
               'success' => "ok",
               'msg' => 'datos encontrados',
               'hash' => $validoHashResponse,
               'data' =>$data
            ];
            $this->response($calificaciones, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
         }else {
            // Set the response and exit
            $this->response([
               'success' => 2,
               'message' => 'datos no encontrados'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
         }
      }else{
         $this->response([
            'success' => 1,
            'msj' => 'Acceso Denegado'
         ],500);
      }
   }
   /**
    * función qu permite guardar una calificacion
    * @param hash (token de validacion)
    * @param idSistema (clave de sistema que consume el ws)
    * @param idAlumno (id del alumno a buscar calificaciones)
    * @uses calificaciones_model::getCalificaciones
    * @return Salida con respuesta: type response 
    */
   public function rCalificacionesHtml_get() {
      $hash    = (string) $this->get('hash');
      $stringClaveSistema  = (string)$this->get('idSistema');
      $intIdAlumno = (int)$this->get('idAlumno');
      $sum = 0.0;
      $count = 0;
      $promedio = 0.0;
      //validaciones
      if ($this->utils->valReq($hash,$stringClaveSistema.$intIdAlumno)) {
         $calificaciones = $this->calificaciones_model->getCalificaciones($intIdAlumno);
         $count = count($calificaciones);
         if (!empty($calificaciones)) {
            foreach ($calificaciones as $k => $value) {
               $datos[] = ['id_t_usuarios'=>$value->id_t_usuarios, 'nombre'=>$value->nombre, 'apellido'=>$value->ap_paterno, 'materia'=>$value->materia, 'calificacion'=>$value->calificacion, 'fecha_registro'=>$value->fecha_registro];
            }
         
            $promedio = $sum/$count;
            $data = $datos;
            $data['promedio'] = $promedio;
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
         }else {
            // Set the response and exit
            $this->response([
               'success' => 2,
               'message' => 'datos no encontrados'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
         }
      }else{
         $this->response([
            'success' => 1,
            'msj' => 'Acceso Denegado'
         ],500);
      }
   }

   /**
    * función qu permite editar una calificacion
    * @param hash (token de validacion)
    * @param idSistema (clave de sistema que consume el ws)
    * @param datos (json con los datos a guardar)
    * @uses calificaciones_model::getCalificaciones
    * @return Salida Json con respuesta: estatus,mensaje y hash 
    */
   public function uCalificaciones_put(){
      $hash    = (string)$this->put('hash');
      $claveSistema  = (string)$this->put('idSistema');
      $data = (string)$this->put('datos');
      
      if ($this->utils->valReq($hash,$claveSistema.$data)) {
         $datos = json_decode($data);
         if (!empty($datos)) {
              $datosAlumno = array('calificacion' => $datos->calificacion,
                              'fecha_registro' => date('Y-m-d')
                             );

               $buscaCalificacion = $this->calificaciones_model->putCalificaciones($datos->id_t_usuarios, $datos->id_t_materias, $datosAlumno);
               if (!empty($buscaCalificacion)) {
                  $validoHashResponse  =  $this->utils->genHash($buscaCalificacion.'0'.'OK');
                  $datosAlumno = [
                     'success' => 'ok',
                     'msg' => 'calificacion Actualizada',
                     'hash' => $validoHashResponse
                  ];
                  $this->response($datosAlumno, 200); // OK (200) being the HTTP response code
               }else {
                  // Set the response and exit
                  $this->response([
                     'success' => 'error',
                     'msg' => 'datos no encontrados'
                  ], 204); // The server successfully processed the request, though no content is returned
              }
         }else {
            // Set the response and exit
            $this->response([
               'success' => 'error',
               'msg' => 'datos no encontrados'
            ], 204); // The server successfully processed the request, though no content is returned
        }
      }else{
         $this->response([
           'success' => 'error',
           'msg' => 'Acceso Denegado'
         ],401);//The user is unauthorized to access the requested resource
      }
   }

   /**
    * función qu permite eliminar una calificacion
    * @param hash (token de validacion)
    * @param idSistema (clave de sistema que consume el ws)
    * @param datos (json con los datos a guardar)
    * @uses calificaciones_model::getCalificaciones
    * @return Salida Json con respuesta: estatus,mensaje y hash 
    */
   public function dCalificaciones_delete(){
      $hash    = $this->delete('hash');
      $claveSistema  =(string) $this->delete('idsistema');
      $idCalificacion = (int)$this->delete('idCalificacion');
      
      if ($this->utils->valReq($hash,$claveSistema.$idCalificacion)) {
         $buscaCalificacion = $this->calificaciones_model->getCalificacionBy(array('id_t_calificaciones'=>$idCalificacion));
         if (!empty($buscaCalificacion)) {
            $idCalificacion = $this->calificaciones_model->deleteCalificaciones($idCalificacion);
            if ($idCalificacion>0) {
               $validoHashResponse  =  $this->utils->genHash($idCalificacion.'0'.'OK');
               $datosAlumno = [
                  'success' => 'ok',
                  'msg' => 'calificacion eliminada',
                  'hash' => $validoHashResponse
               ];
               $this->response($datosAlumno, 200); // OK (200) being the HTTP response code
            }else{
               // Set the response and exit
               $this->response([
                  'success' => 'error',
                  'msg' => 'datos no encontrados'
               ], 204); // The server successfully processed the request, though no content is returned
            }
         }else {
            // Set the response and exit
            $this->response([
               'success' => 'error',
               'msg' => 'datos no encontrados'
            ], 204); // The server successfully processed the request, though no content is returned
        }
      }else{
         $this->response([
           'success' => 'error',
           'msg' => 'Acceso Denegado'
         ],401);//The user is unauthorized to access the requested resource
      }
   }
}
