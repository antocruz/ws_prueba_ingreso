<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Prueba de ingreso a PagoFácil.net WEBSERVICE CALIFICACIONES</title>
    <style>
        ::selection { background-color: #E13300; color: white; }
        ::-moz-selection { background-color: #E13300; color: white; }
        body {
            background-color: #FFF;
            margin: 40px;
            font: 16px/20px normal Helvetica, Arial, sans-serif;
            color: #4F5155;
            word-wrap: break-word;
        }
        a {
            color: #039;
            background-color: transparent;
            font-weight: normal;
        }
        h1 {
            color: #444;
            background-color: transparent;
            border-bottom: 1px solid #D0D0D0;
            font-size: 24px;
            font-weight: normal;
            margin: 0 0 14px 0;
            padding: 14px 15px 10px 15px;
        }
        code {
            font-family: Consolas, Monaco, Courier New, Courier, monospace;
            font-size: 16px;
            background-color: #f9f9f9;
            border: 1px solid #D0D0D0;
            color: #002166;
            display: block;
            margin: 14px 0 14px 0;
            padding: 12px 10px 12px 10px;
        }
        #body {
            margin: 0 15px 0 15px;
        }
        p.footer {
            text-align: right;
            font-size: 16px;
            border-top: 1px solid #D0D0D0;
            line-height: 32px;
            padding: 0 10px 0 10px;
            margin: 20px 0 0 0;
        }
        #container {
            margin: 10px;
            border: 1px solid #D0D0D0;
            box-shadow: 0 0 8px #D0D0D0;
        }
    </style>
</head>
<body>

<div id="container">
    <h1><b>API WEBSERVICE CALIFICACIONES</b></h1>
    <div id="body">
        <h2><a href="<?php echo site_url(); ?>">Metodos</a></h2>
        <p></p>
        <p><strong>Usuario API: 8769izhknder, Password API: fr05tbyt3knr</strong></p>
        <p>Haga clic en los enlaces para verificar si el servidor REST está funcionando.</p>

        <p><strong>El has se conforma de la siguiente manera:  idSistema + parametro(s) enviado(s) + claveWebservice = hash</strong></p>
        <p><strong>Ejemplo: SwEmLMQxyjWHPrfEffZi + 1 + hVIJyHLgu63tLNPdYcXR0K5zTkFmGY12GNRdcNiF = FF92A8FA4B2441D786E7251A025326A5256B6ADA411BC3BBF297FF539C158B94 </strong></p>
        
        <h3>1. Acción POST: El webservice debera de dar de alta una calificación para el alumno en la tabla de t_calificaciones. Si la alta es exitosa el servicio web debera responder en formato json Ejemplo:</h3>
        <code><pre>
            Request
            {
                "hash":"bf238dcd7ec1e42aee0846c19de92867156fa203451e1a9a1789c84db0c07d3e",
                "idSistema" : "SwEmLMQxyjWHPrfEffZi",
                "datos":"{"id_t_usuarios":1,"id_t_materias":1,"calificacion":10}"
            } 

            Response
            {
                "success":"ok",
                "msg":"calificacion registrada",
                "hash":"97fe66abb3b610732f189f85ed620f7bd0623b4ce86b19dc27459784662ddf11"
            }
        </pre></code>
        <ol><h2>Servicio para recibir el alta de Calificaciones </h2>
            <li><span href="#">Calificaciones POST URL: <strong>http://127.0.0.1/ws_prueba_ingreso/index.php/api/Calificaciones/cCalificaciones</strong></span> - obtenerlo en JSON</li>
        </ol>

        <h3>2. Acción GET: El webservice debera de recibir la variable de id del alumno y debera devolver el listado de las calificaciones en en formato json, adicional tendra que enviar el promedio de las calificaciones del alumno. Ejemplo:</h3>
        <code><pre>
            Request
            {
                "hash":"ff92a8fa4b2441d786e7251a025326a5256b6ada411bc3bbf297ff539c158b94",
                "idSistema" : "SwEmLMQxyjWHPrfEffZi",
                "idAlumno":1
            } 

            Response
            [
                {
                    "success": "ok",
                    "msg": "datos encontrados",
                    "hash": "caeab8dea0da156b17d6e4a12d2555706d0d854a7d5308f02371fda63356a65f",
                    "data": {
                        "0": {
                            "id_t_usuarios": "1",
                            "nombre": "John",
                            "apellido": "Dow",
                            "materia": "matematicas",
                            "calificacion": "10.00",
                            "fecha_registro": "2018-09-04"
                        },
                        "1": {
                            "id_t_usuarios": "1",
                            "nombre": "John",
                            "apellido": "Dow",
                            "materia": "programacion I",
                            "calificacion": "8.00",
                            "fecha_registro": "2018-09-03"
                        },
                        "2": {
                            "id_t_usuarios": "1",
                            "nombre": "John",
                            "apellido": "Dow",
                            "materia": "ingenieria de sofware",
                            "calificacion": "10.00",
                            "fecha_registro": "2018-09-04"
                        },
                        "promedio": 9.3333333333333
                    }
                }
            ]
        </pre></code>
        <ol><h2>Servicio para recibir los registros de Calificaciones </h2>
            <li><a href="<?php echo site_url('api/Calificaciones/rCalificaciones/hash/ff92a8fa4b2441d786e7251a025326a5256b6ada411bc3bbf297ff539c158b94/idSistema/SwEmLMQxyjWHPrfEffZi/idAlumno/1'); ?>">Calificaciones GET</a> - obtenerlo en JSON</li>
            <li><a href="<?php echo site_url('api/Calificaciones/rCalificacionesHtml/hash/ff92a8fa4b2441d786e7251a025326a5256b6ada411bc3bbf297ff539c158b94/idSistema/SwEmLMQxyjWHPrfEffZi/idAlumno/1'); ?>">Calificaciones GET</a> - obtenerlo en JSON SIN STATUS</li>
            <li><a id="ajax" href="<?php echo site_url('api/Calificaciones/rCalificaciones/hash/ff92a8fa4b2441d786e7251a025326a5256b6ada411bc3bbf297ff539c158b94/idSistema/SwEmLMQxyjWHPrfEffZi/idAlumno/1/format/json'); ?>">Calificaciones GET</a> - obtenerlo en JSON (AJAX request)</li>
            <li><a href="<?php echo site_url('api/Calificaciones/rCalificaciones/hash/ff92a8fa4b2441d786e7251a025326a5256b6ada411bc3bbf297ff539c158b94/idSistema/SwEmLMQxyjWHPrfEffZi/idAlumno/1/format/xml'); ?>">Calificaciones GET</a> - obtenerlo en in XML (api/Calificaciones/rCalificaciones//format/xml)</li>
            <li><a href="<?php echo site_url('api/Calificaciones/rCalificacionesHtml/hash/ff92a8fa4b2441d786e7251a025326a5256b6ada411bc3bbf297ff539c158b94/idSistema/SwEmLMQxyjWHPrfEffZi/idAlumno/1/format/xml'); ?>">Calificaciones GET</a> - obtenerlo en in XML (api/Calificaciones/rCalificacionesHtml//format/xml) SIN STATUS</li> 
            <li><a href="<?php echo site_url('api/Calificaciones/rCalificacionesHtml/hash/ff92a8fa4b2441d786e7251a025326a5256b6ada411bc3bbf297ff539c158b94/idSistema/SwEmLMQxyjWHPrfEffZi/idAlumno/1/format/html'); ?>">Calificaciones GET</a> - obtenerlo en HTML (api/Calificaciones/rCalificacionesHtml/format/html)</li>
            <li><a href="<?php echo site_url('api/Calificaciones/rCalificacionesHtml/hash/ff92a8fa4b2441d786e7251a025326a5256b6ada411bc3bbf297ff539c158b94/idSistema/SwEmLMQxyjWHPrfEffZi/idAlumno/1/format/csv'); ?>">Calificaciones GET</a> - obtenerlo en CSV  (api/Calificaciones/rCalificacionesHtml/format/CSV)</li>
        </ol>

        <h3>3. Accion PUT: Actualizar una calificación de la tabla de t_calificaciones Si la alta es exitosa el servicio web debera responder en formato json Ejemplo:</h3>
        <code><pre>
            Request
            {
                "hash":"483601c788c4eb6deec6f8a5815af9f8732a56021f896ed282b29780fd82c5c1",
                "idSistema":"SwEmLMQxyjWHPrfEffZi",
                "datos":"{"id_t_usuarios":1,"id_t_materias":1,"calificacion":5}"
            } 

            Response
            { 
                "success":"ok",
                "msg":"calificacion Actualizada",
                "hash":"97fe66abb3b610732f189f85ed620f7bd0623b4ce86b19dc27459784662ddf11"
            }
        </pre></code>
        <ol><h2>Servicio para recibir la actualizacion de Calificaciones </h2>
            <li><span>Calificaciones PUT URL: <strong>http://127.0.0.1/ws_prueba_ingreso/index.php/api/Calificaciones/uCalificaciones</strong></span> - obtenerlo en JSON</li>
        </ol>

        <h3>4 Actualizar una calificación de la tabla de t_calificaciones Si la alta es exitosa el servicio web debera responder en formato json Ejemplo:</h3>
        <code><pre>
            Request
            {
                "hash":"c0c0190548927cd21fb1c613ce4995ccfc3b54fcb0da8eb163925be10dd50862",
                "idSistema" : "SwEmLMQxyjWHPrfEffZi",
                "idCalificacion":1
            } 

            Response
            {
                "success":"ok",
                "msg":"calificacion eliminada",
                "hash":"97fe66abb3b610732f189f85ed620f7bd0623b4ce86b19dc27459784662ddf11"
            } 
        </pre></code>
        <ol><h2>Servicio para recibir la baja de Calificaciones </h2>
            <li><span>Calificaciones DELETE URL: <strong>http://127.0.0.1/ws_prueba_ingreso/index.php/api/Calificaciones/dCalificaciones<strong></span> - obtenerlo en JSON</li>
        </ol>
    </div>

    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>'.CI_VERSION.'</strong>' : '' ?></p>
</div>

<script src="https://code.jquery.com/jquery-1.12.0.js"></script>

<script>
    // Create an 'App' namespace
    var App = App || {};

    // Basic rest module using an IIFE as a way of enclosing private variables
    App.rest = (function restModule(window) {
        // Fields
        var _alert = window.alert;
        var _JSON = window.JSON;

        // Cache the jQuery selector
        var _$ajax = null;

        // Cache the jQuery object
        var $ = null;

        // Methods (private)

        /**
         * Called on Ajax done
         *
         * @return {undefined}
         */
        function _ajaxDone(data) {
            // The 'data' parameter is an array of objects that can be iterated over
            _alert(_JSON.stringify(data, null, 2));
        }

        /**
         * Called on Ajax fail
         *
         * @return {undefined}
         */
        function _ajaxFail() {
            _alert('Oh no! un problema con Ajax request!');
        }

        /**
         * On Ajax request
         *
         * @param {jQuery} $element Current element selected
         * @return {undefined}
         */
        function _ajaxEvent($element) {
            $.ajax({
                    // URL from the link that was 'clicked' on
                    url: $element.attr('href')
                })
                .done(_ajaxDone)
                .fail(_ajaxFail);
        }

        /**
         * Bind events
         *
         * @return {undefined}
         */
        function _bindEvents() {
            // Namespace the 'click' event
            _$ajax.on('click.app.rest.module', function (event) {
                event.preventDefault();

                // Pass this to the Ajax event function
                _ajaxEvent($(this));
            });
        }

        /**
         * Cache the DOM node(s)
         *
         * @return {undefined}
         */
        function _cacheDom() {
            _$ajax = $('#ajax');
        }

        // Public API
        return {
            /**
             * Initialise the following module
             *
             * @param {object} jQuery Reference to jQuery
             * @return {undefined}
             */
            init: function init(jQuery) {
                $ = jQuery;

                // Cache the DOM and bind event(s)
                _cacheDom();
                _bindEvents();
            }
        };
    }(window));

    // DOM ready event
    $(function domReady($) {
        // Initialise the App module
        App.rest.init($);
    });
</script>

</body>
</html>
