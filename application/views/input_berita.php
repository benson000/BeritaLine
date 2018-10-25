<div class="container">
	<h1>Tulis Berita</h1>
	<br>
	<br>
	<br>
	<form action="<?php echo base_url().'input/execute' ?>" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<h2><label>Judul berita</label></h2>
			<br>
			<input type="text" name="judul" placeholder="Judul Berita" class="form-control" style="font-size: 1.5em;">
		</div>
		
		<br>
	
		<div>
			<?php echo form_open_multipart('input/execute');?>
			<input type="file" name="upload" />

			<input type="submit" value="upload" />
		</div>

		<br>

		<div class="form-group">
			<textarea name="berita_lengkap" rows="30" cols="100" placeholder="Berita" class="form-control" style="font-size: 1.5em;"></textarea>
		</div>
		
		<?php echo $status."<br/>"; ?>

		<button class="btn btn-primary" type="Submit"> Submit</button>
	</form>
</div>