function reset(){
    $('input[name="cari"]').val('');
    $('input[name="_status"]').val('y');

    getList();
    list_display();
}

list_display();

$('body').on('click','.btn-display', function(e){
    e.preventDefault();
    var status = $(this).data('status');
    $('input[name="_status"]').val(status);
    getList();
    list_display();
});

function list_display(){
    var status_input = $('input[name="_status"]').val();
    if(status_input == '' || status_input == 'y'){
        $('#btn-on').addClass('active');
        $('#btn-off').removeClass('active');

    }else{
        $('#btn-off').addClass('active');
        $('#btn-on').removeClass('active');
    }
}

$(document).ready(function () {

    $('.select2').select2();

    $('.data-list').on('click','.hapus_data_list', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var data = $(this).data('nama');
        var tipe = $(this).data('tipe');

        if(tipe == 'hapus'){
            var buttonText = 'Hapus';
            var confirmText = 'Apakah Anda yakin ingin menghapus ';
        }

        if(tipe == 'nonaktifkan'){
            var buttonText = 'Ya';
            var confirmText = 'Apakah Anda yakin ingin menonaktifkan ';
        }

        if(tipe == 'aktifkan'){
            var buttonText = 'Aktifkan';
            var confirmText = 'Apakah Anda yakin ingin mengaktifkan kembali ';
        }

        Swal.fire({
            title : 'Perhatian',
            text  : confirmText+data,
            icon  : 'warning',
            width : '20rem',
            confirmButtonText : buttonText,
            cancelButtonText : 'Batal',
            showCancelButton : true,
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    type : 'GET',
                    url  : url,
                    dataType : 'json',
                    success : function(msg) {
                        // console.log(msg);
                        if(msg.tipe === true){
                            Swal.fire({
                                title : 'Berhasil',
                                text  : msg.pesan,
                                icon  : 'success',
                                width : '20rem',
                                timer : 3000,
                                showConfirmButton : false,
                                showCancelButton : false,
                            });

                        }else{
                            Swal.fire({
                                title : 'Error',
                                text  : msg.pesan,
                                icon  : 'error',
                                width : '20rem',
                                timer : 3000,
                                showConfirmButton : false,
                                showCancelButton : false,
                            });
                        }

                        // data_list.ajax.reload();
                        getList();
                    }
                });
            }
        });

        return false;
    });

    // Filter list dan sampah
    list_display();

    $('body').on('click','.filter_status', function(e){
        e.preventDefault();
        var status = $(this).data('status');
        $('input[name="_status"]').val(status);
        getList();
        list_display();
    });


    // pilih jurusan dari Fakultas
   $('#my-form').on('change','#fakultas', function(){
        var url = '/dropJurusan';
        var token = $("input[name=_token]").val();

        $.ajax({
            type : 'POST',
            url  : url,
            data : {
                fakultas : $(this).val(),
                _token  : token,
            },
            success : function(msg){
                if(msg.status == true){
                    var areas = msg.data;
                    $('#jurusan').removeAttr('disabled');
                    $('#jurusan').html('');

                    $.each(areas, function(index, row ){
                        $('#jurusan').append('<option value="'+row.id+'">'+row.label+'</option>');
                    });

                }else{
                    $('#jurusan').attr('disabled','disabled');
                }
            }
        });

        return false;
   });

    // Logout
    $('#logout-btn').click(function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var data = $(this).data('nama');

        Swal.fire({
            title : 'Perhatian',
            text  : 'Anda yakin ingin Logout?',
            icon  : 'warning',
            width : '20rem',
            confirmButtonText : 'Ya',
            cancelButtonText : 'Batal',
            showCancelButton : true,
        }).then((result) => {
            if(result.isConfirmed){
                window.location = url;
            }
        });

        return false;
    });


});
