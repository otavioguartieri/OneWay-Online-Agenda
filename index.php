<!DOCTYPE html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>OneWay Agenda</title>
</head>
<body>
    <div class="content">
        <div class="menu">
            <div class="menu-content"></div>
            <div class="menu-item" id="createNote" onclick="createNote();"><div class="title">+</div></div>
        </div>
        <div class="tab">
            <textarea oninput="contentReg();" disabled onkeyup="contentGet();" note-id="" id="textarea"></textarea>
        </div>
    </div>
</body>
</html>
<script>
    $(document).ready(()=>{
        /* contentGet(); */
        noteGet();
    });
    function contentReg(){
        $.post( "contentReg.php",{change:$('#textarea').val(),id:$('#textarea').attr('note-id')});
    }
    function contentGet(){
        $.post( "contentGet.php",{id:$('#textarea').attr('note-id')}, function( data ) {
            $('#textarea').val(data.data['note_content']).attr('disabled',false);
        });
    }
    function contentDefine(e){
        $('#textarea').attr('note-id',e);
        contentGet();
        setTimeout(() => {
            $('#textarea').focus();
        }, 100);
    }
    function createNote(){
        var time = new Date().getTime();
        $.post("noteCreate.php",{id:time.toString()});
        setTimeout(() => {
            noteGet();
        }, 100);
    }
    function noteGet(){
        $('.menu .menu-content').html('');
        $.post('noteGet.php',null,function(data){
            console.log(data.data)
            if(data.result == 1){
                $(data.data).each(function(key,value){
                    if(value[1]['note_launch'] == 1)
                    $('.menu .menu-content').append(`<div class="menu-item" onclick="contentDefine(${value[0].split('.')[0]});"><div class="title">${value[1]['note_title']}</div></div>`)
                });
            }
        });
    }
</script>