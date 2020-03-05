var postId=0;
var postbody=null;
$('.post').find('.interaction').find('.edit').on('click', function(event){
   event.preventDefault();
   postBody=event.target.parentNode.parentNode.childNodes[0];
   var postBody=postBody.textContent;
   postId=event.target.parentNode.parentNode.dataset['postid'];

    $('#post-body').val(postBody);
    $('#edit-modal').modal();
});
$('#modal-save').on('click',function(){
    $.ajax({
        method:'POST',
        url: url,
        data:{body: $('#post-body').val(),postId:postId,_token: token}
    })
    .done(function(msg){
       $(postbody).text(msg['new_body']);
       $('#edit-modal').modal('hide');
    });
});
$('.like').on('click',function(event){
    event.preventDefault();
   postId =event.target.parentNode.parentNode.dataset['postid'];
   var islike=event.target.previousElementSibling == null ? true : false;
   $.ajax({
       method:'POST',
       url:urlLike,
       data:{islike:islike,postId:postId,_token:token}
   })
   .done(function(){
     event.target.innerText=islike ? event.target.innerText== 'Like' ?'you like this post':'Like':event.target.innerText=='Dislike'? 'you don\'t like this post':'Dislike';
   if (islike){
       event.target.nextElementSibling.innerText='Dislike';
   }
   else{
       event.target.previousElementSibling.innerText='Like';
   }
   });
});
