<div class="container">
	<h1>Edit Berita</h1>
	<br>
	<br>
	<br>
	<form action="<?php echo base_url().'edit/execute' ?>" method="post">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<div class="form-group">
			<h2><label>Judul berita</label></h2>
			<br>
			<input type="text" name="judul" placeholder="Judul Berita" class="form-control" style="font-size: 1.5em;" value="<?php echo $judul ?>">
		</div>
		
		<br>

		<div class="form-group">
			<textarea name="berita_lengkap" rows="30" cols="100" placeholder="Berita" class="form-control" style="font-size: 1.5em;">
				<?php echo $berita_lengkap ?>
			</textarea>
		</div>
		<button class="btn btn-primary" type="Submit"> Submit</button>
	</form>
</div>