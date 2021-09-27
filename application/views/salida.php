<div>
    <h2 class="text-center">Tabla Ubicaciones</h2>

        <div class="table-responsive">
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                    <th scope="col">idUbicacion</th>
                    <th scope="col">idGrupo</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">idSucursal</th>
                    <th scope="col">idCerradura</th>
                    <th scope="col">estado</th>                
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($ubicaciones as $ubicacion): ?>
                        <tr>
                            <td><?= $ubicacion['idUbicacion'] ?></td>                        
                            <td><?= $ubicacion['idGrupo'] ?></td>                        
                            <td><?= $ubicacion['descripcion'] ?></td>                        
                            <td><?= $ubicacion['idSucursal'] ?></td>                        
                            <td><?= $ubicacion['idCerradura'] ?></td>                        
                            <td><?= $ubicacion['estado'] ?></td>                        
                        </tr>
                    <?php endforeach ?>
                </tbody>    
            </table>
        </div>

    <div class="text-center mt-3">
        <a href="<?= base_url('excel_import') ?>" class="btn btn-secondary">Volver</a>
        <button id="submit-salida-1-btn" class="btn btn-secondary">Guardar</button>        
    </div>
    <hr>
    <h2 class="text-center mt-5">Tabla Herramientas</h2>                    
        <div class="table-responsive">
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                    <th scope="col">idHerramienta</th>
                    <th scope="col">codigo</th>
                    <th scope="col">descripcion</th>
                    <th scope="col">idTipo</th>
                    <th scope="col">idMarca</th>
                    <th scope="col">valor</th>
                    <th scope="col" style="min-width: 120px;">valorRecidual</th>
                    <th scope="col">fechaInicio</th>
                    <th scope="col">fechaFin</th>
                    <th scope="col">estado</th>
                    <th scope="col">daniada</th>
                    <th scope="col">prestada</th>
                    <th scope="col">observacionesPrestada</th>
                    <th scope="col">consumible</th>
                    <th scope="col">stock</th>
                    <th scope="col">stockMinimo</th>
                    <th scope="col">idUnidad</th>
                    <th scope="col">fechaAlta</th>
                    <th scope="col">fechaBaja</th>
                    <th scope="col">nroSerie</th>
                    <th scope="col">detalle</th>
                    <th scope="col">idSucursal</th>
                    <th scope="col">idUbicacion</th>
                    <th scope="col">idUbicacionAlternativa</th>
                    <th scope="col">imagen</th>
                    </tr>
                </thead>
                <tbody>                 
                    <?php foreach($tools as $tool): ?>
                        <tr>                        
                            <td><?= $tool['idHerramienta'] ?></td>
                            <td><?= $tool['codigo'] ?></td>
                            <td><?= $tool['descripcion'] ?></td>
                            <td><?= $tool['idTipo'] ?></td>
                            <td><?= $tool['idMarca'] ?></td>
                            <td><?= $tool['valor'] ?></td>
                            <td><?= $tool['valorRecidual'] ?></td>
                            <td><?= $tool['fechaInicio'] ?></td>
                            <td><?= $tool['fechaFin'] ?></td>
                            <td><?= $tool['estado'] ?></td>
                            <td><?= $tool['daniada'] ?></td>
                            <td><?= $tool['prestada'] ?></td>
                            <td><?= $tool['observacionesPrestada'] ?></td>
                            <td><?= $tool['consumible'] ?></td>
                            <td><?= $tool['stock'] ?></td>
                            <td><?= $tool['stockMinimo'] ?></td>
                            <td><?= $tool['idUnidad'] ?></td>
                            <td><?= $tool['fechaAlta'] ?></td>
                            <td><?= $tool['fechaBaja'] ?></td>
                            <td><?= $tool['nroSerie'] ?></td>
                            <td><?= $tool['detalle'] ?></td>
                            <td><?= $tool['idSucursal'] ?></td>
                            <td><?= $tool['idUbicacion'] ?></td>
                            <td><?= $tool['idUbicacionAlternativa'] ?></td>
                            <td><?= $tool['imagen'] ?></td>
                        
                        
                        </tr>
                    <?php endforeach ?>
                </tbody>    
            </table>
        </div>
    <div class="text-center mt-3">
        <a href="<?= base_url('excel_import') ?>" class="btn btn-secondary">Volver</a>
        <button id="submit-salida-2-btn" class="btn btn-secondary">Guardar</button>        
    </div>
</div>    

<script>
    const herramientas = <?= json_encode($tools) ?>;
    const ubicaciones = <?= json_encode($ubicaciones) ?>;

    const btnSalida1 = document.querySelector('#submit-salida-1-btn');   
    const btnSalida2 = document.querySelector('#submit-salida-2-btn');   
    addEventListener('DOMContentLoaded', (e) => {
        btnSalida1.addEventListener('click', submitSalida1);
        btnSalida2.addEventListener('click', submitSalida2);
    })

    function submitSalida1(e)
    {
        e.preventDefault();
        btnSalida1.disabled = true;        
        let endpoint = '<?= base_url('excel/store_ubicaciones') ?>';             
        $.ajax({
            url:endpoint,
            method: 'post',
            data: {ubicaciones},
            dataType: 'json',
            success: function(res){
                console.log(res);                  
                alert('Datos almacenados con éxito');
            },
            error: function(err) {
                console.log(err); 
                alert('Algo salio mal');
            }
        });  
    }

    function submitSalida2(e)
    {
        e.preventDefault();
        btnSalida2.disabled = true;
        let endpoint = '<?= base_url('excel/store_herramientas') ?>';         
        $.ajax({
            url:endpoint,
            method: 'post',
            data: {herramientas},
            dataType: 'json',
            success: function(res){
                console.log(res);                  
                alert('Datos almacenados con éxito');
            },
            error: function(err) {
                alert('Algo salio mal');
            }
        });  
    }
      
</script>