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
            <?php if (($_SESSION['nivel']==0)OR($_SESSION['nivel']==1)OR($_SESSION['nivel']==4)){ ?>
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
            <a href="#">
                <i class="fa fa-hourglass fa-fw"></i> 
                Gesti&oacute;n de Gobierno
                <span class="fa arrow"></span>
            </a>

            <ul class="nav nav-second-level">
                <?php 
                if ($_SESSION['nivel']==0){
                    echo '<li><a href="index2.php?view=punto_cuenta">Puntos de Cuenta</a></li>';
                    echo '<li><a href="index2.php?view=ordenes">Ordenes</a></li>';
                }else{
                    if(($_SESSION['solicitar_punto']==1)){
                        echo '<li><a href="index2.php?view=punto_cuenta">Puntos de Cuenta</a></li>';
                    }
                    if(($_SESSION['recibir_orden']==1)){
                        echo '<li><a href="index2.php?view=ordenes">Ordenes</a></li>';
                    }
                }?>
            </ul>
            <!-- /.nav-second-level -->
        </li>

        <li>
            <a href="#">
                <i class="  fa fa-money"></i> 
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
                    <a href="morris.html">
                        Servicio Peaje
                        <span class="fa fa-automobile"></span>
                    </a>
                </li>
            </ul>
            <!-- /.nav-second-level -->
        </li>

        <li>
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
                    <a href="#">Reporte Especificos
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
            </ul>
            <!-- /.nav-second-level -->
        </li>
    </ul>
</div>