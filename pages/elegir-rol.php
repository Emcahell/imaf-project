
<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Elegir Rol</title>
    <link rel="stylesheet" href="../styles/register.css?v=<?=time()?>">
    <style>
        .elegir-rol-container {
            max-width: 400px;
            margin: 60px auto;
            padding: 32px 24px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 16px #0001;
            text-align: center;
        }
        .elegir-rol-btn {
            display: block;
            width: 100%;
            margin: 16px 0;
            padding: 12px;
            font-size: 1.1em;
            border: none;
            border-radius: 8px;
            background: #7fffa7;
            color: #222;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }
        .elegir-rol-btn:hover {
            background: #5fdc8b;
        }
    </style>
</head>
<body>
    <div class="elegir-rol-container">
        <h2>¿Con qué rol deseas ingresar?</h2>
        <form method="post" action="">
            <button type="submit" name="rol" value="estudiante" class="elegir-rol-btn">Estudiante</button>
            <button type="submit" name="rol" value="docente" class="elegir-rol-btn">Docente</button>
        </form>
    </div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rol'])) {
    $rol = $_POST['rol'];
    $_SESSION['rol'] = $rol;
    if ($rol === 'estudiante') {
        header("Location: /imaf-project/pages/estudiante/cursos.php");
    } elseif ($rol === 'docente') {
        header("Location: /imaf-project/pages/profesor/cursos.php");
    }
    exit;
}
?>