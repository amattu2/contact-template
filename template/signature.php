<?php
// Variables
$image = $_POST['img'];
$output = "signature.jpeg";

// Convert To Image
base64_to_jpeg($image, $output);

// Function
function base64_to_jpeg($base64_string, $output_file) {
	$ifp = fopen($output_file, 'wb');
	$data = explode(',', $base64_string);

	// Write, Close
	fwrite( $ifp, base64_decode( $data[ 1 ] ) );
	fclose( $ifp );

	echo "1";
	return $output_file;
}
?>
