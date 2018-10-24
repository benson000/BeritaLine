<?php foreach($data->result() as $berita){ ?>
	<a href="<?php echo base_url().'view/view_berita/'.$berita->id; ?>">
		<h2><?php echo $berita->judul; ?></h2>
	</a>
	<p><?php echo $berita->berita_singkat; ?></p>

	<a href="<?php echo base_url().'edit/delete/'.$berita->id ?>">Hapus Berita</a>
	<a href="<?php echo base_url().'edit/index/'.$berita->id ?>">Edit Berita</a>

	<br/>
	<br/>
<?php } ?>