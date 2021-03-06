<?php

session_start();
header("Content-type: text/html; charset=iso8859-1");
error_reporting(E_ALL);
ini_set("display_errors", 1);
include('../librerias/fpdf/fpdf.php');
include('../../resources/orcl_conex.php');
include('../../resources/select/funciones.php');
include('Models/class.Denuncia.php');
include('Models/class.DenunciaDAO.php');
include('../mod_ciudadanos/Models/class_fisc_ciudadano.php');
include('../mod_ciudadanos/Models/class_fisc_ciudadanoDAO.php');
include('../mod_empresas/Models/class_fisc_empresa.php');
include('../mod_empresas/Models/class_fisc_empresaDAO.php');

$id_denuncia = $_GET['id_denuncia'];

$modelo1 = new DenunciaDAO();

$denuncia = $modelo1->getByID($id_denuncia);

$estatus = $denuncia->__GET('estatus_denuncia');

$fecha = $denuncia->__GET('fecha_denuncia');

$descripcion_estatus = $denuncia->__GET('descripcion_estatus');

$modelo_ciudadano = new FiscCiudadanoDAO();

$ciudadano = $modelo_ciudadano->getById($denuncia->__GET('id_ciudadano'));

$modelo_empresa = new FiscEmpresaDAO();
$id_empresa = $denuncia->__GET('id_empresa');
$empresa = $modelo_empresa->queryByPatrono($id_empresa);

$funcionario  = $_SESSION['USUARIO']['codigo_usuario'];
$id_estado    = $_SESSION['USUARIO']['estado'];
$estado       = dameEstadoById($id_estado);
$direccion    = $estado[0]['NOMBRE_ESTADO'];

$denunciante = $ciudadano->__GET('apellidos'). "  ".$ciudadano->__GET('nombres');
$cedula_denunciante = $ciudadano->__GET('id_ciudadano');
$motivos = $modelo1->getMotivos($denuncia);
$nombre_empresa = $empresa->__GET('nombre_fisc_empresa');

//echo $descripcion_estatus;
//$DescripDenuncia = $descripcion_estatus;
//$motivo = ($denuncia->__GET('motivo_denuncia'));
//$motivo_denuncia = $motivos[$motivo]['DESCRIPCION'];


$pdf = new  FPDF('P');
$pdf->AddPage();
$pdf->Image('../../public_html/imagenes/logoclaro.png',40,50,120);
$pdf->SetTitle("Notificación al denunciante",true);

$pdf->Image('../../public_html/imagenes/logoivss.png',20,7,13);

$pdf->SetFont('Arial','',6);
$pdf->Text(40,10,utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'));
$pdf->Text(40,13,utf8_decode('MINISTERIO DEL PODER POPULAR PARA EL PROCESO SOCIAL DE TRABAJO'));
$pdf->Text(40,16,utf8_decode('INSTITUTO VENEZOLANO DE LOS SEGUROS SOCIALES'));
$pdf->Text(40,19,utf8_decode('DIRECCIÓN GENERAL DE FISCALIZACIÓN'));

$pdf->SetFont('Arial','B',10);
$pdf->Text(20,31,utf8_decode('NOTIFICACIÓN DE CIERRE DE DENUNCIA'));

$pdf->SetXY(95,22);
$pdf->SetFillColor(35,65,129);
$pdf->SetFont('Arial','',6);
$pdf->setTextColor(255,255,255);
$pdf->Cell(25,4,utf8_decode('LUGAR'),1, 0 , 'C' , true);
$pdf->Cell(25,4,utf8_decode('FECHA'),1, 0 , 'C' , true);
$pdf->Cell(40,4,utf8_decode('N° DE DENUNCIA'),1, 0 , 'C' , true);
$pdf->Ln();

$pdf->SetXY(95,26);
$pdf->setTextColor(0,0,0);
$pdf->Cell(25,6,$direccion,1, 0 , 'C' , FALSE);
$pdf->Cell(25,6,$fecha,1, 0 , 'C' , FALSE);
$pdf->Cell(40,6,$id_denuncia,1, 0 , 'C' , FALSE);
$pdf->Ln();

$pdf->SetXY(20,40);
$pdf->SetFillColor(35,65,129);
$pdf->SetFont('Arial','',8);
$pdf->setTextColor(255,255,255);
$pdf->Cell(70,6,utf8_decode('APELLIDOS Y NOMBRES DEL DENUNCIANTE'),1,0,'C',TRUE);
$pdf->setTextColor(0,0,0);
$pdf->Cell(95,6,$denunciante,1, 0 , 'C' , FALSE);
$pdf->Ln();

$pdf->SetXY(20,50);
$pdf->setTextColor(255,255,255);
$pdf->Cell(165,6,utf8_decode('MOTIVO(S) DE LA DENUNCIA'),1,0,'C',TRUE);
$pdf->Rect(20,56,165,25,'fill');
$pdf->setTextColor(0,0,0);

$pdf->SetXY(20,60);
$pdf->SetRightMargin(25.0);
$texto ="";
foreach ($motivos as $key => $motivo)
{
	$texto.=  $motivo['DESCRIPCION']. ", ";
}

$texto = substr($texto, 0,-2);
$pdf->MultiCell(0,4,utf8_decode($texto));

$pdf->SetRightMargin(25.0);
$pdf->SetXY(20,90);
$pdf->setTextColor(0,0,0);
$pdf->MultiCell(0,4,utf8_decode('Le notificamos que la denuncia interpuesta por usted, fue atendidida de acuerdo al proceso intrínseco de verificación, el cual fue realizado por esta Dirección General de Fiscalización de acuerdo a lo establecido en las normas legales vigentes que rigen la materia y del cual se desprende lo siguiente:'));

$pdf->SetXY(20,107);
////Aqui va la descripcion.
$pdf->MultiCell(0,4,utf8_decode(html_entity_decode($descripcion_estatus)));

//$pdf->Line(20,110,190,110);
//$pdf->Line(20,115,190,115);
//$pdf->Line(20,120,190,120);

$pdf->SetXY(20,130);
$pdf->MultiCell(0,4,utf8_decode('A tal efecto, se deja constancia que el caso presentado, recibió el (los) documentos(s) solicitado(s) o fue notificado del estatus final de la denuncia interpuesta. Por tal motivo, este despacho procede con la liquidación y/o cierre del expediente en contra de la empresa:'));
$pdf->Line(20,150,120,150);
$pdf->Text(23,149,utf8_decode($nombre_empresa));
$pdf->Text(122,150,utf8_decode('N° Patronal:'));
$pdf->Text(150,149,utf8_decode($id_empresa));
$pdf->Line(140,150,180,150);

$pdf->SetXY(20,155);
$pdf->MultiCell(0,4,utf8_decode('En consecuencia, ya no existen elementos que traigan consigo la continuidad e impulso del proceso comtemplado en el articulo 91 de la Reforma parcial de la ley del Seguro Social, este en concordancia a su vez con el articulo 121 del código Orgánico Tributario, amparado al artículo 86 de la Constitución de la República Bolivariana de Venezuela, príncial rector en materia de Seguridad Social.'));

$pdf->SetXY(20,175);
$pdf->SetFont('Arial','',8);
$pdf->setTextColor(255,255,255);
$pdf->Cell(50,6,utf8_decode('ELABORADO POR FUNCIONARIO(A)'),1,0,'C',TRUE);

$pdf->Cell(60,6,utf8_decode('AUTORIZADO POR'),1,0,'C',TRUE);
$pdf->Cell(60,6,utf8_decode('RECIBE CONFORME(DENUNCIANTE)'),1,0,'C',TRUE);
$pdf->Ln();


$pdf->SetFont('Arial','',8);
$pdf->setTextColor(0,0,0);
$pdf->Rect(20,181,50,10,'fill');
$pdf->Rect(70,181,60,10,'fill');
$pdf->Rect(20,191,50,20,'fill');
$pdf->Rect(70,191,60,20,'fill');
$pdf->Rect(130,191,60,20,'fill');
$pdf->Rect(130,181,60,30,'fill');

$pdf->Rect(20,211,50,5,'fill');
$pdf->Rect(70,211,60,5,'fill');
$pdf->Rect(130,211,60,5,'fill');

$pdf->SetFont('Arial','',6);
$pdf->Text(30,185,utf8_decode('CÓDIGO DEL FUNCIONARIO'));
$pdf->Text(38,188,utf8_decode($funcionario));
$pdf->Text(148,188,utf8_decode($cedula_denunciante));
$pdf->Text(85,185,utf8_decode('APELLIDOS Y NOMBRES'));
$pdf->Text(145,185,utf8_decode('CÉDULA DE IDENTIDAD'));

//$pdf->Text(30,209,utf8_decode('CÉDULA DE IDENTIDAD'));
$pdf->Text(40,214,utf8_decode('FIRMA'));
$pdf->Text(90,214,utf8_decode('FIRMA Y SELLO'));
$pdf->Text(156,214,utf8_decode('FIRMA'));

$nombre = "Notificación de cierre de Denuncia-".$id_denuncia.".pdf";	

$pdf->Output($nombre,'D');

?>