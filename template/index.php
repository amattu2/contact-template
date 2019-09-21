<?php
// Variables (Contract Config)
$employee = "My Name";
$employer = "Other Name";
$start_date = "June 25th, 2020";
$end_date = "June 26th, 2020";
$duties = "Duty 1, Duty 2, Duty 3, Duty 4";
$pay = "15";
$advance_pay = "2";
$private = (!empty($_GET) && isset($_GET['private']) && $_GET['private'] == "true" ? true : false) ?: false;
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Contract</title>
		<link rel='shortcut icon' type='image/icon' href='https://via.placeholder.com/16x16' />
		<link rel='stylesheet' type='text/css' href='style.css'>
		<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
		<meta name='robots' content='noindex, nofollow'>
		<?php if (!file_exists("signature.jpeg")): ?>
		<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jSignature/2.1.3/jSignature.min.js"></script>
		<?php endif; ?>
	</head>
	<body>
		<?php if ($private === true): ?>
		<div class='hover'>
			<div class='overlay'>Private Document</div>
		</div>
		<?php endif; ?>

		<div class='header'>
			<h1>&laquo; Work Contract &raquo;</h1>
			<p><?php echo "$start_date - $end_date" ?></p>
			<p><?php echo "$employee & $employer"; ?></p>
		</div>

		<div class='sep'></div>

		<div class='info'>
			<h2>Introduction</h2>
			<p><strong>T</strong>he following text herein certifies the contract between the developer <?php echo "<b>$employee</b>"; ?> and the temporary employer <?php echo "<b>$employer</b>"; ?>. It is understood that by electronically signing below, the contractual agreement between the two listed parties becomes bound and unbreakable unless mutually agreed upon by both parties due to unforseen reasons listed in latter text.</p>

			<h2>Contract</h2>
			<p>The following certifies the duties of the developer agreed upon by both the developer and the employer, all to be completed within a reasonable and timely fashion:</p>
			<ul>
				<?php
					$duties = explode(",", $duties);
					foreach ($duties as $duty) {
						echo "<li>". trim($duty) ."</li>";
					}
				?>
			</ul>

			<p>Both parties have mutually agreed for the developer to work at a rate of <b>$<?php echo $pay; ?>h/r</b>, which will be rounded up to the nearest hour. The payment must be made via <b>PAYMENT_METHOD</b> to <b>PAYMENT_ADDR</b> prior to the start of the job, with an advance payment of <?php echo $advance_pay; ?> hour(s) which totals $<?php echo $pay * $advance_pay; ?>, and secures <?php echo $advance_pay; ?> hour(s) of labor.</p>

			<p>As declared in the earlier portion of the contract, the contract is bound until completion of the duties by both parties. However, the following reasons are suitable causes to terminate the contract as-is, with or without refund:</p>
			<ul>
				<li>Unable to complete duties due to lack of time [0%-100% Refund]</li>
				<li>Duties not completable within an acceptable period of time</li>
				<li>Full amount due to the developer was not fulfilled [0% Refund]</li>
			</ul>
			<br />

			<p>By signing the following line, you declare: Full understanding of the preceeding contractual agreement, That you're certified to sign onbehalf of <?php echo $employer; ?>, and you agree and consent to paying at the rate described previously.

			<!-- Not Signed Yet -->
			<?php if (!file_exists("signature.jpeg")): ?>
				<div id="signature"></div>
				<p style='text-align:center'><?php echo $employer; ?></p>
				<script>
				$(document).ready(function() {
					$("#signature").jSignature();
				})

				function sign() {
					let  signature = $("#signature").jSignature("getData","image");
					$.ajax({
						url: 'signature.php',
						type: 'POST',
						data: { img:"data:image/png;base64," + signature[1] },
						success: function(data) { if (data) { location.reload(); } }
					});
				}
				</script>

				<div style='text-align:center; width: 100%;'>
					<div class='submit' onclick="sign(); window.print();">Submit Contract</div>
				</div>

			<!-- Signed Already -->
			<?php else: ?>
				<h3 style='text-align: center; margin-bottom: 0; margin-top: 35px;'>You already signed this contract.</h3>
				<p style='text-align: center'>Please Print the full page for your records</p>
				<img title='Employer Signature' src='signature.jpeg' />
				<img title='Developer Signature' src='nf_signature.jpeg' />
			<?php endif; ?>
		</div>
	</body>
</html>
