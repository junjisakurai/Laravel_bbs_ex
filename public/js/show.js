$(function(){
    $("[id^=updateBtn]").on("click",function(){
        var comment_id = $(this).attr('comment_id');
        $(this).attr("type", "hidden");
        $('#' + comment_id + 'commentBtn').attr("type", "submit");
        $('#' + comment_id + 'comment_body').css("display", "none");
        $('#' + comment_id + 'edit_body').css("display", "block");
        
        return;
    });
});

function check($comment_id){
  $('#' + $comment_id + 'body').val($('#' + $comment_id + 'edit_body').val());
  return true;
}