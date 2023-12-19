$(function(){

    // Lista de 
    $.post( '../../frontend/funciones/sede.php' ).done( function(respuesta)
    {
        $( '#sede' ).html( respuesta );
    });
    
    
    // Lista de sedes
    $( '#sede' ).change( function()
    {
        var el_continente = $(this).val();

    });

})
