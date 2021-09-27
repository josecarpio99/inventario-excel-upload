<div class="col-sm-6 mx-auto">
    <?php if($this->session->flashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul> 
            <?php echo $this->session->flashdata('errors'); ?>           
        </ul>
    </div>
    <?php endif  ?>
    <form action="excel/mostrar" method="POST" class="border border-secondary p-3" enctype="multipart/form-data">
        <div class="form-group row">
            <label class="col-sm-5 col-4 col-form-label" for="excel-file">Archivo de entrada: </label>
            <input class="col-sm-6 col-6" type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="form-control-file" name="excel-file" id="excel-file" required>
        </div>

        <div class="form-group row mt-3">
            <label for="tool-number" class="col-sm-5 col-4 col-form-label">Tool Number</label>
            <div class="col-sm-4 col-4">
            <input type="text" class="form-control form-control" name="tool-number" id="tool-number" placeholder="A" required>
            </div>
        </div>

        <div class="form-group row mt-3">
            <label for="inv" class="col-sm-5 col-4 col-form-label">Inventario</label>
            <div class="col-sm-4 col-4">
            <input type="text" class="form-control form-control" name="inv" id="inv" placeholder="A" required>
            </div>
        </div>

        <div class="form-group row mt-3">
            <label for="location" class="col-sm-5 col-4 col-form-label">Location</label>
            <div class="col-sm-4 col-4">
            <input type="text" class="form-control form-control" name="location" id="location" placeholder="D" required>
            </div>
        </div>
        
        <div class="form-group row mt-3">
            <label for="mul-inv" class="col-sm-5 col-4 col-form-label">Múltiple Inv</label>
            <div class="col-sm-4 col-4">
            <input type="text" class="form-control form-control" name="mul-inv" id="mul-inv" placeholder="F" required>
            </div>
        </div>     

        <div class="form-group row mt-3">
            <label for="mul-location" class="col-sm-5 col-4 col-form-label">Múltiple Location</label>
            <div class="col-sm-4 col-4">
            <input type="text" class="form-control form-control" name="mul-location" id="mul-location" placeholder="D" required>
            </div>
        </div>

        <div class="form-group row mt-3">
            <label for="description" class="col-sm-5 col-4 col-form-label">Description</label>
            <div class="col-sm-4 col-4">
            <input type="text" class="form-control form-control" name="description" id="description" placeholder="D" required>
            </div>
        </div>

        <div class="form-group row mt-3">
            <label for="tipos" class="col-sm-5 col-4 col-form-label">Tipos</label>
            <div class="col-sm-4 col-4">
            <input type="text" class="form-control form-control" name="tipos" id="tipos" placeholder="I,J,K,L" required>
            </div>
        </div>

        <div class="form-group row mt-3">
            <label for="notas" class="col-sm-5 col-4 col-form-label">Notas</label>
            <div class="col-sm-4 col-4">
            <input type="text" class="form-control form-control" name="notas" id="notas" placeholder="E,Q" required>
            </div>
        </div>

        <div class="form-group row mt-3">
            <label for="id-empresa" class="col-sm-5 col-4 col-form-label">idEmpresa</label>
            <div class="col-sm-4 col-4">
            <input type="number" class="form-control form-control" name="id-empresa" id="id-empresa" placeholder="243" required>
            </div>
        </div>

        <div class="form-group row mt-3">
            <label class="col-sm-5 col-4 col-form-label">Cerradura</label>
            <div class="col-sm-4 col-4">
            <label for="cerradura-0">0</label>
            <input type="radio" class="" name="cerradura" value="0" id="cerradura-0" placeholder="243" placeholder="0" required>
            <label for="cerradura-1">1</label>
            <input type="radio" class="" name="cerradura" value="1" id="cerradura-1" placeholder="243" required>
            </div>
        </div>

        <div class="form-group row mt-3">
            <label for="id-marca" class="col-sm-5 col-4 col-form-label">idMarca</label>
            <div class="col-sm-4 col-4">
            <select name="id-marca" id="id-marca" class="form-control">
                <option value="105">BMW</option>
                <option value="119">CDJR</option>
                <option value="134">Ford</option>
                <option value="132">GM</option>
                <option value="121">M-B</option>
            </select>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-secondary mx-auto">Visualizar</button>
        </div>
    </form>
</div>