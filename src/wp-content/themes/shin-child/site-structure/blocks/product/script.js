function fetch(value){
  const id = value || '';

    jQuery.ajax({
        url: "/wp-admin/admin-ajax.php",
        type: 'post',
        data: { action: 'data_fetch', pcat: id },
        success: function(data) {
            jQuery('#datafetch').html( data );
        }
    });

}