<?php
/**
 * Droppy - Online file sharing
 * Language
 * @lang Spanish
 * @author Alexandro
 */

defined('BASEPATH') OR exit('No direct script access allowed');

$lang = array(
    'share_files' 				=> "Compartir archivo(s)",
    'ok' 		   				=> "Ok",
    'close' 					=> "Cerrar",
    'files' 					=> "Archivos",
    'link' 						=> "Enlace",
    'email' 					=> "E-Mail",
    'success' 					=> "¡Correcto!",
    'password'        			=> "Contraseña",
    'message' 					=> "Mensaje",
    'download' 					=> "Descarga",
    'destruct' 					=> "Destruir",
    'select_files' 				=> "Seleccionar archivo(s)",
    'add_more' 					=> "Añadir más",
    'total_size' 				=> "Tamaño total",
    'total_files'				=> "Archivos totales",
    'download_id' 				=> "Id de descarga",
    'add_password' 				=> "Añadir contraseña",
    'upload_error' 				=> "¡Hubo un error al subirlo!",
    'wrong_pass' 				=> "¡Contraseña incorrrecta!",
    'enter_email' 				=> "Introduce email al que mandar el enlace",
    'enter_own_email' 			=> "Introduce tu email",
    'fill_fields' 				=> "¡Hay que rellenar todos los huecos!",
    'message_receiver' 			=> "Mensaje para el receptor",
    'download_started' 			=> "La descarga se ha iniciado...",
    'enable_destuct' 			=> "Activar autodestrucción",
    'file_too_large' 			=> "Algunos archivos son demasiado grandes.",
    'fill_password' 			=> "Por favor, introduce la contraseña aquí abajo",
    'download_started' 			=> "Procesando su descarga, por favor espera",
    'upload_not_found' 			=> "No se ha encontrado la descarga, ¿quizá se ha destruido?",
    'processing_files' 			=> "Procesando su archivo(s) y generando enlace, por favor, se paciente.",
    'success_link' 				=> "Su(s) archivo(s) se han subido, puedes usar el enlace que hay debajo.",
    'success_email' 			=> "Su(s) archivo(s) se han subido, le llegará un email en breve.",

    //Added in update 1.0.2
    'select_share'              => "Selecciona cómo compartirlo:",
    'file_blocked'              => "Este tipo de archivo(s) no están permitidos.",

    //Added in update 1.0.4
    'report_file'               => "Reportar archivo",
    'report_file_text'          => "¿Seguro que quieres reportar el archivo?",
    'report'                    => "Reportar",
    'max_files'                 => "Demasiados archivos seleccionados",

    //Added in update 1.0.7
    'yes'                       => "Sí",
    'no'                        => "No",
    'max'                       => "Max.",
    'upload_settings'           => "Ajustes de subidas",
    'change_language'           => "Cambiar idioma",
    'terms_service'             => "Términos del servicio",
    'about_us'                  => "Sobre mi",
    'protect_with_pass'         => "Proteger con contraseña",
    'destruct_file'             => "Destruir el archivo",
    'leave_empty_password'      => "Dejar en blanco para desactivar la contraseña",
    'share_type'                => "Forma de compartirlo",
    'share_type_text'           => "Puedes compartir el enlace por email así que los receptores recebirán un correo electrónico, o comparte un enlace con quien quieras donde quieras.",
    'destruct_text'             => "La subida se autodestruirá cuando todos los receptores hayan descargado los archivos.",
    'password_text'             => "Tu subida sólo puede descargarse introduciendo la contraseña.",
    'select_pref_lang'          => "Selecciona tu idioma preferido",
    'select_language'           => "Seleccionar idioma",
    'copy_url'                  => "Copiar URL",
    'sign_in'                   => "Iniciar sesión",
    'invalid_login'             => "Inicio de sesión incorrecto",
    'upload_processing'         => "Estamos procesando tu(s) archivo(s), por favor vuelve más tarde.",
    'not_allowed'               => "No estás autorizado para ver este archivo.",
    'invalid_pass'              => "Contraseña incorrecta",
    'msg_seconds'               => "Segundo(s)",
    'msg_minutes'               => "Minuto(s)",
    'msg_hours'                 => "Hora(s)",
    'msg_remaining'             => "restante",
    'remaining'                 => "restante",
    'save'                      => "Guardar",

    //Added in update 1.2
    'not_available_pass'        => "(Suscripción Premium requerida)",

    //Added in update 1.2.2
    'uploaded_of'               => "subido el",
    'cancel'                    => "Cancelar",
    'destructed_on'             => "Destruido el",
    'open'                      => "Abrir",
    'accept_terms'              => "Necesitas aceptar los términos del servicio para seguir al sitio.",
    'accept'                    => "Aceptar",

    //Added in update 1.2.3
    'view_terms'                => "Ver términos",

    //Added in update 1.2.6
    'month'                     => "mes",
    'week'                      => "semana",
    'day'                       => "día",
    'hour'                      => "hora",
    'months'                    => "meses",
    'weeks'                     => "semanas",
    'days'                      => "días",
    'hours'                     => "horas",

    //Added in update 1.2.7
    'drop_files_here'           => "Arrastra tus archivos aquí",

    //Added in update 1.4.6
    'are_you_sure'              => "¿Estás seguro?",

    // Added in update 2.0
    'login'                     => "Iniciar sesión",
    'user_login'                => "Inicio de sesión",

    // Added in update 2.0.3
    'logout'                    => "Logout",

    // Added in update 2.1.4
    'contact'                   => "Contact",
    'subject'                   => "Subject",
    'send'                      => "Send",
    'message_sent'              => "Your message has been sent !",

    // Added in update 2.1.5
    'contact_email_description'   => 'Your email address',
    'contact_subject_description' => 'Your subject',
    'contact_message_description' => 'Your message',
  
    // Added in update 2.1.6
    'invalid_email'               => "The entered email isn't a valid email address",

    // Added in update 2.2.6
    'add_more_files'              => 'Add more files',
    'email_to'                    => 'Email to',
    'email_from'                  => 'Email from',
    'how_to_share_file'           => 'How to share the file?',
    'send_using_email'            => 'Send using email',
    'get_sharable_link'           => 'Get a sharable link',
    'protect_upload_password'     => 'Protect the upload with a password',
    'when_file_expire'            => 'When should the file expire?',
    'upload'                      => 'Upload',
    'lets_begin_files'            => "Let's begin by adding some files",
    'files_selected'              => "files selected",
    'selected'                    => "selected",
    'recipient_exists'            => "Recipient already exists",
    'upload_more'                 => "Upload more",
    'refresh'                     => "Refresh",
    'download_will_be_deleted'    => "It will expire on",
    'download_is_ready'           => "Your download is ready",
    'delete'                      => "Delete",

    // Added in update 2.3.6
    'internet_down'               => 'Unable to reach the server, is your internet down?',
    'do_not_expire'               => 'Do not expire',
    'select_recipient'            => '- Select recipient -'
);