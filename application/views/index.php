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
            <label for="id-empresa" class="col-sm-5 col-4 col-form-label">idEmpresa</label>
            <div class="col-sm-4 col-4">
            <input type="number" class="form-control form-control" name="id-empresa" id="id-empresa" placeholder="243" required>
            </div>
        </div>
        <div class="form-group row mt-3">
            <label for="index-start" class="col-sm-5 col-4 col-form-label">Primera Fila</label>
            <div class="col-sm-4 col-4">
            <input <?php echo set_value('index-start'); ?> type="number" class="form-control form-control" name="index-start" id="index-start" placeholder="5" required>
            </div>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-secondary mx-auto">Visualizar</button>
        </div>
    </form>
</div>