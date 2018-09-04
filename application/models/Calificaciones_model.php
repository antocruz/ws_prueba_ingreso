<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calificaciones_model extends CI_Model {
  private $data;

  function __construct()
  {
    parent::__construct();
  }

  function getCalificacionBy($condiciones) {
    $this->db->select('c.id_t_calificaciones, a.id_t_usuarios,a.nombre,a.ap_paterno, a.ap_materno, m.nombre as materia, c.calificacion,c.fecha_registro')
              ->from('t_calificaciones as c')
              ->join('t_alumnos as a', 'c.id_t_usuarios=a.id_t_usuarios')
              ->join('t_materias as m', 'c.id_t_materias=m.id_t_materias')
              ->where($condiciones);
    $query = $this->db->get();
    return $query->result();
  }

  function postCalificaciones($datosAlumno) {
     if (is_array($datosAlumno) && !empty($datosAlumno)){
          return $this->db->insert('t_calificaciones', $datosAlumno);
      }
      return false;
  }

  function getCalificaciones($idAlumno) {
    $this->db->select('a.id_t_usuarios,a.nombre,a.ap_paterno, a.ap_materno, m.nombre as materia, c.calificacion,c.fecha_registro')
              ->from('t_calificaciones as c')
              ->join('t_alumnos as a', 'c.id_t_usuarios=a.id_t_usuarios')
              ->join('t_materias as m', 'c.id_t_materias=m.id_t_materias')
              ->where('c.id_t_usuarios', $idAlumno);
    $query = $this->db->get();
    return $query->result();
  }

  function putCalificaciones($idAlumno, $idMateria, $datosAlumno) {
    if ($idAlumno > 0 && $idMateria > 0  && is_array($datosAlumno)){
            $this->db->where('id_t_usuarios', $idAlumno)
                     ->where('id_t_materias', $idMateria);
            return $this->db->update('t_calificaciones', $datosAlumno);
            print_r($this->db->last_query());        
        }
        return false;
  }

  function deleteCalificaciones($idCalificacion) {
    $this->db->where('id_t_calificaciones', $idCalificacion);
        return $this->db->delete('t_calificaciones');
  }
      
}
