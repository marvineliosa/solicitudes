<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Envío de contraseña</title>
</head>
<body>
    <p>Buen día, a continuación le proporcionamos los datos de acceso al sistema {!! $tipo_sistema !!} para realizar solicitudes de personal.</p>
    <p>Usuario: {!! $user !!}</p>
    <p>Contraseña: {!! $pass !!}</p>
    <p>La url del sitio es: http://{!! $url !!}</p>
    <p>Su clave de dependencia es: {!! $codigo_dependencia !!}</p>
    <p>Si usted no solicitó la creación de usuario, favor de comunicarse a la extensión: 5897</p>
</body>
</html>