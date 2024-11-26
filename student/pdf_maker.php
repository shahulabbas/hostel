<?php
session_start();
require 'connection.php'; 
include_once('TCPDF-main/tcpdf.php');

$MST_ID = $_GET['MST_ID'];

// Query to get the data
$inv_mst_query = "SELECT * FROM students WHERE PIN='" . mysqli_real_escape_string($con, $MST_ID) . "'";             
$inv_mst_results = mysqli_query($con, $inv_mst_query);   
$count = mysqli_num_rows($inv_mst_results);  

if ($count > 0) {
    $inv_mst_data_row = mysqli_fetch_array($inv_mst_results, MYSQLI_ASSOC);

    // Generate the PDF using TCPDF
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 12);  
    $pdf->AddPage(); // Default A4

    $content = ''; 
    $content .= '
    <style type="text/css">
    body {
        font-size: 12px;
        line-height: 24px;
        font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
        color: #000;
    }
    .table-background {
        background-image: url("uploads/college-logo.png"); /* Update with the correct path */
        background-size: cover; /* Ensure the image covers the whole cell */
        background-repeat: no-repeat; /* Prevent repeating of the image */
    }
    </style>    
    <h1 align="center">Mess Bill</h1>
    <table cellpadding="5" cellspacing="1px" class="table-background" style="border: 1px solid #ddc; width: 100%; padding: 20px;">
        <tr>
            <td colspan="2" align="center"><b>Dr Y C James Yen Govt Polytechnic Kuppam</b></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><b>CONTACT: +91 97979 97979</b></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><b>WEBSITE: WWW.GPTK.COM</b></td>
        </tr>
        <tr>
            <td colspan="2" align="right"><b>Date:</b> ' . date("d-m-Y") . '</td>
        </tr>
        <tr>
            <td colspan="2" align="right"><b>Day:</b> ' . date("l") . '</td>
        </tr>
        <tr>
            <td colspan="2" align="center"><u><b>Student Details</b></u></td>
        </tr>
        <tr>
            <td><b>Name:</b> ' . htmlspecialchars($inv_mst_data_row['NAME']) . '</td>
        </tr>
        <tr>
            <td><b>PIN:</b> ' . htmlspecialchars($inv_mst_data_row['PIN']) . '</td>
        </tr>
        <tr>
            <td><b>Year:</b> ' . htmlspecialchars($inv_mst_data_row['YEAR']) . '</td>
        </tr>
        <tr>
            <td><b>Branch:</b> ' . htmlspecialchars($inv_mst_data_row['BRANCH']) . '</td>
        </tr>
        <tr>
            <td colspan="2" align="right"><b>Amount to be paid:<br></b> ' . htmlspecialchars($inv_mst_data_row['AMOUNT']) . '</td>
        </tr>
    </table>
    <br />
    <table cellpadding="5" cellspacing="10px" style="border: 1px solid #ddd; width: 100%;">
        <tr class="heading" style="background: #eee; border-bottom: 1px solid #ddd; font-weight: bold;">
            <td colspan="2" align="left">Admin sign<br>Mohan</td>
            <td colspan="2" align="right"><b>Student sign:<br></b> ' . htmlspecialchars($inv_mst_data_row['NAME']) . '</td>
        </tr>
    </table>
    <br />
    <table cellpadding="5" cellspacing="10px" style="width: 100%;">
        <tr>
            <td align="center"><b>THANK YOU!</b></td>
        </tr>
    </table>';
    
    $pdf->writeHTML($content);  

date_default_timezone_set('Asia/Kolkata');

// Save PDF
$file_location = $_SERVER['DOCUMENT_ROOT'] . '/GPTKUPPAM/student/uploads/';
$datetime = date('d-m-Y_H-i-s'); 
$file_name = $inv_mst_data_row['PIN'] . "-" . $datetime . ".pdf";
    
    if (isset($_GET['ACTION']) && $_GET['ACTION'] == 'UPLOAD') {
        $pdf->Output($file_location . $file_name, 'F'); // Save file to server
        
        // Update the amount to 0
        $update_query = "UPDATE students SET AMOUNT = 0 WHERE PIN = ?";
        if ($update_stmt = $con->prepare($update_query)) {
            $update_stmt->bind_param("s", $MST_ID); // Assuming MST_ID is your Pin number
            $update_stmt->execute();
            $update_stmt->close();
        }

        header('Location: details.php'); // Redirect back to details.php after upload
    }
} else {
    echo "No records found for the specified PIN.";
}
?>
