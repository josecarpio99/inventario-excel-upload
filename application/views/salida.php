<div>
    <h2 class="text-center">Tabla Admin</h2>
    <div class="table-responsive">
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                <th scope="col">idUsuario</th>
                <th scope="col">USER</th>
                <th scope="col">email</th>
                <th scope="col">password</th>
                <th scope="col">estado</th>
                <th scope="col">perfil</th>
                <th scope="col">idIdioma</th>
                <th scope="col">fechaAlta</th>
                <th scope="col">fechaBaja</th>
                <th scope="col">idEmpresa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($usuarios as $usuario): ?>
                    <tr>
                        <td><?= $usuario['idUsuario'] ?></td>
                        <td><?= $usuario['usuario'] ?></td>
                        <td><?= $usuario['email'] ?></td>
                        <td><?= $usuario['password'] ?></td>
                        <td><?= $usuario['estado'] ?></td>
                        <td><?= $usuario['perfil'] ?></td>
                        <td><?= $usuario['idIdioma'] ?></td>
                        <td><?= $usuario['fechaAlta'] ?></td>
                        <td><?= $usuario['fechaBaja'] ?></td>
                        <td><?= $usuario['idEmpresa'] ?></td>
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
    <h2 class="text-center mt-5">Tabla Usuarios</h2>                    
    <div class="table-responsive">
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                <th scope="col">idUsuario</th>
                <th scope="col">USER</th>
                <th scope="col">apellido</th>
                <th scope="col">nombre</th>
                <th scope="col">dni</th>
                <th scope="col">email</th>
                <th scope="col" style="min-width: 120px;">celular</th>
                <th scope="col">idSucursal</th>
                <th scope="col">password</th>
                <th scope="col">estado</th>
                <th scope="col">tipo</th>
                <th scope="col" style="min-width: 140px;">fechaAlta</th>
                <th scope="col" style="min-width: 140px;">fechaBaja</th>
                <th scope="col">imagen</th>
                <th scope="col">idIdioma</th>
                <th scope="col">idEmpresa</th>
                <th scope="col">idUsuarioAdmin</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>_share</td>
                    <td>share</td>
                    <td>share</td>
                    <td>0</td>
                    <td>share@share</td>
                    <td>0</td>
                    <td>1</td>
                    <td>85602</td>
                    <td>Activo</td>
                    <td>1</td>
                    <td><?= $usuarios[0]['fechaAlta'] ?></td>
                    <td><?= $usuarios[0]['fechaBaja'] ?></td>
                    <td>-</td>
                    <td>1</td>
                    <td><?= $usuarios[0]['idEmpresa'] ?></td>
                    <td>-1</td>
                </tr>
                <?php $count = 2; ?>
                <?php foreach($usuarios as $usuario): ?>
                    <tr>
                        <td><?= $count ?></td>
                        <td><?= $usuario['usuario'] ?></td>
                        <td><?= $usuario['apellido'] ?></td>
                        <td><?= $usuario['nombre'] ?></td>
                        <td><?= $usuario['dni'] ?></td>
                        <td><?= $usuario['email'] ?></td>
                        <td><?= $usuario['celular'] ?></td>
                        <td><?= $usuario['idSucursal'] ?></td>
                        <td><?= $usuario['password'] ?></td>
                        <td><?= $usuario['estado'] ?></td>
                        <td><?= $usuario['tipo'] ?></td>
                        <td><?= $usuario['fechaAlta'] ?></td>
                        <td><?= $usuario['fechaBaja'] ?></td>
                        <td><?= $usuario['imagen'] ?></td>
                        <td><?= $usuario['idIdioma'] ?></td>
                        <td><?= $usuario['idEmpresa'] ?></td>
                        <td><?= $usuario['idUsuarioAdmin'] ?></td>
                    </tr>
                    <?php $count++; ?>
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
    const usuarios = <?= json_encode($usuarios) ?>;

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
        let endpoint = '<?= base_url('excel/store_admin_users') ?>';
        let = usersData = [];
        usuarios.forEach( user => {
            usersData = [
                ...usersData,
                {
                   idUsuario: user.idUsuario,
                   usuario: user.usuario,
                   email: user.email,
                   password: user.password,
                   estado: user.estado,
                   perfil: user.perfil,
                   idIdioma: user.idIdioma,
                   fechaAlta: user.fechaAlta,
                   fechaBaja: user.fechaBaja,
                   idEmpresa: user.idEmpresa 
                }
            ];
        });        
        $.ajax({
            url:endpoint,
            method: 'post',
            data: {usuarios: usersData},
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
        let endpoint = '<?= base_url('excel/store_users') ?>';
        let usersData = [];
        //Add share user
        usersData.push(getShareUser());
        
        usuarios.forEach( user => {            
            let {
                idUsuario,
                perfil,
                ...singleUser
            } = user;
            usersData = [
                ...usersData, 
                singleUser                
            ];
        });        
        $.ajax({
            url:endpoint,
            method: 'post',
            data: {usuarios: usersData},
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

    function getShareUser()
    {
        return {            
            usuario:    '_share',
            apellido:    'share',
            nombre:    'share',
            dni:    0,
            email:    'share@share',
            celular:    0,
            idSucursal:    1,
            password:    '85602',
            estado:    'Activo',
            tipo:    1,
            fechaAlta:    usuarios[0].fechaAlta,
            fechaBaja:    usuarios[0].fechaBaja,
            imagen:    '-',
            idIdioma:    1,
            idEmpresa:    usuarios[0].idEmpresa,
            idUsuarioAdmin:    -1,
        };
    }
    
</script>