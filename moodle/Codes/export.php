<?php
require 'vendor/autoload.php'; // Include Composer autoloader

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

if (isset($_POST['tableContent'])) {
    // Get the table content from the POST data
    $tableContent = $_POST['tableContent'];

    // Create a new PhpSpreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add image to cell
    $imgPath = './images/zoom.png'; // Replace with the actual path to the downloaded image
    $drawing = new Drawing();
    $drawing->setName('Customer Signature');
    // ... (rest of your image drawing code)

    // Add the drawing to the worksheet
    $sheet->getRowDimension(1)->setRowHeight(50);
    $sheet->getRowDimension(1)->setRowHeight(50);
    $sheet->getDrawingCollection()->append($drawing);

    // Save the spreadsheet as a file
    $fileName = 'output.xlsx';
    $filePath = __DIR__ . '/' . $fileName;

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save($filePath);

    // Set headers for file download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Content-Length: ' . filesize($filePath));
    readfile($filePath);

    // Clean up - delete the temporary file
    unlink($filePath);
}
?>
