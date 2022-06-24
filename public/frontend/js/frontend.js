$(document).ready(function(){
    $('.menu-btn').click(function(e){
        hideKonten();
        removeAktif();
        e.preventDefault();
        var konten = $(this).attr('href');

        $(this).addClass('aktif');
        $('.konten '+konten).fadeIn('slow');
    });

    // login member

    $('#member-login').submit(function(e){
        e.preventDefault();
        var url = $(this).attr('action');
        var data = $(this).serialize();

        $.ajax({
            methode : 'POST',
            url     : url,
            data    : data,
            success : function(msg){
                if(msg.status == true){
                    window.location.href = msg.url;
                }else{
                    $('#notif').text(msg.pesan);
                }
            }
        })
    });

    $('#member-profil').submit(function(e){
        e.preventDefault();
        var url = $(this).attr('action');
        var data = $(this).serialize();

        $.ajax({
            methode : 'POST',
            url     : url,
            data    : data,
            success : function(msg){
                if(msg.status == true){
                    window.location.href = msg.url;
                }else{
                    $('#notif').text(msg.pesan);
                }
            }
        })
    });

    $('.btn-close').click(function(){
        $('.boothModalBody').html('');
        $('#boothModal').modal('hide');
    })

    $('.openBoothModal').click(function(){
        var id = $(this).data('id');
        var base_url = $('input[name="base_url"]').val();

        $('.boothModalBody').html('');
        $('#boothModal').modal('show');

        if(id == '1'){
            $('.boothModalBody').html('<iframe src="https://drive.google.com/file/d/1_d0p8CAB9RfaWYjGmC14VpeDwpSXw4F4/preview" allow="autoplay"></iframe>');
            return false;
        }

        if(id == '2'){
            $('.boothModalBody').html('<iframe src="https://drive.google.com/file/d/1CPAUmUCYUsMr_GShL74Xf6uBZGeAeyzc/preview" allow="autoplay"></iframe>');
            return false;
        }

        if(id == '3'){
            $('.boothModalBody').html('<img src="'+base_url+'/storage/booth/3.jpg">');
            return false;
        }

        if(id == '4'){
            $('.boothModalBody').html('<img src="'+base_url+'/storage/booth/4.jpg">');
            return false;
        }

        if(id == '5'){
            $('.boothModalBody').html('<iframe src="https://docs.google.com/forms/d/1jRpmxxv7o89mN6NP7T-I8UruhfSzrnlN9zT3QTLTau0/viewform?edit_requested=true"></iframe>');
            return false;
        }

    })
});

// hideKonten();
// removeAktif();

function hideKonten(){
    $('.konten section').each(function(){
        $(this).hide();
    });
}

function removeAktif(){
    $('.menu-btn').each(function(){
        $(this).removeClass('aktif');
    });
}
