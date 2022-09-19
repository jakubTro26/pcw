
        

jQuery(document).ready(function($){


    $(".buttons8").click(function(){

        $.ajax({
            url: "https://smakolyk.nstrefa.pl/pcwordpress/wp-content/plugins/pc-market/convert2.php",
            cache: false,
            type: "GET",
        success: function(response) {
            console.log(response);
            },
        error: function(xhr) {
            
            },
        complete: function(data) {

                if(data.status==200){
                    $.ajax({
                        url: "https://smakolyk.nstrefa.pl/pcwordpress/wp-content/plugins/pc-market/dir.php",
                        cache: false,
                        type: "GET",
                    success: function(response) {
                        console.log(response);
                        },
                    error: function(xhr) {
                         console.log(xhr);
                        },
                    complete: function(data) {
                        console.log(data);


                        } 
                        });
                }

            }
            });
                        
              



    });
    


    $(".buttons6").click(function(){

        var super_var = window.super_array;

        super_var.forEach(element => {

            $.ajax({
            url: php_vars.ajaxurl,
            data: { 
                        "VarA": element

                  },
            cache: false,
            type: "POST",
        success: function(response) {
            console.log(response);
            
            },
        error: function(xhr) {
             console.log(xhr);
            }
            });
            
        });

    });


    $(".buttons5").click(function(){
        var main_array = window.csv;
        var sub_arrays;
        var count_of_arrays=main_array.length/20;
        window.super_array=[];
    
    for(var k=0; k<count_of_arrays;k++)
    {
        var array_elements=[];
        for(var i=0;i<20;i++){

             var element = main_array.shift();
             if(element!=undefined)
             {
                var l = array_elements.push(element);
             }
            if(i==19){
                var o = window.super_array.push(array_elements);
            }
             }
    }


    });



    $(".buttons2").click(function(){

        $.ajax({
            url: "https://smakolyk.nstrefa.pl/pcwordpress/wp-content/plugins/pc-market/echo.php",
            data: { 
                        "VarA": window.csv 

                  },
            cache: false,
            type: "POST",
        success: function(response) {
            console.log(response);
            },
        error: function(xhr) {
             console.log(xhr);
            }
            });
            
    });
});



 
    
    
