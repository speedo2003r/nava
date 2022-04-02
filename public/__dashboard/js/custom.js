$(function () {
  $("#example1").DataTable();
  // $('#example2').DataTable({
  //   "paging": true,
  //   "lengthChange": false,
  //   "searching": false,
  //   "ordering": true,
  //   "info": true,
  //   "autoWidth": false,
  // });



  //img uploader
  $( document ).on( 'change', '.image-uploader', function (event) {
    // $('.image-uploader').change(function (event) {
    for (var one = 0; one < event.target.files.length; one++) {
      // alert(1);
      $(this).parents('.images-upload-block').find('.upload-area').append('<div class="uploaded-block" data-count-order="' + one + '"><a href="' + URL.createObjectURL(event.target.files[one]) + '"  data-fancybox data-caption="' + URL.createObjectURL(event.target.files[one]) + '" ><img src="' + URL.createObjectURL(event.target.files[one]) + '"></a><button class="close" type="button">&times;</button></div>');
    }
  });

  $('body').on('click', '.images-upload-block .close',function (){
    $(this).parents('.uploaded-block').remove();
  });


  function checkDataIds(){
    let ids  = $('#delete_ids').val();
    let type = $('#delete_type').val();
    if(type != 'all' && ids == ''){
      event.preventDefault();
      $('#delete-all-modal').trigger('click');
    }
  }

  function checkIds(){
    let usersIds = '';
    $('.checkSingle:checked').each(function () {
      let id = $(this).attr('id');
      usersIds += id + ' ';
    });
    let requestData = usersIds.split(' ');
    $('#delete_ids').val(requestData);
  }

  $(document).on('change','#checkedAll',function(){
    if(this.checked){
      $(".checkSingle").each(function(){
        this.checked=true;
        $('.confirmDel').prop('disabled',false);
      });
    }else{
      $(".checkSingle").each(function(){
        this.checked=false;
        $('.confirmDel').prop('disabled',true);
      });
    }
    checkIds();
  });

  $(document).on('click',".checkSingle",function () {
    if ($(this).is(":checked")){
      $('.confirmDel').prop('disabled',false);
      var isAllChecked = 0;
      $(".checkSingle").each(function(){
        if(!this.checked)
          isAllChecked = 1;
      })
      if(isAllChecked == 0){ $("#checkedAll").prop("checked", true); }
    }else {
      if($(".checkSingle:checked").length == 0){
        $('.confirmDel').prop('disabled',true);
      }
      $("#checkedAll").prop("checked", false);
    }
    checkIds();
  });


});
