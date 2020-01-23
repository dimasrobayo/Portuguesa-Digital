<?php
    $cedula=$_SESSION['id'];
    $query="SELECT * FROM permisos WHERE cedula_usuario='$cedula'";
    $result = pg_query($query)or die(pg_last_error());
    $result_permisos = pg_fetch_array($result);
    pg_free_result($result);
?>

<div class="sidebar-nav navbar-collapse">
    <ul class="nav" id="side-menu">
        <li class="sidebar-search">
            <div class="input-group custom-search-form">
                <input type="text" class="form-control" placeholder="Buscar...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
            <!-- /input-group -->
        </li>

        <li>
            <a href="index2.php?view=home">
                <i class="fa fa-user fa-fw"></i> 
                Inicio
            </a>
        </li>

        <li>
            <?php if ($result_permisos[configurar_sistema]==1){ ?>
            <a href="#">
                <i class="fa fa-dashboard fa-fw"></i> 
                Configuraciones
                <span class="fa arrow"></span>
            </a>

            <ul class="nav nav-second-level">
                <?php if ($result_permisos[configurar_sistema]==1){ ?>
                <li>
                    <a href="index2.php?view=empresa">Configuracion del Sistema</a>
                </li>
                <?php } ?>

                <?php if ($result_permisos[usuarios_sistema]==1){ ?>
                <li>
                    <a href="index2.php?view=usuarios">Usuarios del Sistema</a>
                </li>
                <?php } ?>

                <?php if ($result_permisos[estados_tramites]==1){ ?>
                <li>
                    <a href="index2.php?view=edos_tramites">Estados de Tramites</a>
                </li>
                <?php } ?>

                <?php if ($result_permisos[categorias]==1){ ?>
                <li>
                    <a href="index2.php?view=categorias">Categorias</a>
                </li>
                <?php } ?>

                <?php if ($result_permisos[unidades]==1){ ?>
                <li>
                    <a href="index2.php?view=unidades">Unidades</a>
                </li>
                <?php } ?>

                <?php if ($result_permisos[tipo_solicitantes]==1){ ?>
                <li>
                    <a href="index2.php?view=tipo_solicitantes">Tipo de Solicitantes</a>
                </li>
                <?php } ?>

                <?php if ($result_permisos[tipo_solicitantes]==1){ ?>
                <li>
                    <a href="index2.php?view=comunidades">Comunidades</a>
                </li>
                <?php } ?>

                <?php if ($result_permisos[tipo_solicitantes]==1){ ?>
                <li>
                    <a href="index2.php?view=profesion_solicitante">Profesiones</a>
                </li>
                <?php } ?>

                <?php if ($result_permisos[tipo_solicitantes]==1){ ?>
                <li>
                    <a href="index2.php?view=ente_publico">Entes Publicos</a>
                </li>
                <?php } ?>

                <?php if ($result_permisos[tipo_solicitantes]==1){ ?>
                <li>
                    <a href="index2.php?view=partido_politico">Partidos Politicos</a>
                </li>
                <?php } ?>
            </ul>
            <?php } ?>
            <!-- /.nav-second-level -->
        </li>

        <li>
            <?php if ($result_permisos[visualiza_estadisticas]==1){ ?>
            <a href="#">
                <i class="fa fa-pie-chart fa-fw"></i> 
                Estadisticas
                <span class="fa arrow"></span>
            </a>

            <ul class="nav nav-second-level">
                <li>
                    <a href="#">Estadisticas de Atencion
                        <span class="fa arrow"></span>
                    </a>

                    <ul class="nav nav-third-level">
                        <li>
                            <a href="index2.php?view=atencion_unidad">Atención Por Unidades</a>
                        </li>

                        <li>
                            <a href="index2.php?view=atencion_mensual">Atención Mensual</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#">Ordenes
                        <span class="fa arrow"></span>
                    </a>

                    <ul class="nav nav-third-level">
                        <li>
                            <a href="index2.php?view=est_ordenes">General de Ordenes</a>
                        </li>

                        <li>
                            <a href="index2.php?view=ordenes_unidad">Ordenes por Usuario</a>
                        </li>

                        <li>
                            <a href="index2.php?view=ordenes_mensuales">Ordenes Mensuales</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="index2.php?view=est_punto_cuenta">Punto de Cuentas
                    </a>
                </li>
            </ul>
            <!-- /.nav-second-level -->
            <?php } ?>
        </li>
        
        <li>
            <?php if (($result_permisos[solicitar_punto]==1)or($result_permisos[recibir_orden]==1)){ ?>
            <a href="#">
                <i class="fa fa-hourglass fa-fw"></i> 
                Gesti&oacute;n de Gobierno?>
                <span class="fa arrow"></span>
            </a>

            <ul class="nav nav-second-level">
                <?php if ($result_permisos[solicitar_punto]==1){ ?>
                <li>
                    <a href="index2.php?view=punto_cuenta">Puntos de Cuenta</a>
                </li>
                <?php } ?>

                <?php if ($result_permisos[recibir_orden]==1){ ?>
                <li>
                    <a href="index2.php?view=ordenes">Ordenes</a>
                </li>
                <?php } ?>
            </ul>
            <?php } ?>
            <!-- /.nav-second-level -->
        </li>

        <li>
            <?php if ($result_permisos[mis_archivos]==1){ ?>
            <a href="#">
                <i class="fa fa-archive"></i> 
                Mis Archivos
                <span class="fa arrow"></span>
            </a>

            <ul class="nav nav-second-level">
                <li>
                    <a href="index2.php?view=my_filebox">My Nube</a>
                </li>
                <li>
                    <a href="morris.html">Documentos Compartidos</a>
                </li>
            </ul>
            <?php } ?>
            <!-- /.nav-second-level -->
        </li>

        <li>
            <?php if ($result_permisos[administra_pago_hidrologica]==1){ ?>
            <a href="index2.php?view=pagos_hidrologica_view">
                <i class="fa fa-calendar-check-o"></i> 
                ADM Pagos Hidrologica
            </a>
            <?php } ?>
            <!-- /.nav-second-level -->
        </li>

        <li>
            <?php if ($result_permisos[pagos_servicios]==1){ ?>
            <a href="#">
                <i class="fa fa-money"></i> 
                Pagos de Servicios
                <span class="fa arrow"></span>
            </a>

            <ul class="nav nav-second-level">
                <li>
                    <a href="index2.php?view=pago_hidrologica">
                        Servicio Hidrologica
                        <span class="glyphicon glyphicon-tint"></span>
                    </a>
                </li>
                <li>
                    <a href="index2.php?view=peaje">
                        Servicio Peaje
                        <span class="fa fa-automobile"></span>
                    </a>
                </li>
            </ul>
            <?php } ?>
            <!-- /.nav-second-level -->
        </li>

        <li>
            <?php if ($result_permisos[atencion_portugueseno]==1){ ?>
            <a href="#">
                <i class="fa fa-search fa-fw"></i> 
                Atenci&oacute;n al Portugueseño
                <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="index2.php?view=gestion_tickets_load">Gestion de Solicitud</a>
                </li>
                <li>
                    <a href="index2.php?view=gestion_tickets">Busqueda de Solicitud</a>
                </li>
            </ul>
            <?php } ?>
        </li>

        <li>
            <a href="index2.php?view=tickets">
                <i class="fa fa-edit fa-fw"></i> 
                Nueva Solicitud
            </a>
        </li>

        <li>
            <a href="index2.php?view=solicitante_load_view">
                <i class="fa fa-users fa-fw"></i> 
                Buscar Solicitante
            </a>
        </li>

        <li>
            <?php if ($result_permisos[mensajeria_masiva]==1){ ?>
            <a href="#">
                <i class="fa fa-mobile fa-fw"></i> 
                Mensajeria
                <span class="fa arrow"></span>
            </a>

            <ul class="nav nav-second-level">
                <li>
                    <a href="index2.php?view=sms_grupo">Enviar Mensaje Masivo</a>
                </li>
                <li>
                    <a href="index2.php?view=sms_enviados">Bandeja de Enviados</a>
                </li>
                <li>
                    <a href="index2.php?view=sms_recibidos">Bandeja de Recibidos</a>
                </li>
                <li>
                    <a href="index2.php?view=sms_por_enviar">Bandeja Por Enviar</a>
                </li>
            </ul>
            <?php } ?>
            <!-- /.nav-second-level -->
        </li>

        <li>
            <?php if ($result_permisos[visualiza_reportes]==1){ ?>
            <a href="#">
                <i class="fa fa-file-text-o fa-fw"></i> 
                Reportes
                <span class="fa arrow"></span>
            </a>

            <ul class="nav nav-second-level">
                <li>
                    <a href="#">Reporte General
                        <span class="fa arrow"></span>
                    </a>

                    <ul class="nav nav-third-level">
                        <li>
                            <a href="reportes/imprimir_lista_etramites.php" target="true">Estados de las Tramites</a>
                        </li>

                        <li>
                            <a href="reportes/imprimir_lista_comunidades.php" target="true">Comunidades</a>
                        </li>
                        <li>
                            <a href="reportes/imprimir_lista_categorias.php" target="true">Categorias</a>
                        </li>
                        <li>
                            <a href="reportes/imprimir_lista_unidades.php" target="true">Unidades</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#">Reporte Especifico
                        <span class="fa arrow"></span>
                    </a>

                    <ul class="nav nav-third-level">
                        <li>
                            <a href="index2.php?view=gestion_reporte_est_fecha" target="true">Estadisticos de Ticket por Fecha</a>
                        </li>

                        <li>
                            <a href="index2.php?view=gestion_reporte_est_year" target="true">Estadisticos de Ticket por Año</a>
                        </li>
                        <li>
                            <a href="index2.php?view=gestion_reporte_tipo_tramite" target="true">Solicitudes por Tipo de Tramite</a>
                        </li>
                        <li>
                            <a href="index2.php?view=gestion_reporte_categoria" target="true">Solicitudes por Categoria</a>
                        </li>
                        <li>
                            <a href="index2.php?view=gestion_reporte_municipio" target="true">Solicitudes por Municipio</a>
                        </li>
                        <li>
                            <a href="index2.php?view=gestion_reporte_parroquia" target="true">Solicitudes por Parroquis</a>
                        </li>
                        <li>
                            <a href="index2.php?view=gestion_reporte_comunidad" target="true">Solicitudes por Comunidad</a>
                        </li>
                        <li>
                            <a href="index2.php?view=gestion_reporte_unidad" target="true">Solicitudes por Unidad</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#">Reporte Gesti&oacute;n de Gobierno
                        <span class="fa arrow"></span>
                    </a>

                    <ul class="nav nav-third-level">
                        <li>
                            <a href="reportes/imprimir_lista_ordenes.php" target="true">Ordenes</a>
                        </li>
                        <li>
                            <a href="reportes/imprimir_lista_ordenes.php" target="true">Puntos de Cuentas Pendientes</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <?php } ?>
            <!-- /.nav-second-level -->
        </li>

        <li>
            <?php if ($result_permisos[visualiza_herramientas]==1){ ?>
            <a href="#">
                <i class="fa fa-wrench fa-fw"></i> 
                Herramientas
                <span class="fa arrow"></span>
            </a>

            <ul class="nav nav-second-level">
                <li>
                    <a href="index2.php?view=solicitante_mantenimiento">Mantenimiento de Tickets</a>
                </li>
                <li>
                    <a href="index2.php?view=solicitante_mantenimiento_phone">Mantenimiento de Solicitantes</a>
                </li>
            </ul>
            <?php } ?>
        </li>
    </ul>
</div>