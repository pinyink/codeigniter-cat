
<?= $this->extend('tema/tema'); ?> 
<?=$this->section('css');?>
<link href="<?=base_url();?>/assets/alertifyjs/css/alertify.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url();?>/assets/alertifyjs/css/themes/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url();?>/assets/admincast/dist/assets/vendors/DataTables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url();?>/assets/admincast/dist/assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />

<?=$this->endSection();?>

<?=$this->section('content'); ?>
<div class="page-heading">
    <h1 class="page-title">Ref Formasi</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?=base_url('home');?>"><i class="fa fa-home font-20"></i></a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?=base_url('ref_formasi/index');?>">Ref Formasi</a>
        </li>
        <li class="breadcrumb-item">Edit</li>
    </ol>
</div>

<!-- Container -->
<div class="page-content fade-in-up">
    <!-- Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <?=session()->getFlashData('message');?>
            <div class="ibox">
                <div class="ibox-body">
                    <a href='<?=base_url('ref_formasi/index')?>' class='btn btn-info btn-sm'><i class="fa fa-backward"></i> Kembali</a>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
    <!-- Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Edit Ref Formasi</div>
                    <div class="ibox-tools">
                    </div>
                </div>
                <div class="ibox-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->include('ref_formasi/_form_ref_formasi'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Ketentuan</div>
                    <div class="ibox-tools">
                        <a onclick="reload_table()" class="refresh" data-toggle="tooltip" data-placement="top" title="reload data"><i class="fa fa-refresh"></i></a>
                        <a href="javascript:;" onclick="tambah_soal()"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="ibox-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="15%">Aksi</th>
                                    <th width="10%">No</th>
									<th style="width: 25%">Formasi</th>
									<th style="width: 25%">Jenis Soal</th>
									<th style="width: 25%">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
</div>
<!-- /Container -->

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <?=form_open('', ['id' => 'form'], ['id' => '', 'method' => '', 'formasi' => $ref_formasi['id']]);?>
            <?=csrf_field();?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
					<div class="form-group">
                        <?=form_label('Jenis Soal');?>
                        <?=form_dropdown('jenis_soal', dropdown($ref_jenis_soal, 'id', 'nama'), '', ['class' => 'form-control']);?>
                    </div>
					<div class="form-group">
                        <?=form_label('Jumlah')?>
                        <?=form_input('jumlah', '', ['class' => 'form-control'])?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        <?=form_close();?>
    </div>
</div>

<?=$this->endSection();?>
<?=$this->section('js');?>
<script src="<?=base_url(); ?>/assets/alertifyjs/alertify.min.js" type="text/javascript"> </script>
<script src="<?=base_url(); ?>/assets/admincast/dist/assets/vendors/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"> </script>
<script src="<?=base_url(); ?>/assets/admincast/dist/assets/vendors/DataTables/datatables.min.js" type="text/javascript"> </script>

<script>
    var table;
    var save_method;
    $(document).ready(function () {
        table = $('#datatable').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    "order": [],
                    "ajax": {
                        "url": "<?php echo base_url('ref_formasi_soal/ajax_list') ?>",
                        "headers": {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        "type": "POST",
                        "data": {<?=csrf_token();?>: '<?=csrf_hash()?>'},
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR.responseText);
                        }
                    },
                    columns: [
                        {data: 'action'},
                        {data: 'no'},
                        {data: 'formasi_nama'},
                        {data: 'jenis_soal_nama'},
                        {data: 'jumlah'}
                    ],
                    //optional
                    "columnDefs": [{
                        "targets": [0, 1],
                        "orderable": false,
                    }, ],
                });
    });
    
    function reload_table() {
        table.ajax.reload(null, false);
    }

    function tambah_soal()
    {
        $('[name="method"]').val('save');
        $('#modal').modal('show');
        $('[name="id"]').val(null);
        $('[name="jenis_soal"]').val(null);
        $('[name="jumlah"]').val(null);
    }

    $('#form').submit(function (e) { 
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "<?=base_url('ref_formasi_soal/save')?>",
            data: $('#form').serialize(),
            dataType: "json",
            success: function (response) {
                if(response.errorCode == 1) {
                    Swal.fire(
                        'Save!',
                        'Data Berhasil Di Simpan.',
                        'success'
                    )
                } else {
                    Swal.fire(
                        'Save Failed!',
                        'Data Gagal Di Simpan',
                        'warning'
                    )
                }
                $('#modal').modal('hide');
                reload_table();
            }
        });
    });

    function edit_soal(id)
    {
        $.ajax({
            type: "get",
            url: "<?=base_url('ref_formasi_soal')?>/"+id+"/detail",
            dataType: "json",
            success: function (response) {
                $('[name="method"]').val('update');
                $('#modal').modal('show');
                $('[name="id"]').val(id);
                $('[name="jenis_soal"]').val(response.ref_jenis_soal);
                $('[name="jumlah"]').val(response.jumlah);
            }
        });
    }

    function delete_soal(id) {
        Swal.fire({
        title: 'Apa Anda Yakin?',
        text: "Anda Tidak Dapat Mengembalikan Data Yang Telah Di Hapus",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya Hapus !'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "DELETE",
                url: "<?=base_url('ref_formasi_soal')?>/"+id+'/delete',
                data: {'<?=csrf_token()?>' : '<?=csrf_hash()?>'},
                dataType: "json",
                success: function (response) {
                    if(response.errorCode == 1) {
                        Swal.fire(
                            'Deleted!',
                            'Data Berhasil Di Hapus.',
                            'success'
                        )
                    } else {
                        Swal.fire(
                            'Deleted Failed!',
                            'Data Gagal Di Hapus',
                            'warning'
                        )
                    }
                    reload_table();
                }
            });
        }
        })

    }
</script>
<?=$this->endSection();?>
