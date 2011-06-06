$(document).ready(function() {

    $('#convert').click(function(){

        //Get all the values
        var amount = $('#amount').val();
        var from = $('#fromCurrency').val();
        var to = $('#toCurrency').val();

        //Make data string
        var dataString = "amount=" + amount + "&from=" + from + "&to=" + to;

        $.ajax({
            type: "POST",
            url: "ajax.php?do=converter",
            data: dataString,
            success: function(data){
                //Show results div
                $('#results').show();

                //Put received response into result div
                $('#results').html(data);
            }
        });
    });
});