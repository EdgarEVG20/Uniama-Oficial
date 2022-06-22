<?php
    session_start();
    require("conexion.php");

    $usuario = $_SESSION['nombre_user'];
    $idEmpresa = $_SESSION['id_emisor_user'];
    $nivelUsuario = $_SESSION['nivel_user'];

    if (!isset($usuario)){
        header("location: index.html");
    } elseif (isset($usuario) && $nivelUsuario == 2) {
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        $breadcrumb = "Tablero / Configuración De Empresa / Empresa / Aviso de privacidad";
        include("estructura/metas.php");
        include("estructura/title.php");
        include("estructura/hrefs.php");
    ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
            include("estructura/menu.php");
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                    include("estructura/encabezado.php");
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <?php
                        $conAvisoPrivacidad = "SELECT * FROM avisos_privacidad WHERE id_empresa = $idEmpresa";
                        $resAvisoPrivacidad = mysqli_query($conexion, $conAvisoPrivacidad);
                        $resAP = mysqli_fetch_assoc($resAvisoPrivacidad);

                    ?>
                    <form class="form mt-3 mb-5" action="server/insert-adminAvisoPrivacidad.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
                        <!-- Page Heading -->
                        <h1 class="h2 mb-2 text-gray-900 text-center">AVISO Y POLÍTICAS DE PRIVACIDAD GRUPO DE INNOVACION EN TECNOLOGIA Y CONSULTORIA VELOR, S.A. DE C.V.</h1>
                        <p class="text-justify">Este Aviso de Privacidad tiene por objeto proporcionar una visión clara de cómo usamos los datos personales que el titular de dichos nos proporciona, nuestros esfuerzos por protegerlos, las opciones que tiene para controlar sus datos personales y proteger su privacidad.</p>
                        <br>
                        
                        <h1 class="h4 mb-2 text-gray-900 text-left">I.- FUNDAMENTO LEGAL PARA EL TRATAMIENTO DE DATOS PERSONALES.</h1>
                        <p class="text-justify">En GRUPO DE INNOVACION EN TECNOLOGIA Y CONSULTORIA VELOR, S.A. DE C.V., en lo conducente denominada “LA EMPRESA” valoramos su privacidad y protegemos sus datos personales, por lo que el presente aviso de políticas de privacidad cumple con todos los elementos de existencia establecidos en la Ley Federal de Protección de Datos Personales en Posesión de los Particulares referentes a los artículos 8, 15, 16 y 36.</p>
                        <p class="text-justify">De igual forma le pedimos que lea atentamente todos y cada uno de los términos y condiciones contenidos en el presente AVISO DE PRIVACIDAD, ya que la simple aportación que haga de sus datos personales ya sea por medios físicos o electrónicos constituye la aceptación expresa de estos TÉRMINOS Y CONDICIONES y en consecuencia nos autoriza expresamente al tratamiento y transferencia de sus datos personales en los términos que a continuación se expresan.</p>
                        <br>
                        
                        <h1 class="h4 mb-2 text-gray-900 text-left">II- PRINCIPIOS RECTORES DEL TRATAMIENTO DE DATOS EN LA EMPRESA.</h1>
                        <p class="text-justify">En “LA EMPRESA” los datos personales recabados de nuestros clientes titulares son tratados de forma estrictamente privada y confidencial, mediante un uso adecuado, legítimo y lícito, salvaguardando permanentemente los principios de:</p>
                        <ol type="I">
                            <li>I. Licitud.</li>
                            <li>II. Consentimiento.</li>
                            <li>III. Calidad.</li>
                            <li>IV. Información.</li>
                            <li>V. Proporcionalidad.</li>
                            <li>VI. Responsabilidad.</li>
                            <li>VII. Lealtad.</li>
                            <li>VIII. Finalidad.</li>
                        </ol>
                        
                        <p class="text-justify">De conformidad con lo dispuesto por la Ley Federal de Protección de Datos Personales en Posesión de los Particulares, su Reglamento y disposiciones secundarias.</p>
                        <br>
                        
                        <h1 class="h4 mb-2 text-gray-900 text-left">III.- LINEAMIENTOS APLICABLES.</h1>
                        <p class="text-justify"><b>OBJETO.-</b> En términos del artículo 43, fracción III de la Ley Federal de Protección de Datos Personales en Posesión de los Particulares, los presentes Lineamientos tienen por objeto establecer el contenido y alcance de los avisos de privacidad, en términos de lo dispuesto por dicha Ley y su Reglamento.</p>
                        <p class="text-justify"><b>ÁMBITO DE APLICACIÓN.-</b> Los presentes Lineamientos serán de observancia obligatoria en toda la República Mexicana, para las personas físicas o morales de carácter privado que traten datos personales en términos de la Ley Federal de Protección de Datos Personales en Posesión de los Particulares y su Reglamento.</p>
                        <br>
                        
                        <h1 class="h4 mb-2 text-gray-900 text-left">IV.- IDENTIDAD Y DOMICILIO DEL RESPONSABLE DIRECTO DEL TRATAMIENTO DE DATOS PERSONALES EN CORPORATIVO INTERNACIONAL ESPECIALIZADO.</h1>
                        <p class="text-justify">Para efectos del presente AVISO DE PRIVACIDAD y en función del artículo 30 de la Ley Federal de Protección de Datos Personales en Posesión de los Particulares  “LA EMPRESA” nombró a la ciudadana VERÓNICA BEJAR GARIBAY, que en lo conducente será llamado “EL RESPONSABLE”, con domicilio la finca ubicada en calle Primavera número 30, de la Colonia  Arboledas, C.P. 28869, en la ciudad de Manzanillo, Colima, México, como responsable directo de los datos personales que nos proporcione, en su carácter de administrador único, teniendo para todo lo relativo medios de comunicación directa el correo electrónico <a href="mailto: administracion@velor.mx">administracion@velor.mx</a>, teniendo como funciones:</p>
                        <ol type="I">
                            <li>I. Acceso.</li>
                            <li>II. Manejo.</li>
                            <li>III. Aprovechamiento.</li>
                            <li>IV. Transferencia.</li>
                            <li>V. Tratamiento.</li>
                        </ol>
                        <br>
                        
                        <h1 class="h4 mb-2 text-gray-900 text-left">V.- MEDIOS DE RECABACIÓN DE DATOS PERSONALES.</h1>
                        <p class="text-justify">La información que recopilamos acerca de nuestros clientes como titulares de datos personales serán aquellos que se nos ha proporcionado directamente, a través de nuestros canales de captación de información directa, tales como nuestro sitio web, comunicación directa empresarial para la obtención de una cotización referente a la prestación de servicios ofrecidos por “LA EMPRESA” y demás conducentes mediante correo electrónico <a href="mailto: administracion@velor.mx">administracion@velor.mx</a>, datos propios y necesarios para la expedición de  Comprobantes Fiscales Digitales por Internet a través del software de operación cuando se realizan facturas y/o se ingresan datos esenciales para operación y manejo de recursos, así como nuestros canales de captación de información indirecta tales como comunicaciones de datos personales por parte de empresas afiliadas, comunicación con terceros con los que “LA EMPRESA” tenga celebrados acuerdos comerciales que le proporcionen información relacionada con usted, incluyendo sociedades de información crediticia,  así como la información que provenga de fuentes de acceso público. </p>
                        <br>
                        
                        <h1 class="h4 mb-2 text-gray-900 text-left">VI.- RECABACIÓN DE DATOS PERSONALES MEDIANTE ACCESO A PORTAL WEB OFICIAL DE LA EMPRESA.</h1>
                        <p class="text-justify">“LA EMPRESA” le informa que al acceder al portal web de “GRUPO DE INNOVACION EN TECNOLOGIA Y CONSULTORIA VELOR, S.A. DE C.V.,” acepta los términos de uso y el presente aviso de privacidad, así como al continuar accediendo al sitio web oficial <a href="https://www.velor.mx/" target="_blank">https://www.velor.mx/</a>, usted acepta las condiciones de tratamiento y datos personales adscritos en las condiciones de confidencialidad.</p>
                        <p class="text-justify">Sin embargo usted puede retirar su consentimiento en cualquier momento, por lo cual nos abstendremos de procesar sus datos personales, excepto en la medida en que el procesamiento de sus datos personales sea legal por otros motivos, incluso sin su consentimiento, por ejemplo, cuando se utilicen para fines legales como el cumplimiento de obligaciones contractuales o el cumplimiento de la ley o para proteger nuestros intereses legítimos o de terceros, tal como la disponibilidad ininterrumpida de nuestro portal web de violaciones de ley.</p>
                        <br>
                        
                        <h1 class="h4 mb-2 text-gray-900 text-left">VII.- INFORMACIÓN RECOPILADA MEDIANTE COOKIES Y DISPOSITIVOS SIMILARES.</h1>
                        <p class="text-justify">“LA EMPRESA” mediante su página web <a href="https://www.velor.mx/" target="_blank">https://www.velor.mx/</a> utiliza cookies, web beacons y/o Kits de Desarrollo de Software para facilitar la navegación en su plataforma.</p>
                        <p class="text-justify">Las cookies constituyen una herramienta empleada por los servidores web para almacenar y recuperar información que se guarda en el navegador utilizado por los visitantes del sitio web, de acuerdo a su naturaleza constituirá su función.</p>
                        
                            <h1 class="h5 mb-2 ml-5 text-gray-900 text-left">I. Cookies obligatorias: Son esenciales y le ayudarán a navegar, moverse por el sitio web.</h1>
                            <p class="text-justify ml-5">A continuación se anuncian aquellas cookies obligatorias más comunes utilizadas por los proveedores generales para su conocimiento.</p>
                            <div class="table-responsive" id="mostrarTabla">
                                <table class="table table-hover" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>NOMBRE</th>
                                            <th>FINALIDAD</th>
                                            <th>CADUCIDAD</th>
                                            <th>PROVEEDOR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>_gcl_au</th>
                                            <td>Comprender la interacción del usuario con el sitio web.</td>
                                            <td>3 meses</td>
                                            <td>Google</td>
                                        </tr>
                                        <tr>
                                            <th>test_cookie</th>
                                            <td>Comprobar si el navegador del usuario admite cookies.</td>
                                            <td>1 día</td>
                                            <td>doubleclick.net</td>
                                        </tr>
                                        <tr>
                                            <th>_gat_gtag_UA_141692200_1</th>
                                            <td>Distinguir a los usuarios entre sí.</td>
                                            <td>1 minuto</td>
                                            <td>Google</td>
                                        </tr>
                                        <tr>
                                            <th>_gat UA-141692200-1</th>
                                            <td>Patrón establecido por proveedor  para limitar la cantidad de datos registrados por el proveedor en sitios web de alto volumen de tráfico.</td>
                                            <td>1 minuto</td>
                                            <td>Google</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h1 class="h5 mb-2 ml-5 text-gray-900 text-left">II. Cookies de funcionalidad y analíticas: Nos permiten analizar el uso de nuestras plataformas para que podamos medir y mejorar el rendimiento pudiéndolas colocar  “LA EMPRESA” o un tercero en nuestro nombre.</h1>
                            <p class="text-justify ml-5">A continuación se anuncian aquellas cookies de funcionalidad y analíticas más comunes utilizadas por los proveedores generales para su conocimiento.</p>
                            <div class="table-responsive" id="mostrarTabla">
                                <table class="table table-hover" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>NOMBRE</th>
                                            <th>FINALIDAD</th>
                                            <th>CADUCIDAD</th>
                                            <th>PROVEEDOR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>_ga</th>
                                            <td>Calcular los datos de visitantes, sesiones, campañas y realizar un seguimiento del uso del sitio para el informe analítico del sitio.</td>
                                            <td>2 años</td>
                                            <td>Google</td>
                                        </tr>
                                        <tr>
                                            <th>_uid</th>
                                            <td>Almacenar información sobre el uso que hacen los visitantes de un sitio web y ayuda a crear un informe analítico sobre el funcionamiento del sitio web.</td>
                                            <td>1 día</td>
                                            <td>Google</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h1 class="h5 mb-2 ml-5 text-gray-900 text-left">III. Cookies publicitarias y de redes sociales: Recordarán sus preferencias de productos y compras y nos ayudan de otras formas en las iniciativas de marketing.</h1>
                            <p class="text-justify ml-5">A continuación se anuncian aquellas cookies publicitarias más comunes utilizadas por los proveedores generales para su conocimiento.</p>
                            <div class="table-responsive" id="mostrarTabla">
                                <table class="table table-hover" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>NOMBRE</th>
                                            <th>FINALIDAD</th>
                                            <th>CADUCIDAD</th>
                                            <th>PROVEEDOR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>firebase-installations-database#firebase-installations-store</th>
                                            <td>Conocer el número de descargas e interacciones con el sitio web.</td>
                                            <td>3 meses</td>
                                            <td>Google</td>
                                        </tr>
                                        <tr>
                                            <th>_id_</th>
                                            <td>Registrar para el proveedor una identificación única, generando una relación usuario dispositivo en función de identificación de anuncios de interés. </td>
                                            <td>179 días</td>
                                            <td>Salesforce</td>
                                        </tr>
                                        <tr>
                                            <th>DoubleClick Floodlight</th>
                                            <td>Permiten comprender si ha realizado ciertas acciones en nuestros sitios web después de ver o haber hecho clic en uno de nuestros anuncios o vídeos que aparecen en Google u otras plataformas a través de DoubleClick.</td>
                                            <td>1 mes</td>
                                            <td>Hellman & Friedman y Google</td>
                                        </tr>
                                        <tr>
                                            <th>Media IQ Pixel</th>
                                            <td>Tecnología de píxeles para realizar el seguimiento de las interacciones multimedia</td>
                                            <td>2 años</td>
                                            <td>Hellman & Friedman y Google</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="text-justify ml-5">Todas las anteriores y aquellas conducentes no especificadas, tienen fecha de caducidad, que puede oscilar desde el tiempo que dura la sesión o visita al sitio web hasta una fecha específica a partir de la cual dejan de ser operativas. Las cookies empleadas en las Plataformas se asocian únicamente con un usuario anónimo y su equipo informático, no proporcionan referencias que permitan deducir el nombre y apellidos del usuario, no pueden leer datos de su disco duro ni incluir virus en sus textos.</p>
                            <p class="text-justify ml-5">Puedes configurar tu navegador para aceptar o rechazar automáticamente todas las cookies o para recibir un aviso en pantalla sobre la recepción de cada cookie y decidir en ese momento su implantación o no en tu disco duro. Te sugerimos consultar la sección de ayuda de tu navegador para saber cómo cambiar la configuración sobre aceptación o rechazo de cookies. Aún y cuando configures tú navegador para rechazar todas las cookies o rechaces expresamente las cookies de las Plataformas, podrás seguir navegando por el sitio web con el único inconveniente de no poder disfrutar de las funcionalidades del sitio que requieran la instalación de alguna de ellas. En todo caso, podrás eliminar las cookies instaladas en tu disco duro, en cualquier momento, siguiendo el procedimiento establecido en la sección de ayuda de tu navegador o mediante los siguientes links directos de acuerdo al mismo:</p>
                            <div class="table-responsive" id="mostrarTabla">
                                <table class="table table-hover" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>NAVEGADOR</th>
                                            <th>ENLACE DIRECTO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Internet Explorer</td>
                                            <td><a href="https://support.microsoft.com/help/17442/windows-internet-explorer-delete-manage-cookies" target="_blank">https://support.microsoft.com/help/17442/windows-internet-explorer-delete-manage-cookies</a></td>
                                        </tr>
                                        <tr>
                                            <td>Mozilla Firefox</td>
                                            <td><a href="http://support.mozilla.com/en-US/kb/Cookies">http://support.mozilla.com/en-US/kb/Cookies</a></td>
                                        </tr>
                                        <tr>
                                            <td>Google</td>
                                            <td><a href="http://www.google.com/support/chrome/bin/answer.py?hl=en&answer=95647">http://www.google.com/support/chrome/bin/answer.py?hl=en&answer=95647</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="text-justify ml-5">Para revisar las configuraciones y en su caso deshabilitarlas, use la pestaña ‘Ayuda’ (Help), o busque en ‘Herramientas’ (Tools) la configuración de ‘Opciones’ (Options) o ‘Privacidad’ (Privacy) de su navegador. Desde allí, puede eliminar las cookies, o controlar en qué caso usted permite instalarlas. Hay algunos navegadores que permiten instalar herramientas software complementarias (add-on software tools) para bloquear, eliminar o controlar las cookies. Y generalmente, los programas de seguridad incluyen opciones para facilitar el control de las cookies.</p>
                            <p class="text-justify ml-5">Es importante que sepas que puedes comunicarte en todo momento con nosotros a través de los medios de contacto que ponemos a tu disposición en el sitio web <a href="https://www.velor.mx/" target="_blank">https://www.velor.mx/</a> y con gusto te brindaremos asesoría sobre el procedimiento para revocar dichos consentimientos desde tu dispositivo.</p>
                            <p class="text-justify ml-5">Por lo anterior te confirmamos que "EL RESPONSABLE", no recaba datos personales a través de estos medios, por lo que no se someten a tratamiento ni a transferencias por parte de “LA EMPRESA”.</p>
                        <br>
                        
                        <h1 class="h4 mb-2 text-gray-900 text-left">VIII.- APLICABILIDAD Y ENLACES CON OTROS PORTALES WEB DE TERCEROS.</h1>
                        <p class="text-justify">Los Portales de “LA EMPRESA”  pueden contener enlaces hacia o desde portales web de nuestras redes de socios, de anunciantes, terceros y afiliados. Estos enlaces son sólo para fines informativos. Cuando siga un enlace a cualquiera de estas aplicaciones y/o a cualquiera de estos portales web, tenga en cuenta que incorporan sus propias políticas de privacidad y que por lo tanto, no podemos asumir ninguna responsabilidad ni respaldar ninguna práctica derivada de sus políticas.</p>
                        <br>
                        
                        <h1 class="h4 mb-2 text-gray-900 text-left">IX.- DATOS PERSONALES RECABADOS Y CATEGORÍAS DE LOS MISMOS, SUJETOS A TRATAMIENTO DE LA EMPRESA</h1>
                        <p class="text-justify">En “LA EMPRESA” recogemos diferentes datos personales directamente de sus titulares de índole identificativo, de contacto, laboral, comercial, patrimonial y económico financieros a través de los medios de recabación de datos personales establecidos en el presente AVISO DE PRIVACIDAD, que para su correcto tratamiento y protección podrán ser divididos en 3 categorías.</p>
                        <div class="table-responsive" id="mostrarTabla">
                            <table class="table table-hover" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>DATOS PERSONALES</th>
                                        <th>DATOS FINANCIEROS</th>
                                        <th>DATOS PERSONALES SENSIBLES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <ol type="I">
                                                <li>I. Nombre.</li>
                                                <li>II. Domicilio.</li>
                                                <li>III. Correo electrónico.</li>
                                                <li>IV. RFC.</li>
                                                <li>V. Número telefónico. fijo o celular.</li>
                                                <li>VI. Edad.</li>
                                                <li>VII. Fecha de nacimiento.</li>
                                                <li>VIII. Demás conducentes.</li>
                                            </ol>
                                        </td>
                                        <td>
                                            <ol type="I">
                                                <li>I. Información de pago.</li>
                                                <li>II. Dirección de facturación.</li>
                                                <li>III. Registro y Alta ante IMSS, INFONAVIT, Hacienda Federal y Estatal.</li>
                                                <li>IV. Demás conduces.</li>
                                            </ol>
                                        </td>
                                        <td>Se hace de su conocimiento que “LA EMPRESA” no trata datos sensibles consistentes en los enumerados en el artículo 3 fracción IV de la Ley Federal de Datos Personales en Posesión de Particulares a través de ninguno de sus medios de recabación de datos personales.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="text-justify">De igual forma se hace de su conocimiento que con respecto a lo establecido en el artículo 162 fracción VII de la Ley Aduanera, se creará un  expediente de operaciones aduaneras consistentes en despacho de mercancías de importación y/o exportación o cualquier otra actividad en materia por parte de “LA EMPRESA”.</p>
                        <br>
                        
                        <h1 class="h4 mb-2 text-gray-900 text-left">X.- FINALIDADES A QUE SE SUJETARA EL TRATAMIENTO DE DATOS PERSONALES.</h1>
                        <p class="text-justify">Como requisito esencial para el funcionamiento legal y administrativo de “LA EMPRESA” los datos personales recabados, en sus distintas categorías, tendrán funciones propias específicas de acuerdo a su naturaleza, dividiéndose en dos.</p>
                        <p class="text-justify">Finalidades primarias de tratamiento.</p>
                        <ol type="I">
                            <li>I. Acreditar y verificar su identidad conforme a nuestros procedimientos y políticas.</li>
                            <li>II. Integración de expediente de información de nuestro cliente.</li>
                            <li>III. Realizar procesos administrativos relacionados a la gestión, control, administración y procesamiento de servicios solicitados por los clientes, así como su debida calendarización y revisión.</li>
                            <li>IV. Realizar reportes, predicciones y análisis en relación con el uso y calidad de los Servicios.</li>
                            <li>V. Atender y dar seguimiento a investigaciones y revisiones de quejas y/o reclamaciones relacionadas con la detección, prevención y combate de conductas que pudieran contravenir lo dispuesto en la normatividad aplicable y/o con los Servicios que ofrecemos.</li>
                            <li>VI. Dar cumplimiento a la obligación   de cooperación con instancias de seguridad y justicia en términos de lo dispuesto por la normatividad aplicable, así como a los requerimientos de autoridades competentes en los casos legalmente previstos.</li>
                        </ol>
                        <p class="text-justify">Finalidades secundarias de tratamiento.</p>
                        <ol type="I">
                            <li>I. Proporcionarle información referente a lanzamiento de nuevos productos o modalidades de servicios ofrecidos por LA EMPRESA y demás fines mercadotécnicos publicitarios mediante llamadas telefónicas, correos electrónicos y demás medios de comunicación físicos o electrónicos.</li>
                            <li>II. Generar perfiles y hábitos de consumo para que  nuestros socios comerciales puedan contactarlo y enviarle información de carácter publicitario, promocional y/o informativo que consideren de su interés.</li>
                            <li>III. Uso de imágenes y testimonios de clientes titulares para fines publicitarios y de ofertas comerciales referentes a productos o servicios ofrecidos o relacionados con los productos o servicios contratados.</li>
                            <li>IV. Mejoras en el servicio de atención y trato al cliente.</li>
                        </ol>
                        <p class="text-justify">En el caso de que usted no desee que se utilicen sus datos con fines secundarios de tratamiento, por favor seleccione la siguiente casilla:</p>
                        <!-- <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="checkbox1">
                            <p class="text-justify">No deseo que mis datos sean utilizados con fines secundarios de tratamiento descritos anteriormente.</p>
                        </div> -->
                        <div class="row">
                            <div class="col">
                                <?php
                                    if ($resAP['fines_secundarios'] == 1) {
                                ?>
                                        <input type="checkbox" class="form-control" name="finesSecundarios" checked>
                                <?php
                                    } else {
                                ?>
                                        <input type="checkbox" class="form-control" name="finesSecundarios">
                                <?php
                                    }
                                ?>
                                <p class="text-center">No deseo que mis datos sean utilizados con fines secundarios de tratamiento descritos anteriormente.</p>
                            </div>
                        </div>
                        <br>
                        
                        <h1 class="h4 mb-2 text-gray-900 text-left">XI.-TRASFERENCIA DE DATOS PERSONALES.</h1>
                        <p class="text-justify">Le informamos que sus datos personales son compartidos con las personas, empresas, organizaciones y autoridades distintas al sujeto obligado en México o el extranjero en función de cualquier prospecto, comprador potencial o adquirente de “LA EMPRESA” o cualquiera de sus activistas, autoridades u auditores internos o externos con fines de realización de auditoría correspondiente, proveedores o prestadores de servicios de cobranza, análisis de riesgo crediticio  y demás conducentes, consistentes en:</p>
                        <div class="table-responsive" id="mostrarTabla">
                            <table class="table table-hover" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th colspan="4"><center><img src="img/logoTabla.png" style="width: 100px;"><br>LISTADO DE EMPRESAS, ORGANIZACIONES Y AUTORIDADES DISTINTAS A “LA EMPRESA”.</center></th>
                                    </tr>
                                </thead>
                                <thead>
                                    <tr>
                                        <th>DESTINATARIO DE DATOS PERSONALES</th>
                                        <th>PAÍS</th>
                                        <th>ENCARGADO DIRECTO</th>
                                        <th>FINALIDAD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Cualquier sociedad que se encuentre bajo alguno de los supuestos establecidos en los términos de la fracción III del artículo 37 de la Ley Federal de Protección de Datos Personales en Posesión de los Particulares, respecto de “LA EMPRESA”.</td>
                                        <td>MÉXICO</td>
                                        <td>VERÓNICA BEJAR GARIBAY</td>
                                        <td>Para las finalidades para las cuales fueron recabados y de conformidad con el presente Aviso de Privacidad.</td>
                                    </tr>
                                    <tr>
                                        <td>Terceros que presten el servicio de hosting del sitio web y terceros relacionados con dicho proveedor, incluyendo enunciativamente operadores y/o licenciatarios relacionados.</td>
                                        <td>MÉXICO</td>
                                        <td>________________</td>
                                        <td>Prestación de servicios contratados.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="text-justify">En el caso de que usted no desee que se utilicen sus datos con fines de trasferencia, por favor seleccione la siguiente casilla:</p>
                        <!-- <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="checkbox1">
                            <p class="text-justify">No deseo que mis datos sean utilizados con fines secundarios de tratamiento descritos anteriormente.</p>
                        </div> -->
                        <div class="row">
                            <div class="col">
                                <?php
                                    if ($resAP['transferencia_datos'] == 1) {
                                ?>
                                        <input type="checkbox" class="form-control" name="transferenciaDatos" checked>
                                <?php
                                    } else {
                                ?>
                                        <input type="checkbox" class="form-control" name="transferenciaDatos">
                                <?php
                                    }
                                ?>
                                <p class="text-center">No deseo que mis datos sean utilizados con fines secundarios de tratamiento descritos anteriormente.</p>
                            </div>
                        </div>
                        <br>
                        
                        <h1 class="h4 mb-2 text-gray-900 text-left">XII.- TRANSFERENCIA DE DATOS PERSONALES SIN PREVIO CONSENTIMIENTO DEL TITULAR.</h1>
                        <p class="text-justify">“LA EMPRESA” le informa que, de conformidad con lo dispuesto por el artículo 37 de la Ley Federal de Protección de Datos Personales en Posesión de los Particulares, podrá transferir sus datos personales, sin su consentimiento, en los casos que a continuación se especifican:</p>
                        <ol type="I">
                            <li>I. Cuando la transferencia esté prevista en una Ley o Tratado en los que México sea parte.</li>
                            <li>II. Cuando la transferencia sea necesaria para la prevención o el diagnóstico médico, la prestación de asistencia sanitaria, tratamiento médico o la gestión de servicios sanitarios.</li>
                            <li>III. Cuando la transferencia sea efectuada a sociedades controladoras, subsidiarias o afiliadas bajo el control común del responsable, o a una sociedad matriz o a cualquier sociedad del mismo grupo del responsable que opere bajo los mismos procesos y políticas internas.</li>
                            <li>IV. Cuando la transferencia sea necesaria por virtud de un contrato celebrado o por celebrar en interés del titular, por el responsable y un tercero.</li>
                            <li>V. Cuando la transferencia sea necesaria o legalmente exigida para la salvaguarda de un interés público, o para la procuración o administración de justicia.</li>
                            <li>VI. Cuando la transferencia sea precisa para el reconocimiento, ejercicio o defensa de un derecho en un proceso judicial.</li>
                            <li>VII. Cuando la transferencia sea precisa para el mantenimiento o cumplimiento de una relación jurídica entre el responsable y el titular.</li>
                        </ol>
                        <br>
                        
                        <h1 class="h4 mb-2 text-gray-900 text-left">XIII.- MEDIOS, MECANISMOS Y PROCEDIMIENTOS  PARA EL EJERCICIO DE DERECHOS A.R.C.O.</h1>
                        <p class="text-justify">De conformidad con lo establecido en el artículo 28 de la Ley Federal de Protección de Datos Personales en Posesión de los Particulares, nuestros clientes o su representante legal podrá ejercer cualquiera de los derechos de acceso, rectificación, cancelación u oposición también conocidos como DERECHOS A.R.C.O. así como revocar su consentimiento para el tratamiento de sus datos personales enviando un correo electrónico a <a href="mailto: administracion@velor.mx">administracion@velor.mx</a> donde se le atenderá con la mayor eficiencia y eficacia posible.</p>
                        <p class="text-justify">Su petición deberá ser realizada mediante el formulario proporcionado por LA EMPRESA en su dirección web <a href="https://www.velor.mx/" target="_blank">https://www.velor.mx/</a> que cumple con lo establecido en los requisitos del artículo 29 de la Ley Federal de Protección de Datos Personales en Posesión de los Particulares, mismo que establece que con finalidad de que “LA EMPRESA”  pueda darle seguimiento a su solicitud, usted o su representante legal, deberá acreditar correctamente su identidad, para lo que es necesario que complete todos los campos indicados en el Formulario y lo acompañe con copia de alguna de las identificaciones oficiales vigentes que se señalan en el mismo de forma electrónica.</p>
                        <p class="text-justify">En caso de que la información proporcionada en el Formulario sea errónea o insuficiente, o bien, no se acompañen los documentos de acreditación correspondientes “LA EMPRESA” podrá requerir dichos documentos o datos mediante el correo electrónico <a href="mailto: administracion@velor.mx">administracion@velor.mx</a> dentro de los siguientes 15 días hábiles a la recepción de su solicitud, teniendo el titular 15 días hábiles para dar respuesta a dicho requerimiento. En caso de  no dar respuesta en dicho plazo, se tendrá por no presentada la solicitud correspondiente.</p>
                        <p class="text-justify">Posteriormente “LA EMPRESA” comunicará la determinación adoptada mediante el correo electrónico <a href="https://www.velor.mx/" target="_blank">https://www.velor.mx/</a> en un plazo máximo de veinte 20 días hábiles contados desde la fecha en que se recibió la solicitud y en su caso, desde la fecha en que se recibió el requerimiento adhesivo a su solicitud de conformidad con la ley, a efecto de que, si resulta procedente, haga efectiva la misma dentro de los 15  días hábiles siguientes a que se comunique la respuesta. Los plazos antes referidos podrán ser ampliados una sola vez por un periodo igual, siempre y cuando existan circunstancias de caso fortuito o fuerza mayor, entendiéndose las mismas a factores dependientes de personal, clientes, o bienes, con respecto a cualquier lesión o daño a personas o  propiedades, por cualquier acto, omisión, circunstancia o cualquier otro motivo derivado, incluyendo sin limitar, huelgas, paros, motines, conmociones civiles, acciones militares, disposiciones o controles gubernamentales o cualquier otra causa no imputable directamente a las  partes.</p>
                        <br>
                        
                        <h1 class="h4 mb-2 text-gray-900 text-left">XIV.-CAMBIOS AL AVISO DE PRIVACIDAD Y MEDIOS DE NOTIFICACIÓN.</h1>
                        <p class="text-justify">“LA EMPRESA” se reserva el derecho, bajo su exclusivo análisis, de cambiar, modificar, agregar o eliminar partes del presente AVISO DE PRIVACIDAD en cualquier momento. En tal caso, “LA EMPRESA” mantendrá su AVISO DE PRIVACIDAD vigente en el sitio web <a href="https://www.velor.mx/" target="_blank">https://www.velor.mx/</a> por lo cual, le recomendamos visitar constantemente esta página con la finalidad de informarse si ocurre algún cambio al presente AVISO DE PRIVACIDAD.</p>
                        <p class="text-justify">De igual forma si usted lo solicita, se le hará llegar una notificación referente a cambios, modificaciones o supresiones del mismo al seleccionar la siguiente casilla.</p>
                        <div class="row">
                            <div class="col">
                                <?php
                                    if ($resAP['cambios_aviso'] == 1) {
                                ?>
                                        <input type="checkbox" class="form-control" name="cambiosAviso" checked>
                                <?php
                                    } else {
                                ?>
                                        <input type="checkbox" class="form-control" name="cambiosAviso">
                                <?php
                                    }
                                ?>
                                <p class="text-center">Solicito se me avise vía correo electrónico proporcionado a “LA EMPRESA” cualquier cambio, modificación o supresión del presente aviso de privacidad.</p>
                            </div>
                        </div>
                        <br>
                        
                        <h1 class="h4 mb-2 text-gray-900 text-left">XV.-POLÍTICAS DE SEGURIDAD.</h1>
                        <p class="text-justify">“LA EMPRESA” protege tus datos personales usando el estándar de la industria en materia de encriptación, de esta forma garantizamos que los datos que se envían desde la página de Internet lleguen seguros a nuestros servidores. Almacenamos y procesamos tu información manteniendo siempre medidas de seguridad orientadas a proteger tus datos personales.</p>
                        <p class="text-justify">Contamos con procedimientos que dictan quién y bajo qué condiciones se puede tener acceso a los datos, dando siempre la máxima prioridad a la protección de tu privacidad. Asimismo, asumimos medidas de seguridad físicas para prevenir el acceso no autorizado a nuestros sistemas e instalaciones.</p>
                        <br>
                        
                        <h1 class="h4 mb-2 text-gray-900 text-left">XV.- PLAZO DE CONSERVACIÓN DE DATOS PERSONALES POR PARTE DE LA EMPRESA.</h1>
                        <p class="text-justify">“LA EMPRESA” informa, que de acuerdo al artículo 25 de la Ley Federal de Protección de Datos Personales en Posesión de los Particulares conservará en caso de cancelación o rescisión de las relaciones entre ambos los datos personales de los clientes exclusivamente para efectos de las responsabilidades nacidas del tratamiento, en un plazo máximo de 2 años antes de la supresión total del dato, avisando al titular una vez terminado dicho periodo de bloqueo, quedando sin responsabilidad de bloqueo de datos por parte de LA EMPRESA en los casos en que:</p>
                        <ol type="I">
                            <li>I. Se refieran a las partes de un contrato privado, social o administrativo y sean necesarias para su desarrollo y cumplimiento.</li>
                            <li>II. Deben ser tratados por disposición legal.</li>
                            <li>III. Obstaculice actuaciones judiciales o administrativas vinculadas a obligaciones fiscales, la investigación y persecución de delitos o la actualización de sanciones administrativas.</li>
                            <li>IV. Sean necesarios para proteger los intereses jurídicamente tutelados del titular.</li>
                            <li>V. Sean necesarios para realizar una acción en función del interés público.</li>
                            <li>VI. Sean necesarios para cumplir con una obligación legalmente adquirida por el titular.</li>
                            <li>VII. Sean objeto de tratamiento para la prevención o para el diagnóstico médico o la gestión de servicios de salud, siempre que dicho tratamiento se realice por un profesional de la salud sujeto a un deber de secreto.</li>
                        </ol>
                        <p class="text-justify">En lo referente a la conservación de datos personales durante la vigencia de las relaciones entre ambos, estos durarán el equivalente a la misma o indefinida mientras el titular no manifieste su voluntad de darse de baja de los servicios proporcionados por “LA EMPRESA”</p>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <?php
                                    if ($resAP['aviso_leido'] == 1) {
                                ?>
                                        <input type="checkbox" class="form-control" name="avisoLeidoAceptado" checked>
                                <?php
                                    } else {
                                ?>
                                        <input type="checkbox" class="form-control" name="avisoLeidoAceptado">
                                <?php
                                    }
                                ?>
                                <p class="text-center">Reconozco que he leído y entiendo el alcance y significado del presente aviso a lo cual manifiesto mi consentimiento, así como de los mecanismos que la Ley Federal de Protección de Datos Personales en Posesión de los Particulares, su Reglamento, los Lineamientos y el presente AVISO DE PRIVACIDAD me confieren para el ejercicio de mis derechos de acceso, rectificación, cancelación y oposición, así como de la limitación del uso, transferencia y divulgación de mis datos que pueda realizar LA EMPRESA.</p>
                            </div>
                        </div>
                        <br>

                        <div class="table-responsive" id="mostrarTabla">
                            <table class="table table-hover" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="d-flex justify-content-around">
                                                <img src="img/logoTabla.png" style="width: 100px;">
                                                <p>GRUPO DE INNOVACION EN TECNOLOGIA Y CONSULTORIA VELOR, S.A. DE C.V. <br> FORMULARIO PARA EL EJERCICIO DE DERECHOS A.R.C.O.</p>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <thead>
                                    <tr>
                                        <th><p class="text-justify">El presente formulario deberá ser llenado por el usuario titular de los datos personales o bien por su representante legal, proporcionando en todo momento dicha información solicitada sin abreviaturas ni errores.</p></th>
                                    </tr>
                                </thead>
                                <thead>
                                    <tr>
                                        <th><p class="text-center">INFORMACIÓN DEL TITULAR</p></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="row pt-3 pb-4">
                                                <div class="col-4 mt-4">
                                                    <small>Apellido Paterno:</small>
                                                    <input type="text" class="form-control" name="apellidoPaterno" required value="<?php echo $resAP['primer_apellido']; ?>" maxlength="50">
                                                </div>
                                                <div class="col-4 mt-4">
                                                    <small>Apellido Materno:</small>
                                                    <input type="text" class="form-control" name="apellidoMaterno" required value="<?php echo $resAP['segundo_apellido']; ?>" maxlength="50">
                                                </div>
                                                <div class="col-4 mt-4">
                                                    <small>Nombre:</small>
                                                    <input type="text" class="form-control" name="nombre" required value="<?php echo $resAP['nombre_representante']; ?>" maxlength="50">
                                                </div>
                                                <div class="col-4 mt-4">
                                                    <small>Teléfono Celular:</small>
                                                    <input type="text" class="form-control" name="telefono" required value="<?php echo $resAP['telefono']; ?>" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" maxlength="10">
                                                </div>
                                                <div class="col-4 mt-4">
                                                    <small>Domicilio:</small>
                                                    <input type="text" class="form-control" name="domicilio" required value="<?php echo $resAP['domicilio']; ?>" maxlength="350">
                                                </div>
                                                <div class="col-4 mt-4">
                                                    <small>Correo Electrónico para Recepción de Respuesta a Solicitud:</small>
                                                    <input type="text" class="form-control" name="correo" required value="<?php echo $resAP['correo']; ?>" maxlength="50">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <center><button type="submit" class="btn btn-primary">Guardar</button></center>
                    </form>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php
                include("estructura/pie.php");
            ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

<?php
    } elseif (isset($usuario) && $nivelUsuario == 1 || $nivelUsuario == 3 || $nivelUsuario == 4) {
        header("location: panel2.php");
    }
    mysqli_close($conexion);
?>

</body>
</html>