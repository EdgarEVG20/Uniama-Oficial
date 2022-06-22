<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center">                
        <div class="sidebar-brand-text mx-3"></div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="./panel2.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tablero</span></a>
    </li>    

    <?php
        if($_SESSION['nivel_user'] == 1){
    ?>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                ADMINISTRADOR
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCatalogos"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Cat&aacute;logos</span>
                </a>
                <div id="collapseCatalogos" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="./documentos.php">Documentos</a>
                        <a class="collapse-item" href="./ausencias.php">Ausencias</a>
                        <a class="collapse-item" href="./paises.php">Pa&iacute;ses</a>
                        <a class="collapse-item" href="./estados.php">Estados</a>
                        <a class="collapse-item" href="./municipios.php">Municipios</a>
                        <a class="collapse-item" href="./colonias.php">Colonias</a>
                        <a class="collapse-item" href="./regimenFiscal.php">R&eacute;gimen Fiscal</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClientes"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Clientes</span>
                </a>
                <div id="collapseClientes" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="./nuevoCliente.php">Nuevo Cliente</a>
                        <a class="collapse-item" href="./mostrarClientes.php">Mostrar Clientes</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCorporativos"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-industry"></i>
                    <span>Corporativos</span>
                </a>
                <div id="collapseCorporativos" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="./nuevoCorporativo.php">Nuevo Corporativo</a>
                        <a class="collapse-item" href="./nuevoCorporativoEmpresa.php">Relacionar Empresas</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsuarios"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Usuarios</span>
                </a>
                <div id="collapseUsuarios" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="./usuarios.php">Mostrar Usuarios</a>
                    </div>
                </div>
            </li>

    <?php
        }elseif($_SESSION['nivel_user'] == 2){

    ?>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                MIS DATOS
            </div>

            <!-- Nav Item - Información -->
            <li class="nav-item">
                <a class="nav-link" href="./tMiPerfil.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Informaci&oacute;n</span></a>
            </li>

            <!-- Nav Item - Ausencias -->
            <li class="nav-item">
                <a class="nav-link" href="./tAusencias.php">
                    <i class="fas fa-fw fa-calendar-times"></i>
                    <span>Ausencias</span></a>
            </li>

            <!-- Nav Item - Documentos -->
            <li class="nav-item">
                <a class="nav-link" href="./tDocumentos.php">
                    <i class="fas fa-fw fa-folder-open"></i>
                    <span>Documentos</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                INFORMACIÓN DE COLABORADORES
            </div>

            <!-- Nav Item - Empleados -->
            <li class="nav-item">
                <a class="nav-link" href="./adminEmpleados.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Colaboradores</span></a>
            </li>
            
            <!-- Nav Item - Calendario -->
            <!--<li class="nav-item">
                <a class="nav-link" href="./adminCalendario.php">
                    <i class="fas fa-fw fa-calendar"></i>
                    <span>Calendario</span></a>
            </li>-->

            <!-- Nav Item - Reclutamiento -->
            <!--<li class="nav-item">
                <a class="nav-link" href="./adminReclutamiento.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Reclutamiento</span></a>
            </li>-->
            
            <!-- Nav Item - Control Horario -->
            <!--<li class="nav-item">
                <a class="nav-link" href="./adminControlHorario.php">
                    <i class="fas fa-fw fa-clock"></i>
                    <span>Control horario</span></a>
            </li>-->
            
            <!-- Nav Item - Informes -->
            <!--<li class="nav-item">
                <a class="nav-link" href="./adminInformes.php">
                    <i class="fas fa-fw fa-chart-pie"></i>
                    <span>Informes</span></a>
            </li>-->

            <!-- Nav Item - Archivos -->
            <li class="nav-item">
                <a class="nav-link" href="./adminArchivos.php">
                    <i class="fas fa-fw fa-folder-open"></i>
                    <span>Archivos</span></a>
            </li>

            <!-- Nav Item - Ausencias -->
            <li class="nav-item">
                <a class="nav-link" href="./adminAusenciasT.php">
                    <i class="fas fa-fw fa-calendar-times"></i>
                    <span>Ausencias</span></a>
            </li>

            <!-- Nav Item - Ausencias -->
            <li class="nav-item">
                <a class="nav-link" href="./adminRelojChecador.php">
                    <i class="fas fa-fw fa-clock"></i>
                    <span>Reloj Checador</span></a>
            </li>

            <!-- Nav Item - Desempeño -->
            <!--<li class="nav-item">
                <a class="nav-link" href="./adminDesempeno.php">
                    <i class="fas fa-fw fa-check"></i>
                    <span>Desempeño</span></a>
            </li>-->

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                CONFIGURACI&Oacute;N DE EMPRESA
            </div>

            <!-- Nav Item - Empresa -->
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEmpresa"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-building"></i>
                    <span>Empresa</span>
                </a>
                <div id="collapseEmpresa" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="./adminParametrosFiscales.php">Par&aacute;metros Fiscales</a>
                        <a class="collapse-item" href="./adminOficinas.php">Oficinas</a>
                        <a class="collapse-item" href="./adminAusencias.php">Ausencias</a>
                        <a class="collapse-item" href="./adminDocumentos.php">Documentos</a>
                        <a class="collapse-item" href="./adminDepartamentos.php">Departamentos</a>
                        <a class="collapse-item" href="./adminPuestos.php">Puestos</a>
                        <a class="collapse-item" href="./adminHorariosLaborales.php">Horarios Laborales</a>
                        <a class="collapse-item" href="./adminOrganigrama.php">Organigrama</a>
                        <a class="collapse-item" href="./adminAvisoPrivacidad.php">Aviso de Privacidad</a>
                    </div>
                </div>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
    <?php
        }elseif($_SESSION['nivel_user'] == 3){
    ?>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                MIS DATOS
            </div>

            <!-- Nav Item - Informacion -->
            <li class="nav-item">
                <a class="nav-link" href="./tMiPerfil.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Informaci&oacute;n</span></a>
            </li>
            
            <!-- Nav Item - Ausencias -->
            <li class="nav-item">
                <a class="nav-link" href="./tAusencias.php">
                    <i class="fas fa-fw fa-calendar-times"></i>
                    <span>Ausencias</span></a>
            </li>
            
            <!-- Nav Item - Documentos -->
            <li class="nav-item">
                <a class="nav-link" href="./tDocumentos.php">
                    <i class="fas fa-fw fa-folder-open"></i>
                    <span>Documentos</span></a>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                INFORMACIÓN DE COLABORADORES
            </div>

            <!-- Nav Item - Ausencias -->
            <li class="nav-item">
                <a class="nav-link" href="./superVerAusenciasT.php">
                    <i class="fas fa-fw fa-calendar-times"></i>
                    <span>Ausencias</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
    <?php
        }elseif ($_SESSION['nivel_user'] == 4) {
    ?>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                MIS DATOS
            </div>

            <!-- Nav Item - Información -->
            <li class="nav-item">
                <a class="nav-link" href="./tMiPerfil.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Informaci&oacute;n</span></a>
            </li>
            
            <!-- Nav Item - Ausencias -->
            <li class="nav-item">
                <a class="nav-link" href="./tAusencias.php">
                    <i class="fas fa-fw fa-calendar-times"></i>
                    <span>Ausencias</span></a>
            </li>

            <!-- Nav Item - Fichaje -->
            <!--<li class="nav-item">
                <a class="nav-link" href="./tFichaje.php">
                    <i class="fas fa-fw fa-calendar-check"></i>
                    <span>Fichaje</span></a>
            </li>-->
            
            <!-- Nav Item - Documentos -->
            <li class="nav-item">
                <a class="nav-link" href="./tDocumentos.php">
                    <i class="fas fa-fw fa-folder-open"></i>
                    <span>Documentos</span></a>
            </li>
            
            <!-- Nav Item - Tareas -->
            <!--<li class="nav-item">
                <a class="nav-link" href="./tTareas.php">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Tareas</span></a>
            </li>-->

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
    <?php
        }else{
            header("location: index.html");
        }
    ?>
</ul>
<!-- End of Sidebar -->