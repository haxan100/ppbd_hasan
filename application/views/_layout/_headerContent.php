<script>
	function notifikasi(sel, msg, err) {
		var alert_type = 'alert-success ';
		if (err) alert_type = 'alert-danger ';
		var html = '<div class="alert ' + alert_type + ' alert-dismissible show p-4">' + msg + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
		$(sel).html(html);
		$('html, body').animate({
			scrollTop: $(sel).offset().top - 75
		}, 500);
	}
</script>

<section class="content-header">
	<h1>
		Halaman <?php echo @$judul; ?>
		<small><?php echo @$deskripsi; ?></small>
	</h1>
	<ol class="breadcrumb">
		<?php
		for ($i = 0; $i < count($this->session->flashdata('segment')); $i++) {
			if ($i == 0) {
		?>
				<li><i class="fa fa-dashboard"></i> <?php echo $this->session->flashdata('segment')[$i]; ?></li>
			<?php
			} elseif ($i == (count($this->session->flashdata('segment')) - 1)) {
			?>
				<li class="active"> <?php echo $this->session->flashdata('segment')[$i]; ?> </li>
			<?php
			} else {
			?>
				<li> <?php echo $this->session->flashdata('segment')[$i]; ?> </li>
			<?php
			}

			if ($i == 0 && $i == (count($this->session->flashdata('segment')) - 1)) {
			?>
				<li class="active"> Here </li>
		<?php
			}
		}
		?>
	</ol>
</section>