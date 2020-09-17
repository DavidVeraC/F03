<?php 
session_start();
require 'includes/templates/header.php';
require 'includes/funciones/funciones.php';?>
<div class="container-fluid">

    <!-- <div class="col-lg-12 p-0">
        <div class="contenedorBanner">
        </div>
    </div> -->
    

    <div class="col-lg-12 bg-light">
             
        <div class="d-flex flex-wrap justify-content-xl-between">
            <div class="titulo d-flex align-items-center p-4" style="padding-top:20px">
                <span class="font-weight-bold p-2" style="font-family: 'Lato', sans-serif;font-size:28px;">Buscar  -  Producto</span>
            </div>

          <!-- BUSCAR -->
            <form action="productos.php" method="post">
                <div class="input-group">
                    <input class="form-control" type="text" name="txtBuscarProducto" placeholder="Ingrese el nombre">
                    <div class="input-group-append">
                        <button id="botonBuscar" class="btn btn-primary" type="submit"><i class="fa fa-search mr-1" aria-hidden="true"></i></button>
                    </div>
                </div>
            </form>
        </div>

        <div class="tabla">
            <!-- TABLA DE PRODUCTOS -->
            <div class="d-flex row p-0 justify-content-center">
              <?php if(isset($_POST['txtBuscarProducto']) == true):?>
                    <?php $buscar_producto = $_POST['txtBuscarProducto'];
                        if(!empty($buscar_producto)):?>
                         <?php
                           //TRAYENDO LOS DATOS DEL PRODUCTO ENCONTRADO    
                           $resultado = buscarProducto($buscar_producto);
                           $productosE = $resultado->fetchAll();
                         ?>

                          <!-- PRODUCTO NO ENCONTRADO  EN LA BD-->
                          <?php if($productosE == false): ?>
                                <div class="alert alert-danger" style="display:block;width:100%;" role="alert">Error ... ! Producto no encontrado</div>
                          <?php endif;?>

                         <!-- PRODUCTO ENCONTRADO EN LA BD-->
                         <?php foreach($productosE as $productoE):?>
                            <div class="card m-3" style="width: 18rem;"> 
                                <a href="descripcion-producto.php?id=<?php echo $productoE['IdProducto'];?>"><img src="data:image/jpg;base64,<?php echo base64_encode($productoE['Imagen']) ; ?>" class="card-img-top" alt="Imagen del Producto" width="200"></a>
                                <div class="card-body text-center"> 
                                    <p class="nombre"><?php echo $productoE['Nombre'] . ' '. $productoE['Marca'];?></p>
                                    <p class="descripcion"><?php echo $productoE['Descripcion']?></p>
                                    <p class="precio">s/<?php echo $productoE['Precio']?></p>
                                </div>
                            </div>
                         <?php endforeach;?>

                        <?php else:?>
                          <!-- BUSCADOR VACIO -->
                          <div class="alert alert-danger mx-3" style="display:block;width:100%;" role="alert">
                            Error ... ! Ingrese el nombre del producto   
                          </div>
                        <?php endif;?>
                        
              <?php endif;?>
              
              <!-- LISTADO POR DEFECTO -->
              <?php $productos = listarProductos();
                foreach($productos as $producto): ?>
                    <?php if(isset($_POST['txtBuscarProducto']) == false):?>
                
                        <div class="card m-3" style="width: 18rem;"> 
                            <a href="descripcion-producto.php?id=<?php echo $producto['IdProducto'];?>" id="producto:<?php $producto['IdProducto']?>"><img src="data:image/jpg;base64,<?php echo base64_encode($producto['Imagen']) ; ?>" class="card-img-top" alt="Imagen del Producto" width="200"></a>
                            <div class="card-body text-center"> 
                                <p class="nombre"><?php echo $producto['Nombre'] . ' '. $producto['Marca'];?></p>
                                <p class="descripcion"><?php echo $producto['Descripcion']?></p>
                                <p class="precio">s/<?php echo $producto['Precio']?></p>
                            </div>
                        </div>
                    <?php endif; ?>       
          <?php endforeach; ?>
            </div>

            <!-- PAGINACION -->
            <div class="d-flex justify-content-center p-3 mt-3">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php 
                              global $producto_por_pagina;
                              global $pagina_actual;
                             
                              $total_paginas = totalPaginas();;
                             
                        ?>
                        <!-- ESTABLECEMOS EL BOTON Previus -->
                        <?php if($pagina_actual == 1):?>
                        <li class="page-item disabled"><a class="page-link" href="#" aria-disabled="true">&laquo</a></li>
                        <?php else: ?>
                        <li class="page-item"><a class="page-link" href="?pagina_actual=<?php echo $pagina_actual - 1 ?>">&laquo</a></li>
                        <?php endif;?>
                        <!-- ESTABLECEMOS EL CICLO -->
                        <?php
                         for($i = 1; $i <= $total_paginas; $i++){
                            if($pagina_actual == $i){
                             echo "<li class='page-item active' aria-current='page'><a class='page-link' href='?pagina_actual=$i'>$i</a></li>"; 
                            }else{
                             echo "<li class='page-item'><a class='page-link' href='?pagina_actual=$i'>$i</a></li>";
                            }
                         }
                        ?>
                        <!-- ESTABLECEMOS EL BOTON  Next -->
                        <?php if($pagina_actual == $total_paginas): ?>
                            <li class="page-item disabled"><a class="page-link" href="#" aria-disabled="true">&raquo;</a></li>
                        <?php else: ?>
                            <li class="page-item"><a class="page-link" aria-disabled="true" href="?pagina_actual=<?php echo $pagina_actual + 1?>">&raquo;</a></li>
                        <?php endif; ?>
                       
                    </ul>
                </nav>
            </div>
        </div>
                     
    </div>

</div>
<?php require 'includes/templates/footer.php';?>