<?php 
    session_start();
    
    require 'includes/funciones/funciones.php';
    require 'includes/templates/header.php'; 



    if(isset($_SESSION['cesto']) == true &&
       isset($_SESSION['cestoCantidad']) == true  &&
       isset($_SESSION['cestosSub'])){
        $productos_cesto = $_SESSION['cesto'];
        $Cantidad = $_SESSION['cestoCantidad'];
        $Sub = $_SESSION['cestosSub'];
    }
?>
<div class="container-fluid p-3">
    <div class="d-flex flex-wrap justify-content-center justify-content-lg-between p-3 bg-white">
        <div class="titulo d-flex p-2 align-items-center">
            <span class="font-weight-bold" style="font-family: 'Lato', sans-serif;font-size:30px;"><img src="img/pedido.jpg" class="ml-3" width="50"> Lista de Pedido</span>
        </div>

        <!-- BUSCAR CLIENTE -->
        <form action="lista-pedido.php" method="post" class="p-3">
            <div class="input-group">
                <input class="form-control" type="text" name="txtBuscarCliente" placeholder="Ingrese DNI">
                <div class="input-group-append">
                    <button id="botonBuscar" class="btn btn-primary" type="submit"><i class="fa fa-search mr-1" aria-hidden="true"></i></button>
                </div>
            </div>
        </form>           
    </div>

    <div class="detCliente bg-white mb-3">
      <?php  
      //var_dump($_SESSION['usuario']);

      if(isset($_SESSION['usuario']) == true &&isset($_POST['txtBuscarCliente']) == false){
        $buscar_cliente = $_SESSION['usuario'];
            if(!empty($buscar_cliente)):    
                $resultado = buscarCliente($buscar_cliente);
                $cliente = $resultado->fetchAll();
                 
                foreach($cliente as $clienteP):?> 
                <div class="tituloDetalleCliente">Detalles del cliente</div>  
                <div class="informacion d-flex flex-wrap justify-content-sm-center justify-content-lg-around">
                    <div class="dato">DNI: <span></span><?php echo $clienteP['Dni']?></span></div>   
                    <div class="dato">Nombre Completo: <span><?php echo $clienteP['Nombres'] . ' '. $clienteP['Apellidos'];?></span></div>
                    <div class="dato">Dirección: <span><?php echo $clienteP['Direccion']?></span></div>
                    <div class="dato">Teléfono: <span><?php echo $clienteP['Telefono']?></span></div>
                </div>
            <?php endforeach;
       
          endif;     
           }   
      ?> 

     <?php

        if(isset($_POST['txtBuscarCliente']) == true):
            $buscar_cliente = $_POST['txtBuscarCliente'];
            if(!empty($buscar_cliente)):    
                $resultado = buscarCliente($buscar_cliente);
                $cliente = $resultado->fetchAll();
                    
                foreach($cliente as $clienteP):?> 
                <div class="tituloDetalleCliente">Detalles del cliente</div>  
                <div class="informacion d-flex flex-wrap justify-content-sm-center justify-content-lg-around">
                    <?php $_SESSION['usuario'] = $clienteP['Dni'];?>
                    <div class="dato">DNI: <span></span><?php echo $clienteP['Dni']?></span></div>   
                    <div class="dato">Nombre Completo: <span><?php echo $clienteP['Nombres'] . ' '. $clienteP['Apellidos'];?></span></div>
                    <div class="dato">Dirección: <span><?php echo $clienteP['Direccion']?></span></div>
                    <div class="dato">Teléfono: <span><?php echo $clienteP['Telefono']?></span></div>
                </div>
            <?php endforeach;
            else: ?>
                <div class="alert alert-danger mx-3" style="display:block;width:100%;" role="alert">Error ... ! No ha ingresado ningun valor</div>
      <?php endif;       
        endif;?>    
    </div>

    <div class="d-flex flex-wrap flex-row">
        <div class="m-2">
            <a href="cancelar.php" class="btn btn-secondary"><i class="fa fa-window-close mr-2" aria-hidden="true"></i>Limpiar</a>
        </div>
        <div class="m-2">
            <a href="comprar.php" class="btn btn-primary" ><i class="far fa-file mr-2" ></i>Enviar</a>
        </div>    
    </div>

    <div class="table-responsive-lg shadow bg-white rounded justify-content-center">

        <?php if(isset($productos_cesto) == true):?>
            <table class="table table-bordered mb-0">
            <?php 
                $i = 1;
                try{
                    require 'includes/funciones/conectar.php';?>
                    <thead>
                        <tr class="text-center">
                            <th>Nro</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Opción</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

            <?php  
                    foreach($productos_cesto as $codigo):
            ?>
                    <tbody>
                        <tr class="text-center">
                            <td><?php echo $i;?></td>
                            <?php
                                $sql = 'SELECT Nombre, Descripcion, Marca, Imagen FROM producto 
                                        WHERE IdProducto = '. $codigo;
                                $datos = $conexion->query($sql);
                                if($datos == true):
                                    $filas = $datos->fetchAll();?>
                                <td><?php echo $filas[0]['Nombre'].' '.$filas[0]['Marca']?></td>
                                <td><?php echo $filas[0]['Descripcion']?></td>
                                <td><?php echo $_SESSION['cestoCantidad'][$i-1]?></td> 
                                <?php echo '<td><a href="editar-pedido.php?id='. $i .'" class="btn btn-success" ><i class="fas fa-edit mr-2"></i>Modificar</a></td>';?> 
                                <td><?php echo 's/'.$_SESSION['cestosSub'][$i-1].'.00'?></td> 
                                      
                        <?php   else:?>
                             <div>No se pudo realizar la consulta</div>
                        <?php  endif;?>
                        <?php $i++?>
                            </td>
                        </tr> 
                        
            <?php            
                    endforeach;    
                }catch(PDOException $e){
                    echo 'No se puede acceder a la base de datos'; 
                }
            ?>


    <?php  
        $Suma=0;
        $y=0;  
        foreach($Sub as $total):
            $Suma=$Suma + $total;
            $y++;
        endforeach;   
    ?>

                            <td colspan="5" class="text-center font-weight-bold">TOTAL GENERAL</td> 
                            <td class="text-center font-weight-bold"><?php echo 's/'.$Suma.'.00'?></td>
                        </tr>
                    </tbody> 
            </table>
        <?php else:?>
            <div class="alert alert-danger mb-0">No hay productos seleccionados</div> 
        <?php endif;?>

    </div>
</div>
<?php require 'includes/templates/footer.php';?>