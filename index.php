<!DOCTYPE html>
<html>
<head>
    <title>OneWay Agenda</title>
    <meta charset="UTF-8">
    <script type="text/javascript" src="libs/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="text/javascript" src="libs/globals.php"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="content">
        <div class="menu">
            <div class="menu-content"></div>
            <div class="menu-item" id="noteCreate" onclick="noteCreate();"><div class="title">+</div></div>
        </div>
        <div class="tab">
            <textarea oninput="contentReg();" disabled  note-id="" id="textarea"></textarea>
        </div>
    </div>
</body>
</html>
<script>

    var sync = 0;
    var syncTime = 2; /* tempo da sincronização em segundos */

    $(document).ready(()=>{
        /* contentGet(); */
        noteGet();
    });
    function noteClear(){
        $('#textarea').attr('note-id','').val('').attr('disabled',true);
    }
    function contentReg(){
        $.post("/modules/contentReg.php",{change:$('#textarea').val(),id:$('#textarea').attr('note-id')});
        sync = 0;
    }
    function contentGet(){
        $.post("/modules/contentGet.php",{id:$('#textarea').attr('note-id')}, function( data ) {
            $('#textarea').val(data.data['note_content']).attr('disabled',false);
        });
    }
    function contentDefine(e){
        $('.menu-item').removeClass('active');
        $(e).addClass('active');
        $('#textarea').attr('note-id',$(e).attr('note-id'));
        contentGet();
        setTimeout(() => {
            $('#textarea').focus();
        }, 100);
    }
    function noteCreate(){
        var time = new Date().getTime();
        $.post("/modules/noteCreate.php",{id:time.toString()});
        setTimeout(() => {
            noteGet();
        }, 100);
    }
    function noteRemove(e){
        $.post("/modules/noteRemove.php",{id:$(e).attr('note-id')});
        setTimeout(() => {
            noteClear();
            noteGet();
        }, 100);
    }
    function noteGet(){
        $('.menu .menu-content').html('');
        $.post("/modules/noteGet.php",null,function(data){
            if(data.result == 1){
                $(data.data).each(function(key,value){
                    if(value[1]['note_launch'] == 1)
                    $('.menu .menu-content').append(`<div class="menu-item" note-id="${value[1]['note_id']}" onclick="contentDefine($(this));"><div class="title">${value[1]['note_title']}</div><div class="delete" onclick="noteRemove($(this).parent());" ><i class="fa-solid fa-trash"></i></div></div>`)
                });
            }
        });
    }
    setInterval(() => {
        sync += 1;
        if($('#textarea').attr('note-id'))
        if(sync >= (syncTime * 10)){
            contentGet();
            console.log('sync');
            sync = 0;
        }
    }, 100);
</script>