<?php
    require __DIR__.'/vendor/autoload.php';
    $access_token ='TEST-5565769484515561-032012-1d1c415d04c19f5980550673cdd65e29-637707328';
    MercadoPago\SDK::setAccessToken($access_token);
    $preference = new MercadoPago\Preference();
    $preference -> back_urls= array(
        "success"=>"http://localhost/jano por todos gero/home.html",
        "failure"=>"http://localhost/jano por todos gero/donaciones.php",
        "pending"=>"http://localhost/jano por todos gero/donaciones.php"
    );
    $productos = [];
    $item = new MercadoPago\Item();
    $item -> title = "Donacion Jano por Todos"; 
    $item -> quantity = 1;
    $item -> unit_price = intval($_GET["monto"]);
    $preference -> items= $productos;
    $preference -> save();
?>

<!DOCTYPE html>
<html lang=”es”>
<head>
    <meta charset=”UTF-8″ />
    <title>Donacion</title>
    
</head>
<body>  
    <script src="https://sdk.mercadopago.com/js/v2"></script>   
    <div class="cho-container"></div>
    <script>
    const mp = new MercadoPago('TEST-cadc5c75-6e28-4473-aa27-bf3db4427d38', {
        locale: 'es-AR'
    });

    mp.checkout({
        preference: {
        id: '<?php echo $preference->id; ?>'
        },
        render: {
        container: '.cho-container',
        label: 'Pagar',
        }
    });
    </script>
</body>
</html>