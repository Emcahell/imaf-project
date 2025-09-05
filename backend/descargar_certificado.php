<?php
// filepath: c:\xampp\htdocs\imaf-project\backend\descargar_certificado.php
require(__DIR__ . '/../fpdf/fpdf.php');
include("conexion.php");

$participante_id = intval($_GET['participante_id']);

// Consulta datos del participante y curso
$q = mysqli_query($conex, "
    SELECT u.nombre, u.apellido, u.cedula, cu.nombre AS curso, c.fecha_fin
    FROM curso_participante cp
    JOIN estudiante e ON cp.id_estudiante = e.id
    JOIN usuario u ON e.usuario_id = u.id
    JOIN curso_promocion c ON cp.id_curso_promocion = c.id
    JOIN curso cu ON c.id_curso = cu.id
    WHERE cp.id = $participante_id AND cp.graduado = 1
");
$row = mysqli_fetch_assoc($q);

if (!$row) {
    die("No autorizado o no graduado.");
}


// Crear PDF horizontal
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

// Logo IMAF arriba a la izquierda
$pdf->Image(__DIR__ . '/../assets/recursos/logo-imaf.png', 15, 12, 30, 0);

// Bordes decorativos (simples líneas)
$pdf->SetDrawColor(150, 0, 150);
$pdf->SetLineWidth(1.5);
$pdf->Rect(10, 10, 277, 190);

// Título principal
$pdf->SetFont('Arial', 'B', 32);
$pdf->SetTextColor(30, 30, 60);
$pdf->Cell(0, 35, utf8_decode('CERTIFICADO DE RECONOCIMIENTO'), 0, 1, 'C');

// Subtítulo
$pdf->SetFont('Arial', '', 16);
$pdf->SetTextColor(60, 60, 90);
$pdf->Cell(0, 10, utf8_decode("Por su notable desempeño en el curso de {$row['curso']} se le hace entrega de este diploma a:"), 0, 1, 'C');

// Nombre del participante (estilo firma)
$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 36);
$pdf->SetTextColor(30, 30, 60);
$pdf->Cell(0, 20, utf8_decode("{$row['nombre']} {$row['apellido']}"), 0, 1, 'C');

// Cédula
$pdf->SetFont('Arial', '', 16);
$pdf->SetTextColor(60, 60, 90);
$pdf->Cell(0, 10, utf8_decode("Cédula: {$row['cedula']}"), 0, 1, 'C');

// Fecha de finalización
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 16);
$pdf->Cell(0, 10, utf8_decode("{$row['fecha_fin']}"), 0, 1, 'C');

// Firma y cargos
$pdf->Ln(18);
$pdf->SetFont('Arial', 'I', 14);
$pdf->SetTextColor(120, 0, 120);
$pdf->Cell(90, 10, utf8_decode('Bruno Lago'), 0, 0, 'C');
$pdf->Cell(97, 10, '', 0, 0, 'C');
$pdf->Cell(90, 10, utf8_decode('Rosa Martínez'), 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(60, 60, 90);
$pdf->Cell(90, 8, utf8_decode('Director'), 0, 0, 'C');
$pdf->Cell(97, 8, '', 0, 0, 'C');
$pdf->Cell(90, 8, utf8_decode('Subdirector'), 0, 1, 'C');

// Sello decorativo (círculo simple)
$pdf->SetFillColor(120, 0, 120);
// $pdf->Circle(150, 160, 15, 'F'); // x, y, radio, estilo


// Descargar PDF con nombre personalizado
$filename = "{$row['nombre']}_{$row['cedula']}_{$row['curso']}_certificado.pdf";
$pdf->Output('D', $filename);
exit;
?>