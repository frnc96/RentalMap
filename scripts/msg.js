$(document).ready(function(){
    setInterval(function(){ 
        $('#chat').load(document.URL +  ' #chat>*'); 
        //$('.col-sm-3.sidenav').load(document.URL +  ' .col-sm-3.sidenav>*');
    },5000);
    
    $('#chat').scrollTop($('#chat')[0].scrollHeight);
    
    $("#msg").keyup(function(event) {
        if (event.keyCode === 13) {
            $("#sendBtn").click();
        }
    });
    
    $(document).on('click','.wrap.list-group-item.list-group-item-action',function(){
        $('.wrap.list-group-item.list-group-item-action').each(function(){
            $(this).removeClass('selected');
        });
        var senderId = $(this).children().children().siblings().children().next().next().text();
        //alert(senderId);
        $(this).toggleClass('selected');
        window.history.pushState("", "", 'messages.php?senderId='+senderId);
        $('#chat').load(document.URL +  ' #chat>*'); 
    });

});

function sendMsg(){
    var id = $('#sender').text();
    var msg = $('#msg').val();
    var dt = [id, msg];
    
    if(id && msg.match(/\w+/)){
        $.ajax({
            type:'POST',
            url:'insertMsg.php',
            data: {array: dt},
            success:function(data){
                //alert(data);
                if(data=='Success'){
                    $('#chat').load(document.URL +  ' #chat>*');
                    //$('.col-sm-3.sidenav').load(document.URL +  ' .col-sm-3.sidenav>*');
                    $('#msg').val("");
                }
            }
        });
    }
}