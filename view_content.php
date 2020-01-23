<?php
    if(!defined('INCLUDE_CHECK')){
        echo ('<div align="center"><img  src="images/acceso.png" width="237" height="206"/> <br /> No est&aacute; autorizado para realizar esta acci&oacute;n o entrar en esta P&aacute;gina </div>');
        //die('Usted no está autorizado a ejecutar este archivo directamente');
        exit;
    }

    switch ($view){
        // SECCION DEL SISTEMA
        CASE "home": 
            include("pages/home.php");
            break;
        CASE "login": 
            include("pages/index.php");
            break;          
        CASE "logoff": 
            include("pages/aut_logoff.php");
            break;

// SECCION DE DATOS DE LA EMPRESA Y DE CONFIGURACION
        CASE "empresa":
            include ("pages/empresa/aut_gestion_empresa.php");
            break;
        CASE "empresa_add":
            include ("pages/empresa/empresa_add.php");
            break;
        CASE "empresa_update":
            include ("pages/empresa/empresa_update.php");
            break;
        CASE "empresa_drop":
            include ("pages/empresa/empresa_drop.php");
            break;

// SECCION DE DATOS DEL NIVEL
        CASE "nivel_acceso":
            include ("pages/nivel_acceso/aut_gestion_nivel_acceso.php");
            break;
        CASE "nivel_acceso_add":
            include ("pages/nivel_acceso/nivel_acceso_add.php");
            break;
        CASE "nivel_acceso_update":
            include ("pages/nivel_acceso/nivel_acceso_update.php");
            break;
        CASE "nivel_acceso_drop":
            include ("pages/nivel_acceso/nivel_acceso_drop.php");
            break;

///////////// USUARIOS /////////////////        
        CASE "usuarios": 
            include("pages/usuarios/aut_gestion_usuario.php");
            break;
        CASE "usuarios_add": 
            include("pages/usuarios/usuarios_add.php");
            break;
        CASE "usuarios_update": 
            include("pages/usuarios/usuarios_update.php");
            break;
        CASE "usuarios_update_clave": 
            include("pages/usuarios/usuarios_update_clave.php");
            break;  
        CASE "usuarios_update_nivel": 
            include("pages/usuarios/usuarios_update_nivel.php");
            break;
        CASE "usuarios_drop": 
            include("pages/usuarios/usuarios_drop.php");
            break;
        CASE "usuarios_unlock": 
            include("pages/usuarios/usuarios_unlock.php");
            break;
        CASE "usuarios_update_perfil": 
            include("pages/usuarios/usuarios_update_perfil.php");
            break;
        CASE "usuarios_update_perfil_clave": 
            include("pages/usuarios/usuarios_update_perfil_clave.php");
            break;
        CASE "usuarios_setting_perfil": 
            include("pages/usuarios/usuarios_setting_perfil.php");
            break;
        CASE "usuarios_setting_clave": 
            include("pages/usuarios/usuarios_setting_clave.php");
            break;
        CASE "usuarios_permisos": 
            include("pages/usuarios/usuarios_setting_permisos.php");
            break;
        CASE "usuarios_permisos_masivos": 
            include("pages/usuarios/usuarios_permisos_masivos.php");
            break;

///////////// ESTADOS DE TRAMITES /////////////////     
        CASE "edos_tramites": 
            include("pages/edos_tramites/aut_gestion_edos_tramites.php");
            break;
        CASE "edo_tramite_add": 
            include("pages/edos_tramites/edo_tramite_add.php");
            break;
        CASE "edo_tramite_update": 
            include("pages/edos_tramites/edo_tramite_update.php");
            break;
        CASE "edo_tramite_drop": 
            include("pages/edos_tramites/edo_tramite_drop.php");
            break;

        ///////////// CATEGORIAS /////////////////      
        CASE "categorias": 
            include("pages/categorias/aut_gestion_categorias.php");
            break;
        CASE "categoria_add": 
            include("pages/categorias/categoria_add.php");
            break;
        CASE "categoria_update": 
            include("pages/categorias/categoria_update.php");
            break;
        CASE "categoria_drop": 
            include("pages/categorias/categoria_drop.php");
            break;
        CASE "categoria_status": 
            include("pages/categorias/categoria_status.php");
            break;
    
///////////// DEPENDENCIAS /////////////////        
        CASE "unidades": 
            include("pages/unidades/aut_gestion_unidades.php");
            break;
        CASE "unidad_add": 
            include("pages/unidades/unidad_add.php");
            break;
        CASE "unidad_update": 
            include("pages/unidades/unidad_update.php");
            break;
        CASE "unidad_drop": 
            include("pages/unidades/unidad_drop.php");
            break;
        CASE "unidad_ver": 
            include("pages/unidades/unidad_ver.php");
            break;
        CASE "unidad_status": 
            include("pages/unidades/unidad_status.php");
            break;

///////////// TRAMITES /////////////////        
        CASE "tramites": 
            include("pages/tramites/aut_gestion_tramites.php");
            break;
        CASE "tramite_add":
            include("pages/tramites/tramite_add.php");
            break;
        CASE "tramite_update": 
            include("pages/tramites/tramite_update.php");
            break;
        CASE "tramite_scaler": 
            include("pages/tramites/tramite_scaler.php");
            break;
        CASE "tramite_drop": 
            include("pages/tramites/tramite_drop.php");
            break;
        CASE "tramite_status": 
            include("pages/tramites/tramite_status.php");
            break;

///////////// TIPOS DE SOLICITANTES /////////////////       
        CASE "tipo_solicitantes": 
            include("pages/tipo_solicitantes/aut_gestion_tipo_solicitantes.php");
            break;
        CASE "tipo_solicitante_add": 
            include("pages/tipo_solicitantes/tipo_solicitante_add.php");
            break;
        CASE "tipo_solicitante_update": 
            include("pages/tipo_solicitantes/tipo_solicitante_update.php");
            break;
        CASE "tipo_solicitante_drop": 
            include("pages/tipo_solicitantes/tipo_solicitante_drop.php");
            break;

///////////// COMUNIDADES /////////////////     
        CASE "comunidades": 
            include("pages/comunidades/aut_gestion_comunidades.php");
            break;
        CASE "comunidad_add": 
            include("pages/comunidades/comunidad_add.php");
            break;
        CASE "comunidad_update": 
            include("pages/comunidades/comunidad_update.php");
            break;
        CASE "comunidad_drop": 
            include("pages/comunidades/comunidad_drop.php");
            break;

//MODULO DEL PROFESION SOLICITANTE
        CASE "profesion_solicitante":
            include("pages/profesion_solicitante/aut_gestion_profesion_solicitante.php");
            break;  
        CASE "profesion_solicitante_add":
            include("pages/profesion_solicitante/profesion_solicitante_add.php");
            break;
        CASE "profesion_solicitante_update":
            include("pages/profesion_solicitante/profesion_solicitante_update.php");
            break;
        CASE "profesion_solicitante_drop":
            include("pages/profesion_solicitante/profesion_solicitante_drop.php");
            break;

//MODULO DEL ENTE PUBLICO
        CASE "ente_publico":
            include("pages/ente_publico/aut_gestion_ente_publico.php");
            break;  
        CASE "ente_publico_add":
            include("pages/ente_publico/ente_publico_add.php");
            break;
        CASE "ente_publico_update":
            include("pages/ente_publico/ente_publico_update.php");
            break;
        CASE "ente_publico_drop":
            include("pages/ente_publico/ente_publico_drop.php");
            break; 

//MODULO DEL PARTIDO POLITICO
        CASE "partido_politico":
            include("pages/partido_politico/aut_gestion_partido_politico.php");
            break;  
        CASE "partido_politico_add":
            include("pages/partido_politico/partido_politico_add.php");
            break;
        CASE "partido_politico_update":
            include("pages/partido_politico/partido_politico_update.php");
            break;
        CASE "partido_politico_drop":
            include("pages/partido_politico/partido_politico_drop.php");
            break;

///////////// TICKETS /////////////////     
        CASE "gestion_tickets_load": 
            include("pages/ticket/aut_gestion_tickets.php");
            break;
        CASE "gestion_tickets_prioridad": 
            include("pages/ticket/aut_gestion_tickets_prioridad.php");
            break;
        CASE "tickets": 
            include("pages/ticket/ticket_load_add.php");
            break;
        CASE "ticket_add": 
            include("pages/ticket/ticket_add.php");
            break;
        CASE "ticket_update": 
            include("pages/ticket/ticket_update.php");
            break;
        CASE "gestion_tickets":
            include("pages/ticket/ticket_load_view.php");
            break;
        CASE "ticket_status_update":
            include("pages/ticket/ticket_status_update.php");
            break;
        CASE "ticket_status_reprogramar":
            include("pages/ticket/ticket_status_reprogramar.php");
            break;
        CASE "ticket_status_escalar":
            include("pages/ticket/ticket_status_escalar.php");
            break;
        CASE "ticket_status_completar":
            include("pages/ticket/ticket_status_completar.php");
            break;
        CASE "ticket_status_cancelar":
            include("pages/ticket/ticket_status_cancelar.php");
            break;
        CASE "ticket_status_anular":
            include("pages/ticket/ticket_status_anular.php");
            break;
        CASE "ticket_detalle_view":
            include("pages/ticket/ticket_detalle_view.php");
            break;
        CASE "ticket_detalle_update":
            include("pages/ticket/ticket_detalle_update.php");
            break;
            

///////////// SOLICITANTES /////////////////        
        CASE "solicitante_load_view": 
            include("pages/solicitantes/solicitante_load_view.php");
            break;
        CASE "solicitantes": 
            include("pages/solicitantes/aut_gestion_solicitantes.php");
            break;
        CASE "solicitante_add": 
            include("pages/solicitantes/solicitante_add.php");
            break;
        CASE "solicitante_update": 
            include("pages/solicitantes/solicitante_update.php");
            break;
        CASE "solicitante_drop": 
            include("pages/solicitantes/solicitante_drop.php");
            break;

// SECCION DEL MANTENIMIENTO DEL SISTEMA
        CASE "solicitante_mantenimiento": 
            include("pages/solicitantes/solicitante_mantenimiento.php");
            break;
        CASE "solicitante_mantenimiento_phone": 
            include("pages/solicitantes/solicitante_mantenimiento_phone_fijo.php");
            break;
        CASE "solicitante_mantenimiento_movil": 
            include("pages/solicitantes/solicitante_mantenimiento_phone.php");
            break;

// GESTION DE REPORTES
        CASE "gestion_reporte_est_fecha": 
            include("pages/gestion_reportes/gestion_estadistico_fecha.php");
            break;
        CASE "gestion_reporte_est_year": 
            include("pages/gestion_reportes/gestion_estadistico_year.php");
            break;
        CASE "gestion_reporte_est_unidad_fecha": 
            include("pages/gestion_reportes/gestion_estadistico_unidad_fecha.php");
            break;
        CASE "gestion_reporte_est_unidad_year": 
            include("pages/gestion_reportes/gestion_estadistico_unidad_year.php");
            break;
        CASE "gestion_reporte_ticket_fecha": 
            include("pages/gestion_reportes/gestion_ticket_fecha.php");
            break;
        CASE "gestion_reporte_tipo_tramite": 
            include("pages/gestion_reportes/gestion_reporte_tipo_tramite.php");
            break;
        CASE "gestion_reporte_categoria": 
            include("pages/gestion_reportes/gestion_reporte_categoria.php");
            break;
        CASE "gestion_reporte_municipio": 
            include("pages/gestion_reportes/gestion_reporte_municipio.php");
            break;
        CASE "gestion_reporte_parroquia": 
            include("pages/gestion_reportes/gestion_reporte_parroquia.php");
            break;
        CASE "gestion_reporte_comunidad": 
            include("pages/gestion_reportes/gestion_reporte_comunidad.php");
            break;
        CASE "gestion_reporte_unidad": 
            include("pages/gestion_reportes/gestion_reporte_unidad.php");
            break;
        CASE "gestion_reporte_solicitante": 
            include("pages/gestion_reportes/gestion_reporte_solititante.php");
            break;

///////////// DEPENDENCIAS /////////////////        
        CASE "punto_cuenta": 
            include("pages/punto_cuenta/aut_gestion_punto_cuenta.php");
            break;
        CASE "punto_cuenta_add": 
            include("pages/punto_cuenta/punto_cuenta_add.php");
            break;
        CASE "punto_cuenta_update": 
            include("pages/punto_cuenta/punto_cuenta_update.php");
            break;
        CASE "punto_cuenta_drop": 
            include("pages/punto_cuenta/punto_cuenta_drop.php");
            break;
        CASE "enviar_punto": 
            include("pages/punto_cuenta/punto_cuenta_enviar.php");
            break;
        CASE "responder_punto_cuenta": 
            include("pages/punto_cuenta/punto_cuenta_decision.php");
            break;
        CASE "notificar_punto_cuenta": 
            include("pages/punto_cuenta/punto_cuenta_notificar.php");
            break;

//////////  MODULO DE SMS  /////////////////          
        CASE "sms_grupo": 
            include("pages/mensajeria/sms_masivo/sms_masivo_add.php");
            break;
        CASE "sms_recibidos": 
            include("pages/mensajeria/recibido/aut_gestion_recibido.php");
            break;
        CASE "recibido_drop": 
            include("pages/mensajeria/recibido/recibido_drop.php");
            break;
        CASE "enviados_drop": 
            include("pages/mensajeria/enviados/enviados_drop.php");
            break;
        CASE "sms_por_enviar": 
            include("pages/mensajeria/por_enviar/aut_gestion_por_enviar.php");
            break;
        CASE "sms_enviados": 
            include("pages/mensajeria/enviados/aut_gestion_enviado.php");
            break;
        CASE "solicitante_sms":
            include("pages/mensajeria/sms_masivo/solicitante_sms.php");
            break;
        CASE "usuario_sms":
            include("pages/mensajeria/sms_masivo/usuario_sms.php");
            break;

///////////// ORDENES /////////////////  
        CASE "ordenes": 
            include("pages/ordenes/aut_gestion_ordenes.php");
            break;
        CASE "orden_add": 
            include("pages/ordenes/ordenes_add.php");
            break;
        CASE "orden_update": 
            include("pages/ordenes/ordenes_update.php");
            break;
        CASE "orden_drop": 
            include("pages/ordenes/ordenes_drop.php");
            break;
        CASE "notificar_orden": 
            include("pages/ordenes/ordenes_notificar.php");
            break;
        CASE "responder_orden": 
            include("pages/ordenes/ordenes_responder.php");
            break;

///////////// ESTADO MAYOR  /////////////////  
        CASE "estado_mayor": 
            include("pages/estado_mayor/aut_gestion_estado_mayor.php");
            break;
        CASE "estado_mayor_add": 
            include("pages/estado_mayor/estado_mayor_add.php");
            break;
        CASE "estado_mayor_update": 
            include("pages/estado_mayor/estado_mayor_update.php");
            break;
        CASE "estado_mayor_drop": 
            include("pages/estado_mayor/estado_mayor_drop.php");
            break; 

///////////// INFORME SEMANAL ESTADO MAYOR  /////////////////  
        CASE "informe_semanal": 
            include("pages/estado_mayor/informe_semanal/aut_gestion_informe_semanal.php");
            break;
        CASE "informe_semanal_add": 
            include("pages/estado_mayor/informe_semanal/informe_semanal_add.php");
            break;
        CASE "informe_semanal_update": 
            include("pages/estado_mayor/informe_semanal/informe_semanal_update.php");
            break;
        CASE "informe_semanal_drop": 
            include("pages/estado_mayor/informe_semanal/informe_semanal_drop.php");
            break; 

///////////// ADMINISTRADOR INFORME SEMANAL ESTADO MAYOR  /////////////////  
        CASE "informe_semanal_adm": 
            include("pages/estado_mayor_adm/informe_semanal/aut_gestion_informe_semanal.php");
            break;
        CASE "informe_semanal_add_adm": 
            include("pages/estado_mayor_adm/informe_semanal/informe_semanal_add.php");
            break;
        CASE "informe_semanal_update_adm": 
            include("pages/estado_mayor_adm/informe_semanal/informe_semanal_update.php");
            break;
        CASE "informe_semanal_drop_adm": 
            include("pages/estado_mayor_adm/informe_semanal/informe_semanal_drop.php");
            break; 

///////////// PLANIFICACION ESTADO MAYOR  /////////////////  
        CASE "planificacion_adm": 
            include("pages/estado_mayor_adm/planificacion/aut_gestion_planificacion.php");
            break;
        CASE "planificacion_add_adm": 
            include("pages/estado_mayor_adm/planificacion/planificacion_add.php");
            break;
        CASE "planificacion_update_adm": 
            include("pages/estado_mayor_adm/planificacion/planificacion_update.php");
            break;
        CASE "planificacion_drop_adm": 
            include("pages/estado_mayor_adm/planificacion/planificacion_drop.php");
            break;
        CASE "notificar_planificacion_adm": 
            include("pages/estado_mayor_adm/planificacion/planificacion_notificacion.php");
            break;

///////////// ADMINISTRADOR PLANIFICACION ESTADO MAYOR  /////////////////  
        CASE "planificacion": 
            include("pages/estado_mayor/planificacion/aut_gestion_planificacion.php");
            break;
        CASE "planificacion_add": 
            include("pages/estado_mayor/planificacion/planificacion_add.php");
            break;
        CASE "planificacion_update": 
            include("pages/estado_mayor/planificacion/planificacion_update.php");
            break;
        CASE "planificacion_drop": 
            include("pages/estado_mayor/planificacion/planificacion_drop.php");
            break;
        CASE "notificar_planificacion": 
            include("pages/estado_mayor/planificacion/planificacion_notificacion.php");
            break;

///////////// EJECUCION ESTADO MAYOR  /////////////////  
        CASE "ejecucion": 
            include("pages/estado_mayor/ejecucion/aut_gestion_ejecucion.php");
            break;
        CASE "ejecucion_add": 
            include("pages/estado_mayor/ejecucion/ejecucion_add.php");
            break;
        CASE "notificar_ejecucion": 
            include("pages/estado_mayor/ejecucion/ejecucion_notificar.php");
            break;

///////////// EJECUCION ESTADO MAYOR  ///////////////// 
        CASE "ejecucion_adm": 
            include("pages/estado_mayor_adm/ejecucion/aut_gestion_ejecucion_adm.php");
            break;
        CASE "ejecucion_add_adm": 
            include("pages/estado_mayor_adm/ejecucion/ejecucion_add.php");
            break;
        CASE "notificar_ejecucion_adm": 
            include("pages/estado_mayor_adm/ejecucion/ejecucion_notificar.php");
            break;

//MODULO DE SMS         
        CASE "sms_grupo": 
            include("pages/mensajeria/sms_masivo/sms_masivo_add.php");
            break;
        CASE "sms_recibidos": 
            include("pages/mensajeria/recibido/aut_gestion_recibido.php");
            break;
        CASE "sms_por_enviar": 
            include("pages/mensajeria/por_enviar/aut_gestion_por_enviar.php");
            break;
        CASE "sms_enviados": 
            include("pages/mensajeria/enviados/aut_gestion_enviado.php");
            break;
        CASE "solicitante_sms":
            include("pages/mensajeria/sms_masivo/solicitante_sms.php");
            break;

//MODULO DE PAGO HIDROLOGICA 
        CASE "pagos_hidrologica_view": 
            include("pages/pago_hidrologica/pagos_hidrologica_view.php");
            break;   
        CASE "pago_hidrologica": 
            include("pages/pago_hidrologica/aut_gestion_pago.php");
            break;
        CASE "pago_hidrologica_adm": 
            include("pages/pago_hidrologica/aut_gestion_pago_adm.php");
            break;
        CASE "cargar_xml": 
            include("pages/pago_hidrologica/cargar_xml.php");
            break;
        CASE "pago_add": 
            include("pages/pago_hidrologica/pago_add.php");
            break;
        CASE "pago_add_adm": 
            include("pages/pago_hidrologica/pago_add_adm.php");
            break;
        CASE "pago_drop": 
            include("pages/pago_hidrologica/pago_drop.php");
            break;
        CASE "pago_drop_all": 
            include("pages/pago_hidrologica/pago_drop_all.php");
            break;

//MODULO DE PAGO PEAJE 
        CASE "peaje": 
            include("pages/peaje/aut_gestion_peaje.php");
            break;
        CASE "pago_peaje_adm": 
            include("pages/peaje/aut_gestion_peaje_adm.php");
            break; 
        CASE "recargar_add": 
            include("pages/peaje/recargar_add.php");
            break;
        CASE "pagos_peaje_view": 
            include("pages/peaje/pagos_peaje_view.php");
            break; 
        CASE "peaje_add_adm": 
            include("pages/peaje/peaje_add_adm.php");
            break;

//MODULO DE ESTADISTICAS
        CASE "atencion_unidad": 
            include("pages/estadistica/atencion_unidad.php");
            break;
        CASE "est_aten_unidad": 
            include("pages/estadistica/estadistica_unidad.php");
            break;
        CASE "atencion_mensual": 
            include("pages/estadistica/atencion_mensual.php");
            break;
        CASE "est_aten_mensual": 
            include("pages/estadistica/estadistica_mensual.php");
            break;
        CASE "est_ordenes": 
            include("pages/estadistica/estadistica_ordenes.php");
            break;
        CASE "ordenes_unidad": //estas son las ordenes por usuario no por unidad.
            include("pages/estadistica/ordenes_unidad.php");
            break;
        CASE "est_ord_unidad": 
            include("pages/estadistica/estadistica_ordenes_unidad.php");
            break;
        CASE "ordenes_mensuales": 
            include("pages/estadistica/ordenes_mensuales.php");
            break;
        CASE "est_ord_mensuales": 
            include("pages/estadistica/estadistica_ordenes_mensuales.php");
            break;
        CASE "est_punto_cuenta": 
            include("pages/estadistica/estadistica_punto_cuenta.php");
            break;

//MODULO DE DENUNCIA
        CASE "denuncia": 
            include("pages/denuncia/aut_gestion_denuncia.php");
            break;
        CASE "denuncia_add": 
            include("pages/denuncia/denuncia_add.php");
            break;

//MODULO DE FILEBOX        
        CASE "my_filebox": 
            include("pages/filebox/aut_gestion_filebox.php");
            break;



// POR DEFECTO CUANDO VIEW NO POSEE VALOR SE LLAMA AL FORMULARIO DE AUNTENTICACION
        default: 
            include("pages/home.php");
//            include("panel.php");
    
        
    }
?>