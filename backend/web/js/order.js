$('.tab-content>div>p>button').on('click', function () {

    var buttonID = this.id; //submit_order132465
    var gridID = 'grid' + buttonID.substring(12);//grid13246
    
    var keys = {};
    $('#' + gridID).find("input[ name='selection[]' ]:checked").each( function () {
            key = $(this).parent().closest('tr').data('key');
            keys[key] = $(' tr[data-key="'+key+'"] input[type="number"] ').val();
        });   
    
    $.ajax({
        url: '/index.php?r=orders/submitted-orders-by-ajax', // your controller action
        type: 'POST',
        dataType: 'json',
        data: keys, //{id:quantity}
        success: function (data) {
            if (data.status === 'ok') {
                window.location = data.link;
            } else {
                alert('Nothing has been ordered!\n' +
                        'Please, tick at least one checkbox,\n' +
                        'before sending your order');
            }
        }
    });
    
});
 