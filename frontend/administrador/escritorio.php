<?php
ob_start();
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('location: ../erro404.php');
}
?>
<?php if (isset($_SESSION['id'])) { ?>

    <?php include_once "../templates/header.php" ?>

    <!-- Page Content  -->
    <div id="content">
        <div class="top-navbar">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="d-xl-block d-lg-block d-md-mone d-none">
                        <span class="material-icons">arrow_back_ios</span>
                    </button>

                    <a class="navbar-brand" href="escritorio.php"> Panel administrativo </a>

                    <button class="d-inline-block d-lg-none ml-auto more-button" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="material-icons">more_vert</span>
                    </button>

                    <div class="collapse navbar-collapse d-lg-block d-xl-block d-sm-none d-md-none d-none" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="../cuenta/configuracion.php">
                                    <span class="material-icons">settings</span>
                                </a>
                            </li>
                            <li class="dropdown nav-item active">
                                <a href="#" class="nav-link" data-toggle="dropdown">

                                    <img src="../../backend/img/reere.png">

                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="../cuenta/perfil.php">Mi perfil</a>
                                    </li>
                                    <li>
                                        <a href="../cuenta/salir.php">Salir</a>
                                    </li>

                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>
        </div>


        <div class="main-content">

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-warning">
                                <span class="material-icons">group</span>
                            </div>
                        </div>
                        <div class="card-content">
                            <?php
                            require '../../backend/bd/ctconex.php';
                            $sql = "SELECT COUNT(*) total FROM clientes";
                            $result = $connect->query($sql); //$pdo sería el objeto conexión
                            $total = $result->fetchColumn();

                            ?>
                            <p class="category"><strong>Clientes</strong></p>
                            <h3 class="card-title"><?php echo  $total; ?></h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">update</i> Recién actualizado
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-rose">
                                <span class="material-icons">conveyor_belt</span>

                            </div>
                        </div>
                        <div class="card-content">
                            <p class="category"><strong>Productos</strong></p>
                            <?php

                            $sql = "SELECT COUNT(*) total FROM producto";
                            $result = $connect->query($sql); //$pdo sería el objeto conexión
                            $total = $result->fetchColumn();

                            ?>
                            <h3 class="card-title"><?php echo  $total; ?></h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">update</i> Recién actualizado
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-success">
                                <span class="material-icons">
                                    point_of_sale
                                </span>

                            </div>
                        </div>
                        <div class="card-content">
                            <?php
                            $sql = "SELECT SUM(total_price) total_price,placed_on FROM orders where placed_on = CURDATE()";
                            $result = $connect->query($sql); //$pdo sería el objeto conexión
                            $total_price = $result->fetchColumn();

                            ?>
                            <p class="category"><strong>Ventas de hoy</strong></p>
                            <h3 class="card-title">S/<?php echo  $total_price; ?> </h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">update</i> Recién actualizado
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-info">

                                <span class="material-icons">
                                    manage_accounts
                                </span>
                            </div>
                        </div>
                        <div class="card-content">
                            <?php

                            $sql = "SELECT COUNT(*) total FROM usuarios";
                            $result = $connect->query($sql); //$pdo sería el objeto conexión
                            $total = $result->fetchColumn();

                            ?>
                            <p class="category"><strong>Usuarios</strong></p>
                            <h3 class="card-title"><?php echo  $total; ?></h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">update</i> Recién actualizado
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row ">
                <div class="col-lg-7 col-md-12">
                    <div class="card" style="min-height: 485px">
                        <div class="card-header card-header-text">
                            <h4 class="card-title">Clientes recientes</h4>
                            <p class="category">Nuevos clientes reciente añadidos el dia de hoy</p>
                        </div>
                        <div class="card-content table-responsive">
                            <?php

                            $sentencia = $connect->prepare("SELECT * FROM clientes order BY idclie DESC;");
                            $sentencia->execute();

                            $data =  array();
                            if ($sentencia) {
                                while ($r = $sentencia->fetchObject()) {
                                    $data[] = $r;
                                }
                            }
                            ?>
                            <?php if (count($data) > 0) : ?>
                                <table class="table table-hover" id="example">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>ID</th>
                                            <th>Clientes</th>
                                            <th>Celular</th>
                                            <th>Correo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data as $g) : ?>
                                            <tr>
                                                <td><?php echo  $g->idclie; ?></td>
                                                <td><?php echo  $g->nomcli; ?> <?php echo  $g->apecli; ?></td>
                                                <td><?php echo  $g->celu; ?></td>
                                                <td><?php echo  $g->correo; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else : ?>
                                <!-- Warning Alert -->
                                <div class="alert alert-warning" role="alert">
                                    No se encontró ningún dato!
                                </div>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-md-12">
                    <div class="card" style="min-height: 485px">
                        <div class="card-header card-header-text">
                            <h4 class="card-title">Actividad reciente</h4>
                        </div>
                        <div class="card-content">
                            <div class="streamline">
                                <?php

                                $sentencia = $connect->prepare("SELECT servicio.idservc, plan.idplan, plan.foto, plan.nompla, servicio.ini, servicio.fin, clientes.idclie, clientes.numid, clientes.nomcli, clientes.apecli, clientes.naci, clientes.celu, clientes.correo, servicio.estod, servicio.fere FROM servicio INNER JOIN plan ON servicio.idplan = plan.idplan INNER JOIN clientes ON servicio.idclie = clientes.idclie order BY idservc DESC;");
                                $sentencia->execute();

                                $data =  array();
                                if ($sentencia) {
                                    while ($r = $sentencia->fetchObject()) {
                                        $data[] = $r;
                                    }
                                }
                                ?>
                                <?php if (count($data) > 0) : ?>
                                    <?php foreach ($data as $c) : ?>
                                        <div class="sl-item sl-primary">
                                            <div class="sl-content">
                                                <small class="text-muted"><?php echo  $c->fere; ?></small>
                                                <p><?php echo  $c->nompla; ?> añadido</p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <!-- Warning Alert -->
                                    <div class="alert alert-warning" role="alert">
                                        No se encontró ningún dato!
                                    </div>

                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-7 col-md-12">
                    <div class="card" style="min-height: 485px">
                        <div class="card-header card-header-text">
                            <h4 class="card-title">Productos recientes</h4>
                            <p class="category">Nuevos productos reciente añadidos el dia de hoy</p>
                        </div>
                        <div class="card-content table-responsive">
                            <?php

                            $sentencia = $connect->prepare("SELECT producto.idprod, producto.codba, producto.nomprd, categoria.idcate, categoria.nomca, producto.precio, producto.stock, producto.foto, producto.venci, producto.esta, producto.fere FROM producto INNER JOIN categoria ON producto.idcate = categoria.idcate order BY codba DESC;");
                            $sentencia->execute();

                            $data =  array();
                            if ($sentencia) {
                                while ($r = $sentencia->fetchObject()) {
                                    $data[] = $r;
                                }
                            }
                            ?>
                            <?php if (count($data) > 0) : ?>
                                <table class="table table-hover" id="example1">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Categoria</th>
                                            <th>Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data as $a) : ?>
                                            <tr>
                                                <td><?php echo  $a->idprod; ?></td>
                                                <td><?php echo  $a->nomprd; ?></td>
                                                <td><?php echo  $a->nomca; ?></td>
                                                <?php

                                                if ($a->stock <= 0) {

                                                    echo '<td><span class="badge badge-danger">stock vacio</span></td>';
                                                } elseif ($a->stock <= 5) {
                                                    echo '<td><span class="badge badge-warning">Está por acabarse</span></td>';
                                                } else {
                                                    echo '<td><span class="badge badge-success">' . $a->stock . '</span></td>';
                                                }
                                                ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else : ?>
                                <!-- Warning Alert -->
                                <div class="alert alert-warning" role="alert">
                                    No se encontró ningún dato!
                                </div>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-md-12">
                    <div class="card" style="min-height: 485px">
                        <div class="card-header card-header-text">
                            <h4 class="card-title">Estadística de productos</h4>
                        </div>
                        <div class="card-content">
                            <div id="piechart" class="tcentrado"></div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card" style="min-height: 485px">
                        <div class="card-header card-header-text">
                            <h4 class="card-title">Cumpleaños recientes</h4>
                        </div>
                        <div class="card-content">
                            <center><img src="../../backend/img/pastel-de-cumple.png" width='150' height='150' class="tcentrado"></center>
                            <br>
                            <?php

                            $sentencia = $connect->prepare("SELECT idclie, nomcli, apecli, naci, celu FROM clientes WHERE DAY(naci)=DAY(NOW()) AND MONTH(naci)=MONTH(NOW());");
                            $sentencia->execute();

                            $data =  array();
                            if ($sentencia) {
                                while ($r = $sentencia->fetchObject()) {
                                    $data[] = $r;
                                }
                            }
                            ?>
                            <?php if (count($data) > 0) : ?>
                                <?php foreach ($data as $g) : ?>
                                    <a href="../clientes/informacion.php?id=<?php echo $g->idclie; ?>" class="client-link">
                                        <p class="client-name"><?php echo $g->nomcli . ' ' . $g->apecli; ?></p>
                                    </a>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <!-- Warning Alert -->
                                <div class="alert alert-warning" role="alert">
                                    No se encontró ningún dato!
                                </div>
                            <?php endif; ?>



                        </div>

                    </div>
                </div>


                <div class="col-lg-12 col-md-12">
                    <div class="card" style="min-height: 485px">
                        <div class="card-header card-header-text">
                            <h4 class="card-title">Venta de hoy</h4>
                        </div>
                        <div class="card-content">
                            <div id="sale_values" height="50" wight="50"></div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card" style="min-height: 485px">
                        <div class="card-header card-header-text">
                            <h4 class="card-title">Venta de los servicios de hoy</h4>
                        </div>
                        <div class="card-content">
                            <div id="services_values" height="50" wight="50"></div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card" style="min-height: 485px">
                        <div class="card-header card-header-text">
                            <h4 class="card-title">Ingresos totales</h4>
                        </div>
                        <div class="card-content">
                            <div id="chart_div" height="50" wight="50"></div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card" style="min-height: 485px">
                        <div class="card-header card-header-text">
                            <h4 class="card-title">Gastos totales</h4>
                        </div>
                        <div class="card-content">
                            <div id="gast_div" height="50" wight="50"></div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../../backend/js/jquery-3.3.1.slim.min.js"></script>
    <script src="../../backend/js/popper.min.js"></script>
    <script src="../../backend/js/bootstrap.min.js"></script>
    <script src="../../backend/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="../../backend/js/sidebarCollapse.js"></script>

    <script src="../../backend/js/loader.js"></script>
    <!-- Data Tables -->
    <script type="text/javascript" src="../../backend/js/datatable.js"></script>
    <script type="text/javascript" src="../../backend/js/datatablebuttons.js"></script>
    <script type="text/javascript" src="../../backend/js/jszip.js"></script>
    <script type="text/javascript" src="../../backend/js/pdfmake.js"></script>
    <script type="text/javascript" src="../../backend/js/vfs_fonts.js"></script>
    <script type="text/javascript" src="../../backend/js/buttonshtml5.js"></script>
    <script type="text/javascript" src="../../backend/js/buttonsprint.js"></script>

    <script type="text/javascript" src="../../backend/js/example.js"></script>
    <script type="text/javascript" src="../../backend/js/example1.js"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="../../backend/js/chart/Chart.js"></script>
    <script>
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Articulo', 'Stock'],




                <?php

                $stmt = $connect->prepare("SELECT producto.idprod, producto.codba, producto.nomprd, categoria.idcate, categoria.nomca, producto.precio, producto.stock, producto.foto, producto.venci, producto.esta, producto.fere FROM producto INNER JOIN categoria ON producto.idcate = categoria.idcate");

                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();

                while ($row = $stmt->fetch()) {
                    echo "['" . $row['nomprd'] . "', " . $row['stock'] . "],";
                }

                ?>
            ]);
            var options = {

                //is3D:true,  
                pieHole: 0.4
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }
    </script>
    <script>
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Articulo', 'Stock'],


                <?php

                $stmt = $connect->prepare("SELECT * FROM clientes");

                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();

                while ($row = $stmt->fetch()) {
                    echo "['" . $row['apecli'] . "', " . $row['idclie'] . "],";
                }

                ?>
            ]);
            var options = {

                //is3D:true,  
                pieHole: 0.4
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechartcli'));
            chart.draw(data, options);
        }
    </script>

    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawStuff);

        function drawStuff() {
            var data = new google.visualization.arrayToDataTable([
                ['Fecha', 'Monto'],

                <?php
                $id = $_SESSION['id'];
                $stmt = $connect->prepare("SELECT SUM(total_price) total_price,placed_on FROM orders where placed_on = CURDATE()");

                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();

                while ($row = $stmt->fetch()) {
                    echo "['" . $row['placed_on'] . "', " . $row['total_price'] . "],";
                }

                ?>

            ]);

            var options = {
                width: 900,
                legend: {
                    position: 'none'
                },
                chart: {
                    title: '',
                    subtitle: ''
                },
                bars: 'horizontal', // Required for Material Bar Charts.
                axes: {
                    x: {
                        0: {
                            side: 'top',
                            label: 'Monto'
                        } // Top x-axis.
                    }
                },
                bar: {
                    groupWidth: "90%"
                }
            };

            var chart = new google.charts.Bar(document.getElementById('sale_values'));
            chart.draw(data, options);
        };
    </script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawStuff);

        function drawStuff() {
            var data = new google.visualization.arrayToDataTable([
                ['Fecha', 'Monto'],

                <?php
                $id = $_SESSION['id'];
                $stmt = $connect->prepare("SELECT servicio.idservc, plan.idplan, plan.prec,plan.foto, plan.nompla, servicio.ini, servicio.fin, clientes.idclie, clientes.numid, clientes.nomcli, clientes.apecli, clientes.naci, clientes.celu, clientes.correo, servicio.estod, servicio.fere, SUM(prec) as prec FROM servicio INNER JOIN plan ON servicio.idplan = plan.idplan INNER JOIN clientes ON servicio.idclie = clientes.idclie where servicio.ini = CURDATE()");

                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();

                while ($row = $stmt->fetch()) {
                    echo "['" . $row['ini'] . "', " . $row['prec'] . "],";
                }

                ?>

            ]);

            var options = {
                width: 900,
                legend: {
                    position: 'none'
                },
                chart: {
                    title: '',
                    subtitle: ''
                },
                bars: 'horizontal', // Required for Material Bar Charts.
                axes: {
                    x: {
                        0: {
                            side: 'top',
                            label: 'Monto'
                        } // Top x-axis.
                    }
                },
                bar: {
                    groupWidth: "90%"
                }
            };

            var chart = new google.charts.Bar(document.getElementById('services_values'));
            chart.draw(data, options);
        };
    </script>

    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawStuff);

        function drawStuff() {
            var data = new google.visualization.arrayToDataTable([
                ['Fecha', 'Monto'],

                <?php
                $id = $_SESSION['id'];
                $stmt = $connect->prepare("SELECT ingresos.iding, ingresos.detalle, ingresos.total, ingresos.fec, SUM(total) as total FROM ingresos");

                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();

                while ($row = $stmt->fetch()) {
                    echo "['" . $row['fec'] . "', " . $row['total'] . "],";
                }

                ?>

            ]);

            var options = {
                width: 900,
                legend: {
                    position: 'none'
                },
                chart: {
                    title: '',
                    subtitle: ''
                },
                bars: 'horizontal', // Required for Material Bar Charts.
                axes: {
                    x: {
                        0: {
                            side: 'top',
                            label: 'Monto'
                        } // Top x-axis.
                    }
                },
                bar: {
                    groupWidth: "90%"
                }
            };

            var chart = new google.charts.Bar(document.getElementById('chart_div'));
            chart.draw(data, options);
        };
    </script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawStuff);

        function drawStuff() {
            var data = new google.visualization.arrayToDataTable([
                ['Fecha', 'Monto'],

                <?php
                $id = $_SESSION['id'];
                $stmt = $connect->prepare("SELECT gastos.idga, gastos.detall, gastos.total, gastos.fec, SUM(total) as total FROM gastos 
");

                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();

                while ($row = $stmt->fetch()) {
                    echo "['" . $row['fec'] . "', " . $row['total'] . "],";
                }

                ?>

            ]);

            var options = {
                width: 900,
                legend: {
                    position: 'none'
                },
                chart: {
                    title: '',
                    subtitle: ''
                },
                bars: 'horizontal', // Required for Material Bar Charts.
                axes: {
                    x: {
                        0: {
                            side: 'top',
                            label: 'Monto'
                        } // Top x-axis.
                    }
                },
                bar: {
                    groupWidth: "90%"
                }
            };

            var chart = new google.charts.Bar(document.getElementById('gast_div'));
            chart.draw(data, options);
        };
    </script>

    <?php include_once "../templates/footer.php" ?>


<?php } else {
    header('Location: ../erro404.php');
} ?>
<?php ob_end_flush(); ?>