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
            <div class="menu-item" id="noteCreate" onclick="note('create');"><div class="title">+</div></div>
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
        note('list');
    });
    function noteClear(){
        $('#textarea').attr('note-id','').val('').attr('disabled',true);
    }
    function contentReg(){ /* registra conteudo da nota no banco (texto) */
        $.post("/modules/contentReg.php",{change:$('#textarea').val(),id:$('#textarea').attr('note-id')});
        sync = 0;
        
    }
    function listNote(id,title){
        $('.menu .menu-content').append(`<div class="menu-item" note-id="${id}" onclick="note('get',${id});"><div class="title">${title}</div><div class="delete" onclick="noteRemove($(this).parent());" ><i class="fa-solid fa-trash"></i></div></div>`);
    }
    function note(action,id = null) {
        $.post("modules/note.php",{
            action: action,
            data: $('#textarea').val(),
            title: "Nova anotação",
            id: id
        },
        function(data){
            console.log(data)
            if (data.result < 0) return;
            switch(action){
                case 'send':

                break;
                case 'get':
                    $('.menu-item').removeClass('active');
                    $(`.menu-item[note-id="${id}"]`).addClass('active');
                    $('#textarea').attr('note-id',id);
                    $('#textarea').val(data.data['data']).attr('disabled',false);
                    setTimeout(() => {
                        $('#textarea').focus();
                    }, 100);
                break;
                case 'list':
                    $(data.data).each(function(key,value){
                        listNote(value['id'],value['title']);
                    });
                break;
                case 'create':
                    listNote(data.data['id'],data.data['title']);
                break;
            }
        });
    }
    function noteRemove(e){ /* desativa a nota no sistema (banco) */
        $.post("/modules/noteRemove.php",{id:$(e).attr('note-id')});
        setTimeout(() => {
            noteClear();
            noteGet();
        }, 100);
    }
    /* setInterval(() => {
        sync += 1;
        if($('#textarea').attr('note-id'))
        if(sync >= (syncTime * 10)){
            contentGet();
            console.log('sync');
            sync = 0;
        }
    }, 100); */
</script>