<?php

namespace App\Http\Controllers;



use FPDF;
use TCPDF;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Aws\S3\S3Client;
use App\Models\Mcert;
use Barryvdh\DomPDF\PDF;
use App\Models\McertFile;
use App\Models\McertAppFile;
use App\Models\McertNewFile;
use Illuminate\Http\Request;
use setasign\Fpdi\Tcpdf\Fpdi;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use setasign\Fpdi\PdfParser\StreamReader;

class PDFController extends Controller
{
    public function generatePDF($id)
    {
        $mcert = Mcert::findOrFail($id);

        // Additional data to pass to the Blade view
        $data = [
            'mcert' => $mcert,
            'customData' => 'Custom Content Here',
        ];

        // Render the Blade view to HTML content
        $html = view('pdf', $data)->render();

        // Set the margins
        
        // Create a new FPDF instance
        $pdf = new FPDF('P', 'in', 'Legal');
        $pdf->AddPage();

 
        // Set the margins
        $leftMargin = 0.5;
        $topMargin = 0.5;
        $bottomMargin = 0.5;
        $rightMargin = 0.3;

        $pdf->SetMargins($leftMargin, $topMargin, $rightMargin);

        // Calculate the coordinates of the border
        $x1 = $pdf->GetX();
        $y1 = $pdf->GetY();
        $x2 = $pdf->GetPageWidth() - $rightMargin;
        $y2 = $pdf->GetPageHeight() - $bottomMargin;

        // Set the border properties
        $borderWidth = 0.002; // 1/500 inch
        $pdf->SetDrawColor(0, 0, 0);

        // Draw the top border lines
        for ($i = 0; $i < 5; $i++) {
            $pdf->SetLineWidth($borderWidth);
            $pdf->Line($x1, $y1 + $i * $borderWidth, $x2, $y1 + $i * $borderWidth);
        }

        // Draw the bottom border lines
        for ($i = 0; $i < 5; $i++) {
            $pdf->SetLineWidth($borderWidth);
            $pdf->Line($x1, $y2 - $i * $borderWidth, $x2, $y2 - $i * $borderWidth);
        }

        // Draw the left border lines
        for ($i = 0; $i < 5; $i++) {
            $pdf->SetLineWidth($borderWidth);
            $pdf->Line($x1 + $i * $borderWidth, $y1, $x1 + $i * $borderWidth, $y2);
        }

        // Draw the right border lines
        for ($i = 0; $i < 5; $i++) {
            $pdf->SetLineWidth($borderWidth);
            $pdf->Line($x2 - $i * $borderWidth, $y1, $x2 - $i * $borderWidth, $y2);
        }

        // Add "Municipal Form No. 90 (Form No. 2)" at the upper left near the left border
        $pdf->SetFont('Helvetica', '', 9);
        $pdf->SetXY($x1 + 0.05, $y1 + 0.002);
        $pdf->Cell(2, 0.2, 'Municipal Form No. 90 (Form No. 2)', 0, 0, 'L');

        // Add "(To be accomplished in quadruplicate using black ink )" at the upper right inside the border
        $wordWidth = $pdf->GetStringWidth('(To be accomplished in quadruplicate using black ink )');
        $wordX = $x2 - $rightMargin - $wordWidth;
        $pdf->SetXY($wordX + 0.002, $y1 + 0.002);
        $pdf->Cell($wordWidth, 0.2, '(To be accomplished in quadruplicate using black ink )', 0, 0, 'L');

        // Add "(Revised January 2007)" below the Municipal Form
        $pdf->SetXY($x1 + 0.05, $y1 + 0.15);
        $pdf->Cell(2, 0.2, '(Revised January 2007)', 0, 0, 'L');

        $pdf->SetFont('Helvetica', '', 10);
        $centerX = ($x1 + $x2) / 2;
        $textWidth = $pdf->GetStringWidth('Republic of the Philippines');
        $textX = $centerX - ($textWidth / 2);

        $pdf->SetXY($textX, $y1 + 0.15);
        $pdf->Cell($textWidth, 0.2, 'Republic of the Philippines', 0, 0, 'L');
        

        $pdf->SetFont('Helvetica', '', 10);
        $officeWidth = $pdf->GetStringWidth('OFFICE OF THE CIVIL REGISTRAR GENERAL');

        $officeX = $centerX - ($officeWidth / 2);
        $officeY = $y1 + 0.15 + 0.15;

        $pdf->SetXY($officeX, $officeY);
        $pdf->Cell($officeWidth, 0.2, 'OFFICE OF THE CIVIL REGISTRAR GENERAL', 0, 0, 'L');

        $pdf->SetFont('Helvetica', 'B', 16);
        $applicationWidth = $pdf->GetStringWidth('APPLICATION FOR MARRIAGE LICENSE');

        $applicationX = $centerX - ($applicationWidth / 2);
        $applicationY = $officeY + 0.2;

        $pdf->SetXY($applicationX, $applicationY);
        $pdf->Cell($applicationWidth, 0.2, 'APPLICATION FOR MARRIAGE LICENSE', 0, 0, 'L');

        // Calculate the width of the line based on the border width
        $lineWidth = $borderWidth / 2;

        // Calculate the coordinates for the horizontal line
        $lineY = $applicationY + 0.25;
        $lineX1 = $x1 + $lineWidth;
        $lineX2 = $x2 - $lineWidth;

        // Set the line thickness
        $pdf->SetLineWidth($lineWidth);

        // Draw the horizontal line
        $pdf->Line($lineX1, $lineY, $lineX2, $lineY);

        $pdf->SetFont('Helvetica', '', 10);

        // Calculate the width of the "Province" cell
        $provinceWidth = $pdf->GetStringWidth('Province');
        
        // Calculate the coordinates for the "Province" cell
        $provinceX = $lineX1 + 0.05;
        $provinceY = $lineY + 0.10;
        
        // Set the position and print the "Province" text
        $pdf->SetXY($provinceX, $provinceY);
        $pdf->Cell($provinceWidth, 0.2, 'Province', 0, 0, 'L');
        
        // Add the value of $mcert->mcert_city below "Province"
        $cityX = $provinceX + 0.0120;
        $cityY = $provinceY + 0.23;
        $cityWidth = $pdf->GetStringWidth('City/Municipality:');

        $pdf->SetXY($cityX, $cityY);
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell($cityWidth, 0.2, 'City/Municipality', 0, 0, 'L');

        // Calculate the underline coordinates for "City/Municipality"
        $cityUnderlineX1 = $cityX + $cityWidth + 3.5;
        $cityUnderlineX2 = $cityX + $cityWidth;
        $cityUnderlineY = $cityY + 0.2;

        // Draw the underline for "City/Municipality"
        $pdf->Line($cityUnderlineX1, $cityUnderlineY, $cityUnderlineX2, $cityUnderlineY);

        // Add the value of $mcert->mcert_city below the underline
        $cityValueX = $cityX + 2;
        $cityValueY = $cityY + 0.008;
        $cityValueWidth = $pdf->GetStringWidth($mcert->mcert_municipality);

        $pdf->SetXY($cityValueX, $cityValueY);
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell($cityValueWidth, 0.2, $mcert->mcert_municipality, 0, 0, 'L');

        // Calculate the width of the registry number
        $registryWidth = $pdf->GetStringWidth($mcert->mcert_province);
        
        // Calculate the coordinates for the registry number
        $registryX = $provinceX + $provinceWidth + 1;
        $registryY = $provinceY - 0.01;
        
        // Set the position and print the registry number
        $pdf->SetXY($registryX, $registryY);
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell($registryWidth, 0.2, $mcert->mcert_province, 0, 0, 'L');
        
        // Calculate the underline coordinates
        $underlineX1 = $provinceX + $provinceWidth + 0.1;
        $underlineX2 = $underlineX1 + 4;
        $underlineY = $provinceY + 0.17;
                
        // Set the line thickness to match the line above
        $pdf->SetLineWidth($lineWidth);
        
        // Draw the underline
        $pdf->Line($underlineX1, $underlineY, $underlineX2, $underlineY);

        // Add a vertical line
        $verticalLineX = $underlineX2 + 0.5;
        $verticalLineY1 = $underlineY - 0.27;
        $verticalLineY2 = $underlineY + 0.33;

        $pdf->SetLineWidth($lineWidth);
        $pdf->Line($verticalLineX, $verticalLineY1, $verticalLineX, $verticalLineY2);
        
        
        // Add the word "Registry No" after the vertical line
        $registryNoX = $verticalLineX + 0.1;
        $registryNoY = $provinceY;
        $registryNoWidth = $pdf->GetStringWidth('Registry No:');
        

        $pdf->SetXY($registryNoX, $registryNoY);
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell($registryNoWidth, 0.2, 'Registry No:', 0, 0, 'L');

        // Add the value of $mcert->mcert_registry_no below the "Registry No" label
        $registryValueX = $registryNoX + 0.9;
        $registryValueY = $registryNoY + 0.2;
        $registryValueWidth = $pdf->GetStringWidth($mcert->mcert_registry_no);

        $pdf->SetXY($registryValueX, $registryValueY);
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell($registryValueWidth, 0.2, $mcert->mcert_registry_no, 0, 0, 'L');


        // Calculate the coordinates for the horizontal line
        $lineY2 = $registryValueY + 0.3;
        $lineX1 = $x1 + $lineWidth;
        $lineX2 = $x2 - $lineWidth;

        // Draw the second horizontal line
        $pdf->SetLineWidth($lineWidth);
        $pdf->Line($lineX1, $lineY2, $lineX2, $lineY2);

        $pdf->SetFont('Helvetica', '', 10);

// Calculate the width of the "Received by" label
$receivedByWidth = $pdf->GetStringWidth('Received by:');

// Calculate the coordinates for the "Received by" label
$receivedByX = $x1 + 0.05;
$receivedByY = $lineY2 + 0.01;
$pdf->SetXY($receivedByX, $receivedByY);
$pdf->Cell($receivedByWidth, 0.2, 'Received by:', 0, 0, 'L');

// Calculate the coordinates for the underline of "Received by"
$receivedByUnderlineX1 = $receivedByX + 0.85;
$receivedByUnderlineX2 = $receivedByUnderlineX1 + 2.8;
$receivedByUnderlineY = $receivedByY + 0.19;
$pdf->Line($receivedByUnderlineX1, $receivedByUnderlineY, $receivedByUnderlineX2, $receivedByUnderlineY);

// Add the value of $mcert->mcert_received_by above the underline
$receivedByValueX = $receivedByX + $receivedByWidth + 0.7;
$receivedByValueY = $receivedByY - 0.015;
$receivedByValueWidth = $pdf->GetStringWidth($mcert->mcert_received_by);
$pdf->SetXY($receivedByValueX, $receivedByValueY);
$pdf->Cell($receivedByValueWidth, 0.2, $mcert->mcert_received_by, 0, 0, 'L');

// Add a vertical line
$verticalLineX = $receivedByUnderlineX2 + 0.19;
$verticalLineY1 = $receivedByUnderlineY - 0.199;
$verticalLineY2 = $receivedByUnderlineY + 1.95;
$pdf->SetLineWidth($lineWidth);
$pdf->Line($verticalLineX, $verticalLineY1, $verticalLineX, $verticalLineY2);

// Calculate the width of the "Date of Receipt:" label
$dateOfReceiptWidth = $pdf->GetStringWidth('Date of Receipt:');

// Calculate the coordinates for the "Date of Receipt:" label
$dateOfReceiptX = $receivedByX;
$dateOfReceiptY = $receivedByY + 0.19;
$pdf->SetXY($dateOfReceiptX, $dateOfReceiptY);
$pdf->Cell($dateOfReceiptWidth, 0.2, 'Date of Receipt:', 0, 0, 'L');

// Calculate the coordinates for the underline of "Date of Receipt:"
$dateOfReceiptUnderlineX1 = $dateOfReceiptX + $dateOfReceiptWidth + 0.07;
$dateOfReceiptUnderlineX2 = $dateOfReceiptUnderlineX1 + 2.59;
$dateOfReceiptUnderlineY = $dateOfReceiptY + 0.19;
$pdf->Line($dateOfReceiptUnderlineX1, $dateOfReceiptUnderlineY, $dateOfReceiptUnderlineX2, $dateOfReceiptUnderlineY);

// Add the value of $mcert->mcert_date_of_receipt above the underline
$dateOfReceiptValueX = $dateOfReceiptX + $dateOfReceiptWidth + 1;
$dateOfReceiptValueY = $dateOfReceiptY - 0.005;
$dateOfReceiptValueWidth = $pdf->GetStringWidth($mcert->mcert_date_of_receipt);
$pdf->SetXY($dateOfReceiptValueX, $dateOfReceiptValueY);
$pdf->Cell($dateOfReceiptValueWidth, 0.2, $mcert->mcert_date_of_receipt, 0, 0, 'L');

// Calculate the width of the "Marriage License No." label
$marriageLicenseWidth = $pdf->GetStringWidth('Marriage License No. :');

// Calculate the coordinates for the "Marriage License No." label
$marriageLicenseX = $verticalLineX + 0.1;
$marriageLicenseY = $receivedByY;
$pdf->SetXY($marriageLicenseX, $marriageLicenseY);
$pdf->Cell($marriageLicenseWidth, 0.2, 'Marriage License No.:', 0, 0, 'L');

// Calculate the coordinates for the underline of "Marriage License No."
$marriageLicenseUnderlineX1 = $marriageLicenseX + $marriageLicenseWidth +  0.07;
$marriageLicenseUnderlineX2 = $marriageLicenseUnderlineX1 + 2.24;
$marriageLicenseUnderlineY = $marriageLicenseY + 0.19;
$pdf->Line($marriageLicenseUnderlineX1, $marriageLicenseUnderlineY, $marriageLicenseUnderlineX2, $marriageLicenseUnderlineY);

// Add the value of $mcert->mcert_marriage_license_no above the underline
$marriageLicenseValueX = $marriageLicenseX + $marriageLicenseWidth + 1;
$marriageLicenseValueY = $marriageLicenseY - 0.015;
$marriageLicenseValueWidth = $pdf->GetStringWidth($mcert->mcert_marriage_license_no);
$pdf->SetXY($marriageLicenseValueX, $marriageLicenseValueY);
$pdf->Cell($marriageLicenseValueWidth, 0.2, $mcert->mcert_marriage_license_no, 0, 0, 'L');

// Calculate the width of the "Date of Issuance of Marriage License:" label
$dateOfIssuanceWidth = $pdf->GetStringWidth('Date of Issuance of Marriage License:');

// Calculate the coordinates for the "Date of Issuance of Marriage License:" label
$dateOfIssuanceX = $receivedByX + 3.94;
$dateOfIssuanceY = $receivedByY + 0.19;
$pdf->SetXY($dateOfIssuanceX, $dateOfIssuanceY);
$pdf->Cell($dateOfIssuanceWidth, 0.2, 'Date of Issuance of Marriage License:', 0, 0, 'L');

// Calculate the coordinates for the underline of "Date of Issuance of Marriage License:"
$dateOfIssuanceUnderlineX1 = $dateOfIssuanceX + $dateOfIssuanceWidth + 0.07;
$dateOfIssuanceUnderlineX2 = $dateOfIssuanceUnderlineX1 + 1.30;
$dateOfIssuanceUnderlineY = $dateOfIssuanceY + 0.19;
$pdf->Line($dateOfIssuanceUnderlineX1, $dateOfIssuanceUnderlineY, $dateOfIssuanceUnderlineX2, $dateOfIssuanceUnderlineY);

// Add the value of $mcert->mcert_date_of_issuance above the underline
$dateOfIssuanceValueX = $dateOfIssuanceX + $dateOfIssuanceWidth + 0.30;
$dateOfIssuanceValueY = $dateOfIssuanceY - 0.005;
$dateOfIssuanceValueWidth = $pdf->GetStringWidth($mcert->mcert_date_of_issuance);
$pdf->SetXY($dateOfIssuanceValueX, $dateOfIssuanceValueY);
$pdf->Cell($dateOfIssuanceValueWidth, 0.2, $mcert->mcert_date_of_issuance, 0, 0, 'L');

// Calculate the coordinates for the horizontal line
$lineY2 = $registryValueY + 0.76;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;

// Draw the second horizontal line
$pdf->SetLineWidth($lineWidth);
$pdf->Line($lineX1, $lineY2, $lineX2, $lineY2);

$pdf->SetFont('Helvetica', 'B', 10);

// Calculate the width of the cell for "GROOM"
$groomWidth = ($x2 - $x1) / 2 - 0.1;

// Calculate the coordinates for the "GROOM" cell
$groomX = $x1;
$groomY = $dateOfIssuanceY + 0.26;
$pdf->SetXY($groomX, $groomY);
$pdf->Cell($groomWidth, 0.2, 'GROOM', 0, 0, 'C');

// Calculate the coordinates for the "BRIDE" cell
$brideX = $groomX + $groomWidth + 0.2;
$brideY = $groomY;
$pdf->SetXY($brideX, $brideY);
$pdf->Cell($groomWidth, 0.2, 'BRIDE', 0, 0, 'C');

// Calculate the coordinates for the horizontal line
$lineY2 = $registryValueY + 0.95;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;

// Draw the second horizontal line
$pdf->SetLineWidth($lineWidth);
$pdf->Line($lineX1, $lineY2, $lineX2, $lineY2);

$pdf->SetFont('Helvetica', 'B', 11);

// Calculate the width of the cell for "The Civil Registrar"
$civilRegistrarWidth = ($x2 - $x1) / 2 - 0.1;

// Calculate the coordinates for the "The Civil Registrar" cell
$civilRegistrarX = $x1 + 0.1;
$civilRegistrarY = $groomY + 0.2;
$pdf->SetXY($civilRegistrarX, $civilRegistrarY);
$pdf->Cell($civilRegistrarWidth, 0.2, 'The Civil Registrar', 0, 0, 'L');

// Calculate the coordinates for the second "The Civil Registrar" cell
$secondCivilRegistrarX = $civilRegistrarX + $civilRegistrarWidth + 0.1;
$secondCivilRegistrarY = $civilRegistrarY;
$pdf->SetXY($secondCivilRegistrarX, $secondCivilRegistrarY);
$pdf->Cell($civilRegistrarWidth, 0.2, 'The Civil Registrar', 0, 0, 'L');

$pdf->SetFont('Times', '', 9);

// Calculate the width of the cell for "Sir/Madam:"
$sirMadamWidth = ($x2 - $x1) / 2 - 0.1;

// Calculate the coordinates for the "Sir/Madam:" cell
$sirMadamX = $x1 + 0.3;
$sirMadamY = $civilRegistrarY + 0.2;
$pdf->SetXY($sirMadamX, $sirMadamY);
$pdf->Cell($sirMadamWidth, 0.2, 'Sir/Madam:', 0, 0, 'L');

// Calculate the coordinates for the second "Sir/Madam:" cell
$secondSirMadamX = $sirMadamX + $sirMadamWidth + 0.1;
$secondSirMadamY = $sirMadamY;
$pdf->SetXY($secondSirMadamX, $secondSirMadamY);
$pdf->Cell($sirMadamWidth, 0.2, 'Sir/Madam:', 0, 0, 'L');

$pdf->SetFont('Times', 'I', 9);
$pdf->SetDrawColor(255, 255, 255); // Set draw color to white for transparent border

// Calculate the width and height for the paragraph cell
$paragraphWidth = ($x2 - $x1) / 2 - 0.50;
$paragraphHeight = 0.15;

// Calculate the coordinates for the paragraph cell
$paragraphX = $x1 + 0.3;
$paragraphY = $sirMadamY + 0.20;
$pdf->SetXY($paragraphX, $paragraphY);
$pdf->MultiCell($paragraphWidth, $paragraphHeight, "     May I apply for a license to contract marriage with __________________________________________ and to this effect, being duly sworn, I hereby depose and say that I have all the necessary qualifications and none of the legal disqualifications to contract the said marriage, and that the following data are true and correct to the best of my knowledge and information:", 0, 'J', false);

// Calculate the coordinates for the second paragraph cell
$secondParagraphX = $paragraphX + $paragraphWidth + 0.50;
$secondParagraphY = $paragraphY;
$pdf->SetXY($secondParagraphX, $secondParagraphY);
$pdf->MultiCell($paragraphWidth, $paragraphHeight, "     May I apply for a license to contract marriage with ___________________________________________ and to this effect, being duly sworn, I hereby depose and say that I have all the necessary qualifications and none of the legal disqualifications to contract the said marriage, and that the following data are true and correct to the best of my knowledge and information:", 0, 'J', false);

$pdf->SetFont('Helvetica', '', 8);

// Calculate the coordinates for the groom name value
$groomValueX = $paragraphX + 0.70;
$groomValueY = $paragraphY + 0.12;
$groomValueWidth = $pdf->GetStringWidth("$mcert->mcert_g_first_name $mcert->mcert_g_middle_name $mcert->mcert_g_last_name");
$pdf->SetXY($groomValueX, $groomValueY);
$pdf->Cell($groomValueWidth, 0.2, "$mcert->mcert_g_first_name $mcert->mcert_g_middle_name $mcert->mcert_g_last_name", 0, 0, 'L');

// Calculate the coordinates for the bride name value
$brideValueX = $secondParagraphX + 0.70;
$brideValueY = $groomValueY + 0.012;
$brideValueWidth = $pdf->GetStringWidth("$mcert->mcert_b_first_name $mcert->mcert_b_middle_name $mcert->mcert_b_last_name");
$pdf->SetXY($brideValueX, $brideValueY);
$pdf->Cell($brideValueWidth, 0.2, "$mcert->mcert_b_first_name $mcert->mcert_b_middle_name $mcert->mcert_b_last_name", 0, 0, 'L');

/// Calculate the coordinates for the horizontal line
$lineY2 = $registryValueY + 2.45;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;

// Set the line color to black
$pdf->SetDrawColor(0, 0, 0);

// Draw the horizontal line
$pdf->SetLineWidth($lineWidth);
$pdf->Line($lineX1, $lineY2, $lineX2, $lineY2);

// Set the font size and font family
$pdf->SetFontSize(8);
$pdf->SetFont('Helvetica');

// Calculate the coordinates for the first column
$column1X = $x1 + 0.06;
$column1Y = $lineY2 + 0.0010;

// Calculate the coordinates for the second column
$column2X = $column1X + 2.5;
$column2Y = $column1Y;

// Calculate the coordinates for the third column
$column3X = $column2X + 2.70;
$column3Y = $column1Y;



// Draw the vertical lines
$pdf->SetLineWidth(0.001);
$pdf->Line($column1X + 3.20, $column1Y, $column1X + 3.20, $column1Y + 8.17);
$pdf->Line($column2X + 1.85, $column2Y, $column2X + 1.85, $column2Y + 8.17);

// Set the content for the first column
$pdf->SetXY($column1X + 0.90, $column1Y );
$pdf->Cell(7.90, 0.20, $mcert->mcert_g_first_name, 0, 0, 'L');
$pdf->SetXY($column1X, $column1Y);
$pdf->Cell(1.90, 0.30, '(First)...........................................................................................', 0, 0, 'L');

// Set the position of the middle column
$pdf->SetXY($column1X + 0.90, $column1Y + 0.15 );
$pdf->Cell(7.90, 0.20, $mcert->mcert_g_middle_name, 0, 0, 'L');
$pdf->SetXY($column1X, $column1Y );
$pdf->Cell(1.90, 0.60, '(Middle).......................................................................................', 0, 0, 'L');

// Set the position of the last column
$pdf->SetXY($column1X + 0.90, $column1Y + 0.30 );
$pdf->Cell(7.90, 0.20, $mcert->mcert_g_last_name, 0, 0, 'L');
$pdf->SetXY($column1X, $column1Y);
$pdf->Cell(1.90, 0.90, '(Last)...........................................................................................', 0, 0, 'L');
// Set the content for the second column

$pdf->SetXY($column2X, $column2Y);
$pdf->Cell(2.6, 0.5, '1. Name of Applicant', 0, 0, 'C');

// Set the content for the third column
$pdf->SetXY($column3X + 0.50, $column3Y);
$pdf->Cell(0.30, 0.20, $mcert->mcert_b_first_name, 0, 0, 'R');
$pdf->SetXY($column3X, $column3Y);
$pdf->Cell(2.3, 0.30, '(First)........................................................................................', 0, 0, 'R');

$pdf->SetXY($column3X + 0.010, $column3Y + 0.15 );
$pdf->Cell(0.50, 0.20, $mcert->mcert_b_middle_name, 0, 0, 'R');
$pdf->SetXY($column3X, $column3Y);
$pdf->Cell(2.3, 0.60, '(Middle)....................................................................................', 0, 0, 'R');

$pdf->SetXY($column3X + 0.16, $column3Y + 0.30);
$pdf->Cell(0.30, 0.20, $mcert->mcert_b_last_name, 0, 0, 'R');
$pdf->SetXY($column3X, $column3Y);
$pdf->Cell(2.3, 0.90, '(Last)........................................................................................', 0, 0, 'R');

/// Calculate the coordinates for the horizontal line
$lineY2 = $registryValueY + 2.99;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;

// Set the line color to black
$pdf->SetDrawColor(0, 0, 0);

// Draw the horizontal line
$pdf->SetLineWidth($lineWidth);
$pdf->Line($lineX1, $lineY2, $lineX2, $lineY2);

$lineX = $column1X + 2.40; // Adjust the X-coordinate based on the column width
$lineY1 = $column1Y + 0.90; // Adjust the starting Y-coordinate of the line
$lineY2 = $column1Y + 0.54; // Adjust the ending Y-coordinate of the line

// Define the thickness of the vertical line
$lineWidth = - 0.2; // Adjust the line width as needed, a positive value

// Draw the vertical line
$pdf->SetLineWidth($lineWidth);
$pdf->Line($lineX, $lineY1, $lineX, $lineY2);

$lineX = $column3X + 1.70; // Adjust the X-coordinate based on the column width
$lineY1 = $column3Y + 0.90; // Adjust the starting Y-coordinate of the line
$lineY2 = $column3Y + 0.54; // Adjust the ending Y-coordinate of the line

// Define the thickness of the vertical line
$lineWidth = - 0.2; // Adjust the line width as needed, a positive value

// Draw the vertical line
$pdf->SetLineWidth($lineWidth);
$pdf->Line($lineX, $lineY1, $lineX, $lineY2);

// Set the labels for each column
$pdf->SetFont('Helvetica', '', 8);

$dayOfBirth = date('d', strtotime($mcert->mcert_g_date_of_birth));
// Label for column 1
$label1X = $column1X + 0.005;
$label1Y = $column1Y + 0.62;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0, 0, '(Day)', 0, 0, 'L');

// Set the position for the day value
$dayValueX = $label1X + 0.15;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(1.15, 0, $dayOfBirth, 0, 0, 'L');


$monthOfBirth = date('F', strtotime($mcert->mcert_g_date_of_birth));
// Label for column 2
$label2X = $column1X + 0.80;
$label2Y = $column1Y + 0.62;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0, 0, '(Month)', 0, 0, 'L');

// Set the position for the month value
$monthValueX = $label2X + 0.12;
$monthValueY = $label2Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($monthValueX, $monthValueY);
$pdf->Cell(1.15, 0, $monthOfBirth, 0, 0, 'L');


$yearOfBirth = date('Y', strtotime($mcert->mcert_g_date_of_birth));
// Label for column 3
$label3X = $column1X + 1.80;
$label3Y = $column1Y + 0.62;
$pdf->SetXY($label3X, $label3Y);
$pdf->Cell(0, 0, '(Year)', 0, 0, 'L');

// Set the position for the year value
$yearValueX = $label3X + 0.20;
$yearValueY = $label3Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($yearValueX, $yearValueY);
$pdf->Cell(1.15, 0, $yearOfBirth, 0, 0, 'L');

// Label for column 4
$label4X = $column1X + 2.58;
$label4Y = $column1Y + 0.62;
$pdf->SetXY($label4X, $label4Y);
$pdf->Cell(0, 0, '(Age)', 0, 0, 'L');

// Set the position for the age value
$ageValueX = $label4X + 0.10;
$ageValueY = $label4Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($ageValueX, $ageValueY);
$pdf->Cell(1.15, 0, $mcert->mcert_g_age, 0, 0, 'L');

// Set the labels for each column
$pdf->SetFont('Helvetica', '', 8);

// Label for column 1
$label12X = $column3X - 0.50; // Adjust the X-coordinate for column 1 label
$label12Y = $column3Y + 0.62; // Adjust the Y-coordinate for column 1 label
$pdf->SetXY($label12X, $label12Y);
$pdf->Cell(0.01, 0, '(Day)', 0, 0, 'R');

// Extract the day from the date of birth
$dayOfBirth = date('d', strtotime($mcert->mcert_b_date_of_birth));

// Set the position for the day value
$dayValueX = $label12X;
$dayValueY = $label12Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.01, 0, $dayOfBirth, 0, 0, 'R');

// Label for column 2
$label22X = $column3X - 0.10; // Adjust the X-coordinate for column 2 label
$label22Y = $column3Y + 0.62; // Adjust the Y-coordinate for column 2 label
$pdf->SetXY($label22X, $label22Y);
$pdf->Cell(0.50, 0, '(Month)', 0, 0, 'R');

// Extract the month from the date of birth
$monthOfBirth = date('F', strtotime($mcert->mcert_b_date_of_birth));

// Set the position for the month value
$monthValueX = $label22X + 0.60;
$monthValueY = $label22Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($monthValueX, $monthValueY);
$pdf->Cell(0.15, 0, $monthOfBirth, 0, 0, 'R');

// Label for column 3
$label32X = $column3X + 0.80; // Adjust the X-coordinate for column 3 label
$label32Y = $column3Y + 0.62; // Adjust the Y-coordinate for column 3 label
$pdf->SetXY($label32X, $label32Y);
$pdf->Cell(0.50, 0, '(Year)', 0, 0, 'R');

// Extract the year from the date of birth
$yearOfBirth = date('Y', strtotime($mcert->mcert_b_date_of_birth));

// Set the position for the year value
$yearValueX = $label32X + 0.60;
$yearValueY = $label32Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($yearValueX, $yearValueY);
$pdf->Cell(0.15, 0, $yearOfBirth, 0, 0, 'R');

// Label for column 4
$label42X = $column3X + 1.80; // Adjust the X-coordinate for column 4 label
$label42Y = $column3Y + 0.62; // Adjust the Y-coordinate for column 4 label
$pdf->SetXY($label42X, $label42Y);
$pdf->Cell(0.50, 0, '(Age)', 0, 0, 'R');

// Set the position for the age value
$ageValueX = $label42X;
$ageValueY = $label42Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($ageValueX, $ageValueY);
$pdf->Cell(0.50, 0, $mcert->mcert_b_age, 0, 0, 'R');

// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 0.70;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, '2. Date of Birth/Age', 0, 0, 'L');


// Calculate the width of the line based on the border width
$lineWidth = $borderWidth / 2;

// Calculate the coordinates for the horizontal line
$lineY = $applicationY + 3.90;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;

// Set the line thickness
$pdf->SetLineWidth($lineWidth);

// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

// Set the labels for each column
$pdf->SetFont('Helvetica', '', 8);

// Label for column 1
$label1X = $column1X + 0.005;
$label1Y = $column1Y + 0.99;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0, 0, '(City/Municipality)', 0, 0, 'L');

// Set the position for the city value
$dayValueX = $label1X + 0.15;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(1.15, 0, $mcert->mcert_g_place_of_birth_city, 0, 0, 'L');

// Label for column 1
$label1X = $column1X + 1.20;
$label1Y = $column1Y + 0.99;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0, 0, '(Province)', 0, 0, 'L');

// Set the position for the province value
$dayValueX = $label1X + 0.09;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(1.15, 0, $mcert->mcert_g_place_of_birth_province, 0, 0, 'L');

// Label for column 1
$label1X = $column1X + 2.40;
$label1Y = $column1Y + 0.99;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0, 0, '(Country)', 0, 0, 'L');

// Set the position for the province value
$dayValueX = $label1X + 0.09;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(1.15, 0, $mcert->mcert_g_place_of_birth_country, 0, 0, 'L');

// Label for column 3
$label1X = $column3X - 0.0010;
$label1Y = $column3Y + 0.99;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(City/Municipality)', 0, 0, 'R');

// Set the position for the city value
$dayValueX = $label1X - 0.0010;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_b_place_of_birth_city, 0, 0, 'R');

// Label for column 3
$label1X = $column3X + 0.90;
$label1Y = $column3Y + 0.99;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(Province)', 0, 0, 'R');

// Set the position for the city value
$dayValueX = $label1X + 0.20;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.15, 0, $mcert->mcert_b_place_of_birth_province, 0, 0, 'R');

// Label for column 3
$label1X = $column3X + 2.10;
$label1Y = $column3Y + 0.99;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(Country)', 0, 0, 'R');

// Set the position for the city value
$dayValueX = $label1X + 0.20;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.15, 0, $mcert->mcert_b_place_of_birth_country, 0, 0, 'R');

// Calculate the width of the line based on the border width
$lineWidth = $borderWidth / 2;

// Calculate the coordinates for the horizontal line
$lineY = $applicationY + 4.30;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;

// Set the line thickness
$pdf->SetLineWidth($lineWidth);

// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);


// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 1.10;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, '3. Place of Birth', 0, 0, 'L');

$lineX = $column1X + 1.10; // Adjust the X-coordinate based on the column width
$lineY1 = $column1Y + 1.65; // Adjust the starting Y-coordinate of the line
$lineY2 = $column1Y + 1.30; // Adjust the ending Y-coordinate of the line

// Define the thickness of the vertical line
$lineWidth = - 0.2; // Adjust the line width as needed, a positive value

// Draw the vertical line
$pdf->SetLineWidth($lineWidth);
$pdf->Line($lineX, $lineY1, $lineX, $lineY2);

$lineX = $column3X + 0.40; // Adjust the X-coordinate based on the column width
$lineY1 = $column3Y + 1.65; // Adjust the starting Y-coordinate of the line
$lineY2 = $column3Y + 1.30; // Adjust the ending Y-coordinate of the line

// Define the thickness of the vertical line
$lineWidth = - 0.2; // Adjust the line width as needed, a positive value

// Draw the vertical line
$pdf->SetLineWidth($lineWidth);
$pdf->Line($lineX, $lineY1, $lineX, $lineY2);

// Label for column 3
$label1X = $column1X + 0.10;
$label1Y = $column1Y + 1.40;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(Male/Female)', 0, 0, 'L');

// Set the position for the city value
$dayValueX = $label1X + 0.25;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_g_sex, 0, 0, 'L');

// Label for column 3
$label1X = $column1X + 1.70;
$label1Y = $column1Y + 1.40;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(Citizenship)', 0, 0, 'L');

// Set the position for the city value
$dayValueX = $label1X + 0.15;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_g_citizenship, 0, 0, 'L');

// Label for column 3
$label1X = $column3X - 0.0030;
$label1Y = $column3Y + 1.40;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(Male/Female)', 0, 0, 'R');

// Set the position for the city value
$dayValueX = $label1X - 0.10;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_b_sex, 0, 0, 'R');

// Label for column 3
$label1X = $column3X + 1.50;
$label1Y = $column3Y + 1.40;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(Citizenship)', 0, 0, 'R');

// Set the position for the city value
$dayValueX = $label1X + 0.01;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_g_citizenship, 0, 0, 'R');

// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 1.48;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, '4. Sex/Citizenship', 0, 0, 'L');

// Calculate the width of the line based on the border width
$lineWidth = $borderWidth / 2;

// Calculate the coordinates for the horizontal line
$lineY = $applicationY + 4.65;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;

// Set the line thickness
$pdf->SetLineWidth($lineWidth);

// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 1.85;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, '5. Residence', 0, 0, 'L');


// Set the labels for each column
$pdf->SetFont('Helvetica', '', 7);

// Label for column 1
$label1X = $column1X + 0.15;
$label1Y = $column1Y + 1.75;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(House No., St., Barangay, City/Municipality, Province, Country)', 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 8);
// Set the position for the city value
$dayValueX = $label1X + 0.15;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_g_residence, 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 7);
// Label for column 3
$label1X = $column3X + 2.10;
$label1Y = $column3Y + 1.75;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(House No., St., Barangay, City/Municipality, Province, Country)', 0, 0, 'R');

$pdf->SetFont('Helvetica', '', 8);
// Set the position for the city value
$dayValueX = $label1X + 0.01;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_b_residence, 0, 0, 'R');

// Calculate the width of the line based on the border width
$lineWidth = $borderWidth / 2;

// Calculate the coordinates for the horizontal line
$lineY = $applicationY + 5.05;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;

// Set the line thickness
$pdf->SetLineWidth($lineWidth);

// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);


$pdf->SetFont('Helvetica', '', 8);
$label1X = $column1X + 0.15;
$label1Y = $column1Y + 1.75;
$pdf->SetXY($label1X, $label1Y);

$dayValueX = $label1X + 0.90;
$dayValueY = $label1Y + 0.47; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_g_religion, 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 8);
$label1X = $column1X + 5.15;
$label1Y = $column1Y + 1.75;
$pdf->SetXY($label1X, $label1Y);

$dayValueX = $label1X + 1.33;
$dayValueY = $label1Y + 0.47; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_b_religion, 0, 0, 'R');

// Calculate the width of the line based on the border width
$lineWidth = $borderWidth / 2;

// Calculate the coordinates for the horizontal line
$lineY = $applicationY + 5.43;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;

// Set the line thickness
$pdf->SetLineWidth($lineWidth);

// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 2.20;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, '6. Religion/Religious Sect', 0, 0, 'L');

// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 2.65;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, '7. Civil Status', 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 8);
$label1X = $column1X + 0.40;
$label1Y = $column1Y + 2.10;
$pdf->SetXY($label1X, $label1Y);

$dayValueX = $label1X + 0.90;
$dayValueY = $label1Y + 0.47; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_g_civil_status, 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 8);
$label1X = $column1X + 5.15;
$label1Y = $column1Y + 2.10;
$pdf->SetXY($label1X, $label1Y);

$dayValueX = $label1X + 1.10;
$dayValueY = $label1Y + 0.47; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_b_civil_status, 0, 0, 'R');

// Calculate the coordinates for the horizontal line
$lineY = $applicationY + 5.85;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;

// Set the line thickness
$pdf->SetLineWidth($lineWidth);

// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

$pdf->SetFont('Helvetica', '', 7);
// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 3.01;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, '8. IF PREVIOUSLY ', 0, 0, 'L');
// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 3.11;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, 'MARRIED:     How', 0, 0, 'L');
// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 3.21;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, 'was  it   dissolved?', 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 8);
$label1X = $column1X + 0.40;
$label1Y = $column1Y + 2.10;
$pdf->SetXY($label1X, $label1Y);

$dayValueX = $label1X + 0.10;
$dayValueY = $label1Y + 1.00; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_g_marriage_dissolved, 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 8);
$label1X = $column1X + 5.15;
$label1Y = $column1Y + 2.10;
$pdf->SetXY($label1X, $label1Y);

$dayValueX = $label1X + 0.10;
$dayValueY = $label1Y + 1.00; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_b_marriage_dissolved, 0, 0, 'R');

// Calculate the coordinates for the horizontal line
$lineY = $applicationY + 6.38;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;

// Set the line thickness
$pdf->SetLineWidth($lineWidth);

// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

$pdf->SetFont('Helvetica', '', 8);
// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 3.50;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, '9. Place where', 0, 0, 'L');
// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 3.63;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, 'dissolved', 0, 0, 'L');

// Set the labels for each column
$pdf->SetFont('Helvetica', '', 8);

// Label for column 1
$label1X = $column1X + 0.005;
$label1Y = $column1Y + 3.48;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0, 0, '(City/Municipality)', 0, 0, 'L');

// Set the position for the city value
$dayValueX = $label1X + 0.15;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(1.15, 0, $mcert->mcert_g_marriage_dissolved_place_city, 0, 0, 'L');

// Label for column 1
$label1X = $column1X + 1.20;
$label1Y = $column1Y + 3.48;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0, 0, '(Province)', 0, 0, 'L');

// Set the position for the province value
$dayValueX = $label1X + 0.09;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(1.15, 0, $mcert->mcert_g_marriage_dissolved_place_province, 0, 0, 'L');

// Label for column 1
$label1X = $column1X + 2.40;
$label1Y = $column1Y + 3.48;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0, 0, '(Country)', 0, 0, 'L');

// Set the position for the province value
$dayValueX = $label1X + 0.09;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(1.15, 0, $mcert->mcert_g_marriage_dissolved_place_country, 0, 0, 'L');

// Label for column 3
$label1X = $column3X - 0.0010;
$label1Y = $column3Y + 3.48;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(City/Municipality)', 0, 0, 'R');

// Set the position for the city value
$dayValueX = $label1X - 0.0010;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_b_marriage_dissolved_place_city, 0, 0, 'R');

// Label for column 3
$label1X = $column3X + 0.90;
$label1Y = $column3Y + 3.48;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(Province)', 0, 0, 'R');

// Set the position for the city value
$dayValueX = $label1X + 0.20;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.15, 0, $mcert->mcert_b_marriage_dissolved_place_province, 0, 0, 'R');

// Label for column 3
$label1X = $column3X + 2.10;
$label1Y = $column3Y + 3.48;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(Country)', 0, 0, 'R');

// Set the position for the city value
$dayValueX = $label1X + 0.20;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.15, 0, $mcert->mcert_b_marriage_dissolved_place_country, 0, 0, 'R');

// Calculate the coordinates for the horizontal line
$lineY = $applicationY + 6.79;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;

// Set the line thickness
$pdf->SetLineWidth($lineWidth);

// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);


// ___________________________________________

$pdf->SetFont('Helvetica', '', 8);
// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 3.93;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, '10. Date when', 0, 0, 'L');
// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 4.08;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, 'dissolved', 0, 0, 'L');

// Set the labels for each column
$pdf->SetFont('Helvetica', '', 8);

// Label for column 1
$label1X = $column1X + 0.005;
$label1Y = $column1Y + 3.90;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0, 0, '(Day)', 0, 0, 'L');

$dayOfdissolve = date('d', strtotime($mcert->mcert_g_marriage_dissolved_date));
// Set the position for the city value
$dayValueX = $label1X + 0.15;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(1.15, 0, $dayOfdissolve, 0, 0, 'L');

// Label for column 1
$label1X = $column1X + 1.20;
$label1Y = $column1Y + 3.90;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0, 0, '(Month)', 0, 0, 'L');

$dayOfdissolve = date('F', strtotime($mcert->mcert_g_marriage_dissolved_date));
// Set the position for the province value
$dayValueX = $label1X + 0.09;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(1.15, 0, $dayOfdissolve, 0, 0, 'L');

// Label for column 1
$label1X = $column1X + 2.40;
$label1Y = $column1Y + 3.90;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0, 0, '(Year)', 0, 0, 'L');

$dayOfdissolve = date('Y', strtotime($mcert->mcert_g_marriage_dissolved_date));
// Set the position for the province value
$dayValueX = $label1X + 0.09;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(1.15, 0, $dayOfdissolve, 0, 0, 'L');

// Label for column 1
$label12X = $column3X - 0.46; // Adjust the X-coordinate for column 1 label
$label12Y = $column3Y + 3.90; // Adjust the Y-coordinate for column 1 label
$pdf->SetXY($label12X, $label12Y);
$pdf->Cell(0.01, 0, '(Day)', 0, 0, 'R');

// Extract the day from the date of birth
$dayOfdissolve = date('d', strtotime($mcert->mcert_b_marriage_dissolved_date));
// Set the position for the day value
$dayValueX = $label12X;
$dayValueY = $label12Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.01, 0, $dayOfdissolve, 0, 0, 'R');

// Label for column 3
$label1X = $column3X + 0.90;
$label1Y = $column3Y + 3.90;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(Month)', 0, 0, 'R');

$dayOfdissolve = date('F', strtotime($mcert->mcert_b_marriage_dissolved_date));
// Set the position for the city value
$dayValueX = $label1X + 0.20;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.15, 0, $dayOfdissolve, 0, 0, 'R');

// Label for column 3
$label1X = $column3X + 2.10;
$label1Y = $column3Y + 3.90;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(Year)', 0, 0, 'R');

$dayOfdissolve = date('Y', strtotime($mcert->mcert_b_marriage_dissolved_date));
// Set the position for the city value
$dayValueX = $label1X + 0.20;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.15, 0, $dayOfdissolve, 0, 0, 'R');

// Calculate the coordinates for the horizontal line
$lineY = $applicationY + 7.20;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;

// Set the line thickness
$pdf->SetLineWidth($lineWidth);

// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

$pdf->SetFont('Helvetica', '', 7);
// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 4.35;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, '11. Degree of ', 0, 0, 'L');
// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 4.45;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, 'relationship of ', 0, 0, 'L');
// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 4.55;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, 'contracting', 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 8);
$label1X = $column1X + 0.40;
$label1Y = $column1Y + 3.42 ;
$pdf->SetXY($label1X, $label1Y);

$dayValueX = $label1X + 0.10;
$dayValueY = $label1Y + 1.00; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_g_marriage_dissolved_relationship, 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 8);
$label1X = $column1X + 5.15;
$label1Y = $column1Y + 3.42;
$pdf->SetXY($label1X, $label1Y);

$dayValueX = $label1X + 0.10;
$dayValueY = $label1Y + 1.00; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_g_marriage_dissolved_relationship, 0, 0, 'R');

// Calculate the coordinates for the horizontal line
$lineY = $applicationY + 7.70;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;

// Set the line thickness
$pdf->SetLineWidth($lineWidth);

// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 4.85;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, '12. Name of', 0, 0, 'L');

// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 4.95;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, 'Father', 0, 0, 'L');


// Set the labels for each column
$pdf->SetFont('Helvetica', '', 8);

// Label for column 1
$label1X = $column1X + 0.005;
$label1Y = $column1Y + 4.80;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0, 0, '(First)', 0, 0, 'L');

// Set the position for the city value
$dayValueX = $label1X + 0.15;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(1.15, 0, $mcert->mcert_g_fathers_first_name, 0, 0, 'L');

// Label for column 1
$label1X = $column1X + 1.20;
$label1Y = $column1Y + 4.80;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0, 0, '(Middle)', 0, 0, 'L');

// Set the position for the province value
$dayValueX = $label1X + 0.09;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(1.15, 0, $mcert->mcert_g_fathers_middle_name, 0, 0, 'L');

// Label for column 1
$label1X = $column1X + 2.40;
$label1Y = $column1Y + 4.80;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0, 0, '(Last)', 0, 0, 'L');


// Set the position for the province value
$dayValueX = $label1X + 0.09;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(1.15, 0, $mcert->mcert_g_fathers_last_name, 0, 0, 'L');

// Label for column 1
$label12X = $column3X - 0.46; // Adjust the X-coordinate for column 1 label
$label12Y = $column3Y + 4.80; // Adjust the Y-coordinate for column 1 label
$pdf->SetXY($label12X, $label12Y);
$pdf->Cell(0.01, 0, '(First)', 0, 0, 'R');

// Extract the day from the date of birth

// Set the position for the day value
$dayValueX = $label12X;
$dayValueY = $label12Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.01, 0, $mcert->mcert_b_fathers_first_name, 0, 0, 'R');

// Label for column 3
$label1X = $column3X + 0.90;
$label1Y = $column3Y + 4.80;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(Middle)', 0, 0, 'R');


// Set the position for the city value
$dayValueX = $label1X + 0.20;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.15, 0, $mcert->mcert_b_fathers_middle_name, 0, 0, 'R');

// Label for column 3
$label1X = $column3X + 2.10;
$label1Y = $column3Y + 4.80;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(Last)', 0, 0, 'R');

// Set the position for the city value
$dayValueX = $label1X + 0.20;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.15, 0, $mcert->mcert_b_fathers_last_name, 0, 0, 'R');

// Calculate the coordinates for the horizontal line
$lineY = $applicationY + 8.08;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;
// Set the line thickness
$pdf->SetLineWidth($lineWidth);

// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 5.25;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, '13. Citizenship ', 0, 0, 'L');


$pdf->SetFont('Helvetica', '', 8);
$label1X = $column1X + 0.40;
$label1Y = $column1Y + 4.25;
$pdf->SetXY($label1X, $label1Y);

$dayValueX = $label1X + 0.10;
$dayValueY = $label1Y + 1.00; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_g_fathers_citizenship, 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 8);
$label1X = $column1X + 5.15;
$label1Y = $column1Y + 4.25;
$pdf->SetXY($label1X, $label1Y);

$dayValueX = $label1X + 0.10;
$dayValueY = $label1Y + 1.00; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_b_fathers_citizenship, 0, 0, 'R');

// Calculate the coordinates for the horizontal line
$lineY = $applicationY + 8.40;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;
// Set the line thickness
$pdf->SetLineWidth($lineWidth);

// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 5.58;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, '14. Residence', 0, 0, 'L');


// Set the labels for each column
$pdf->SetFont('Helvetica', '', 7);

// Label for column 1
$label1X = $column1X + 0.15;
$label1Y = $column1Y + 5.50;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(House No., St., Barangay, City/Municipality, Province, Country)', 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 8);
// Set the position for the city value
$dayValueX = $label1X + 0.15;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_g_fathers_residence, 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 7);
// Label for column 3
$label1X = $column3X + 2.10;
$label1Y = $column3Y + 5.50;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(House No., St., Barangay, City/Municipality, Province, Country)', 0, 0, 'R');

$pdf->SetFont('Helvetica', '', 8);
// Set the position for the city value
$dayValueX = $label1X + 0.01;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_b_fathers_residence, 0, 0, 'R');

// Calculate the coordinates for the horizontal line
$lineY = $applicationY + 8.80;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;
// Set the line thickness
$pdf->SetLineWidth($lineWidth);

// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 5.95;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, '15. Name of', 0, 0, 'L');

// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 6.09;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, 'Mother', 0, 0, 'L');


// Set the labels for each column
$pdf->SetFont('Helvetica', '', 8);

// Label for column 1
$label1X = $column1X + 0.005;
$label1Y = $column1Y + 5.90;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0, 0, '(First)', 0, 0, 'L');

// Set the position for the city value
$dayValueX = $label1X + 0.15;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(1.15, 0, $mcert->mcert_g_mothers_first_name, 0, 0, 'L');

// Label for column 1
$label1X = $column1X + 1.20;
$label1Y = $column1Y + 5.90;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0, 0, '(Middle)', 0, 0, 'L');

// Set the position for the province value
$dayValueX = $label1X + 0.09;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(1.15, 0, $mcert->mcert_g_mothers_middle_name, 0, 0, 'L');

// Label for column 1
$label1X = $column1X + 2.40;
$label1Y = $column1Y + 5.90;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0, 0, '(Last)', 0, 0, 'L');


// Set the position for the province value
$dayValueX = $label1X + 0.09;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(1.15, 0, $mcert->mcert_g_mothers_last_name, 0, 0, 'L');

// Label for column 1
$label12X = $column3X - 0.10; // Adjust the X-coordinate for column 1 label
$label12Y = $column3Y + 5.90; // Adjust the Y-coordinate for column 1 label
$pdf->SetXY($label12X, $label12Y);
$pdf->Cell(0.01, 0, '(First)', 0, 0, 'R');

// Extract the day from the date of birth

// Set the position for the day value
$dayValueX = $label12X;
$dayValueY = $label12Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.01, 0, $mcert->mcert_b_mothers_first_name, 0, 0, 'R');

// Label for column 3
$label1X = $column3X + 0.90;
$label1Y = $column3Y + 5.90;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(Middle)', 0, 0, 'R');


// Set the position for the city value
$dayValueX = $label1X + 0.20;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.15, 0, $mcert->mcert_b_mothers_middle_name, 0, 0, 'R');

// Label for column 3
$label1X = $column3X + 2.10;
$label1Y = $column3Y + 5.90;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(Last)', 0, 0, 'R');

// Set the position for the city value
$dayValueX = $label1X + 0.20;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.15, 0, $mcert->mcert_b_mothers_last_name, 0, 0, 'R');

// Calculate the coordinates for the horizontal line
$lineY = $applicationY + 9.20;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;
// Set the line thickness
$pdf->SetLineWidth($lineWidth);

// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 6.35;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, '16. Citizenship ', 0, 0, 'L');


$pdf->SetFont('Helvetica', '', 8);
$label1X = $column1X + 0.40;
$label1Y = $column1Y + 5.35;
$pdf->SetXY($label1X, $label1Y);

$dayValueX = $label1X + 0.10;
$dayValueY = $label1Y + 1.00; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_g_mothers_citizenship, 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 8);
$label1X = $column1X + 5.15;
$label1Y = $column1Y + 5.35;
$pdf->SetXY($label1X, $label1Y);

$dayValueX = $label1X + 0.10;
$dayValueY = $label1Y + 1.00; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_b_mothers_citizenship, 0, 0, 'R');

// Calculate the coordinates for the horizontal line
$lineY = $applicationY + 8.40;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;
// Set the line thickness
$pdf->SetLineWidth($lineWidth);

// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

//Calculate the coordinates for the horizontal line
$lineY = $applicationY + 9.50;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;
// Set the line thickness
$pdf->SetLineWidth($lineWidth);

// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 6.65;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, '17. Residence', 0, 0, 'L');


// Set the labels for each column
$pdf->SetFont('Helvetica', '', 7);

// Label for column 1
$label1X = $column1X + 0.15;
$label1Y = $column1Y + 6.60;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(House No., St., Barangay, City/Municipality, Province, Country)', 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 8);
// Set the position for the city value
$dayValueX = $label1X + 0.15;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_g_mothers_residence, 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 7);
// Label for column 3
$label1X = $column3X + 2.10;
$label1Y = $column3Y + 6.60;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(House No., St., Barangay, City/Municipality, Province, Country)', 0, 0, 'R');

$pdf->SetFont('Helvetica', '', 8);
// Set the position for the city value
$dayValueX = $label1X + 0.01;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_b_mothers_residence, 0, 0, 'R');

//Calculate the coordinates for the horizontal line
$lineY = $applicationY + 9.85;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;
// Set the line thickness
$pdf->SetLineWidth($lineWidth);

// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 6.95;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, '18. Persons who', 0, 0, 'L');
// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 7.10;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, 'gave consent', 0, 0, 'L');


$pdf->SetFont('Helvetica', '', 8);
$label1X = $column1X + 0.40;
$label1Y = $column1Y + 6.00;
$pdf->SetXY($label1X, $label1Y);

$dayValueX = $label1X + 0.10;
$dayValueY = $label1Y + 1.00; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_g_consent_given_by, 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 8);
$label1X = $column1X + 5.15;
$label1Y = $column1Y + 6.00;
$pdf->SetXY($label1X, $label1Y);

$dayValueX = $label1X + 0.10;
$dayValueY = $label1Y + 1.00; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_b_consent_given_by, 0, 0, 'R');

//Calculate the coordinates for the horizontal line
$lineY = $applicationY + 10.20;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;
// Set the line thickness
$pdf->SetLineWidth($lineWidth);

// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 7.35;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, '19. Relationship', 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 8);
$label1X = $column1X + 0.40;
$label1Y = $column1Y + 6.35;
$pdf->SetXY($label1X, $label1Y);

$dayValueX = $label1X + 0.10;
$dayValueY = $label1Y + 1.00; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_g_consent_given_relationship, 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 8);
$label1X = $column1X + 5.15;
$label1Y = $column1Y + 6.35;
$pdf->SetXY($label1X, $label1Y);

$dayValueX = $label1X + 0.10;
$dayValueY = $label1Y + 1.00; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_b_consent_given_relationship, 0, 0, 'R');

//Calculate the coordinates for the horizontal line
$lineY = $applicationY + 10.50;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;
// Set the line thickness
$pdf->SetLineWidth($lineWidth);

$pdf->Line($lineX1, $lineY, $lineX2, $lineY);
// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 7.65;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, '20. Citizenship', 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 8);
$label1X = $column1X + 0.40;
$label1Y = $column1Y + 6.65;
$pdf->SetXY($label1X, $label1Y);

$dayValueX = $label1X + 0.10;
$dayValueY = $label1Y + 1.00; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_g_consent_given_citizenship, 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 8);
$label1X = $column1X + 5.15;
$label1Y = $column1Y + 6.65;
$pdf->SetXY($label1X, $label1Y);

$dayValueX = $label1X + 0.10;
$dayValueY = $label1Y + 1.00; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_b_consent_given_citizenship, 0, 0, 'R');

//Calculate the coordinates for the horizontal line
$lineY = $applicationY + 10.80;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;
// Set the line thickness
$pdf->SetLineWidth($lineWidth);
// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

// Label for column 2
$label2X = $column2X + 0.75;
$label2Y = $column2Y + 7.99;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, '21. Residence', 0, 0, 'L');


// Set the labels for each column
$pdf->SetFont('Helvetica', '', 7);

// Label for column 1
$label1X = $column1X + 0.15;
$label1Y = $column1Y + 7.90;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(House No., St., Barangay, City/Municipality, Province, Country)', 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 8);
// Set the position for the city value
$dayValueX = $label1X + 0.15;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_g_consent_given_residence, 0, 0, 'L');

$pdf->SetFont('Helvetica', '', 7);
// Label for column 3
$label1X = $column3X + 2.10;
$label1Y = $column3Y + 7.90;
$pdf->SetXY($label1X, $label1Y);
$pdf->Cell(0.15, 0, '(House No., St., Barangay, City/Municipality, Province, Country)', 0, 0, 'R');

$pdf->SetFont('Helvetica', '', 8);
// Set the position for the city value
$dayValueX = $label1X + 0.01;
$dayValueY = $label1Y + 0.15; // Adjust the Y-coordinate as needed
$pdf->SetXY($dayValueX, $dayValueY);
$pdf->Cell(0.02, 0, $mcert->mcert_b_consent_given_residence, 0, 0, 'R');

// Calculate the coordinates for the horizontal line
$lineY = $applicationY + 11.17;
$lineX1 = $x1 + $lineWidth;
$lineX2 = $x2 - $lineWidth;
// Set the line thickness
$pdf->SetLineWidth($lineWidth);
// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);


// Calculate the coordinates for the horizontal line
$lineY = $applicationY + 11.40;
$lineX1 = $x1 + 3.37;
$lineX2 = $x2 - 3.52;
// Set the line thickness
$pdf->SetLineWidth($lineWidth);
// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

$lineY = $applicationY + 12.30;
$lineX1 = $x1 + 3.37;
$lineX2 = $x2 - 3.52;
// Set the line thickness
$pdf->SetLineWidth($lineWidth);
// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

// Calculate the coordinates for the vertical line
$lineX = $x1 + 4.29;
$lineY1 = $applicationY + 12.30;
$lineY2 = $y2 - 1.21;
// Set the line thickness
$pdf->SetLineWidth($lineWidth);
// Draw the vertical line
$pdf->Line($lineX, $lineY1, $lineX, $lineY2);

// Calculate the coordinates for the vertical line
$lineX = $x1 + 3.37;
$lineY1 = $applicationY + 12.30;
$lineY2 = $y2 - 1.21;
// Set the line thickness
$pdf->SetLineWidth($lineWidth);
// Draw the vertical line
$pdf->Line($lineX, $lineY1, $lineX, $lineY2);

// Set the labels for each column
$pdf->SetFont('Helvetica', '', 8);
// Label for column 2
$label2X = $column2X + 0.87;
$label2Y = $column2Y + 8.65;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, 'Excempt from', 0, 0, 'L');
// Label for column 2
$label2X = $column2X + 0.89;
$label2Y = $column2Y + 8.85;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, 'documentary', 0, 0, 'L');
// Label for column 2
$label2X = $column2X + 0.95;
$label2Y = $column2Y + 9.04;
$pdf->SetXY($label2X, $label2Y);
$pdf->Cell(0.50, 0, 'stamp tax', 0, 0, 'L');

// Calculate the coordinates for the vertical line
$lineX = $x1 + 3.80;
$lineY1 = $applicationY + 12.60;
$lineY2 = $y2 - 0.31;
// Set the line thickness
$pdf->SetLineWidth($lineWidth);
// Draw the vertical line
$pdf->Line($lineX, $lineY1, $lineX, $lineY2);

// Calculate the coordinates for the vertical line
$lineX = $x1 + 3.80;
$lineY1 = $applicationY + 11.40;
$lineY2 = $y2 - 1.43;
// Set the line thickness
$pdf->SetLineWidth($lineWidth);
// Draw the vertical line
$pdf->Line($lineX, $lineY1, $lineX, $lineY2);

// Calculate the coordinates for the horizontal line
$lineY = $applicationY + 11.35;
$lineX1 = $x1 + 0.60;
$lineX2 = $x2 - 5.10;
// Set the line thickness
$pdf->SetLineWidth($lineWidth);
// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

// Set the font and position for the label
$pdf->SetFont('Helvetica', '', 8);
$labelX = ($lineX1 + $lineX2) - 2.60;
$labelY = $lineY + 0.13;
// Add the label
$pdf->Text($labelX, $labelY, '(Signature of Applicant)');

// Calculate the coordinates for the horizontal line
$lineY = $applicationY + 12.40;
$lineX1 = $x1 + 0.60;
$lineX2 = $x2 - 5.10;
// Set the line thickness
$pdf->SetLineWidth($lineWidth);
// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

// Set the font and position for the label
$pdf->SetFont('Helvetica', '', 8);
$labelX = ($lineX1 + $lineX2) - 3.30;
$labelY = $lineY + 0.12;
// Add the label
$pdf->Text($labelX, $labelY, '(Signature Over Printed Name of the Civil Registrar)');

// Calculate the coordinates for the horizontal line
$lineY = $applicationY + 11.35;
$lineX1 = $x1 + 7.10;
$lineX2 = $x2 - 2.80;
// Set the line thickness
$pdf->SetLineWidth($lineWidth);
// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

// Set the font and position for the label
$pdf->SetFont('Helvetica', '', 8);
$labelX = ($lineX1 + $lineX2) - 6.99;
$labelY = $lineY + 0.13;
// Add the label
$pdf->Text($labelX, $labelY, '(Signature of Applicant)');

// Calculate the coordinates for the horizontal line
$lineY = $applicationY + 12.40;
$lineX1 = $x1 + 7.10;
$lineX2 = $x2 - 2.80;
// Set the line thickness
$pdf->SetLineWidth($lineWidth);
// Draw the horizontal line
$pdf->Line($lineX1, $lineY, $lineX2, $lineY);

// Set the font and position for the label
$pdf->SetFont('Helvetica', '', 8);
$labelX = ($lineX1 + $lineX2) - 7.75;
$labelY = $lineY + 0.13;
// Add the label
$pdf->Text($labelX, $labelY, '(Signature Over Printed Name of the Civil Registrar)');

$pdf->SetFont('Times', 'I', 8);
$pdf->SetDrawColor(255, 255, 255); // Set draw color to white for transparent border

// Calculate the width and height for the paragraph cell
$paragraphWidth = ($x2 - $x1) / 2.50 - 0.20;
$paragraphHeight = 0.11;

// Calculate the coordinates for the paragraph cell
$paragraphX = $x1 + 0.3;
$paragraphY = $sirMadamY + 9.89;
$pdf->SetXY($paragraphX, $paragraphY);
$pdf->MultiCell($paragraphWidth, $paragraphHeight, "     SUBSCRIBED AND SWORN to before me this_______day of__________________,______________,at___________________________,Philippines affiant who exchibited to me his Community Tax Cert.________________issued on__________________________,_______,at______________________________________", 0, 'J', false);

// Calculate the coordinates for the second paragraph cell
$secondParagraphX = $paragraphX + $paragraphWidth + 1.20;
$secondParagraphY = $paragraphY;
$pdf->SetXY($secondParagraphX, $secondParagraphY);
$pdf->MultiCell($paragraphWidth, $paragraphHeight, "     SUBSCRIBED AND SWORN to before me this_______day of__________________,______________,at___________________________,Philippines affiant who exchibited to me his Community Tax Cert.________________issued on__________________________,_______,at______________________________________", 0, 'J', false);



// Convert the HTML content to PDF using FPDF's MultiCell method
        $pdf->SetFont('Arial', '', 12);
        

        // Save the PDF to a file
        $filename = 'MARRIAGE APPLICATION ' . $mcert->mcert_registry_no 
        . ' ' . $mcert->mcert_g_first_name 
        . ' ' . $mcert->mcert_g_last_name 
        . ' ' . $mcert->mcert_b_first_name 
        . ' ' . $mcert->mcert_b_last_name . '.pdf';
        $pdf->Output(storage_path('app/public/marriage/' . $filename), 'F');

        // Force the download of the PDF
        return response()->file(storage_path('app/public/marriage/' . $filename));
        
    }




    

    // Generate Report in Marriage Application Pending
    public function generateReport(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

        $filteredMcerts = Mcert::whereBetween('created_at', [$startDate, $endDate])->get();

        // You can pass the filtered mcerts to your view or perform further processing

        return view('mcerts.index', ['mcerts' => $filteredMcerts]);
    }

    // Generate Report in Marriage Application Approved
    public function generateReportApproved(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

        $filteredMcerts = McertAppFile::whereBetween('created_at', [$startDate, $endDate])->get();

        // You can pass the filtered mcerts to your view or perform further processing

        return view('mcerts.mcert_app_file.index_app_file', ['mcertAppFiles' => $filteredMcerts]);
    }

    public function generateReportLegacy(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

        $filteredMcerts = McertFile::whereBetween('created_at', [$startDate, $endDate])->get();

        // You can pass the filtered mcerts to your view or perform further processing

        return view('mcerts.mcert_old_file.index_file', ['mcertFiles' => $filteredMcerts]);
    }

    public function generateReportRecent(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

        $filteredMcerts = McertNewFile::whereBetween('created_at', [$startDate, $endDate])->get();

        // You can pass the filtered mcerts to your view or perform further processing

        return view('mcerts.mcert_new_file.index_new_file', ['mcertNewFiles' => $filteredMcerts]);
    }


    public function searchall(Request $request){
        
        $searchQuery = $request->input('query');

        // AWS SDK configuration
        $s3 = new S3Client([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $bucketName = 'lcro-pdf-result-bucket';
        $folderPath = '';
        $results = [];
        try {
            // Get the list of objects in the S3 bucket
            $objects = $s3->listObjectsV2([
                'Bucket' => $bucketName,
                'Prefix' => $folderPath,
            ]);

            // Iterate through each object and search for the query
            foreach ($objects['Contents'] as $object) {
                $objectKey = $object['Key'];

                // Get the contents of the JSON file from S3
                $jsonContent = $s3->getObject([
                    'Bucket' => $bucketName,
                    'Key' => $objectKey,
                ]);

                // Decode the JSON content
                $data = json_decode($jsonContent['Body'], true);

                // Perform search on the extracted data
                // Customize this part based on your extracted JSON structure and search criteria
                if (isset($data['Blocks'])) {
                    foreach ($data['Blocks'] as $block) {
                        if ($block['BlockType'] === 'LINE' && isset($block['Text']) && strpos(strtoupper($block['Text']), strtoupper($searchQuery)) !== false) {
                            $result = [
                                'objectKey' => $objectKey,
                                'objectName' => $object['Key'],
                                'text' => $block['Text'],
                            ];
                            $results[] = $result;
                            break;
                        }
                    }

                }
                // dd($results);

            }
         return view('home', ['results' => $results]);

        } catch (AwsException $e) {
            return back()->with('error', 'An error occurred during the search. Please try again.');
        }

    }
}

class CustomTCPDF extends TCPDF
{
    protected $templatePath;

    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;
    }

    public function Header()
    {
       // Get the PDF template file
        $templateContent = file_get_contents($this->templatePath);

        // Set the template content as the header
        $this->SetHeaderData('', 0, '', '', array(0, 0, 0), array(255, 255, 255));

        // Set the template content
        $this->setHeaderTemplate($templateContent);
    }
}
