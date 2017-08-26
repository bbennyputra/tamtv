<div class="row">
	<?php echo form_open(current_url()); ?>
	<div class="col-md-4">
		<?php echo $this->session->flashdata('alert'); ?>
		<legend>Tambah Kategori Baru</legend>
		<div class="form-group">
			<label for="">Nama</label>
			<input type="text" name="nama" class="form-control" value="<?php echo set_value('nama'); ?>">
			<p class="help-block"><?php echo form_error('nama', '<small class="text-red">', '</small>'); ?></p>
			<p class="help-block"><small><i>Nama ini mencerminkan bagaimana tampil di situs Anda.</i></small></p>
		</div>
		<div class="form-group">
			<label for="">Slug</label>
			<input type="text" name="slug" class="form-control" value="<?php echo set_value('slug'); ?>">
			<p class="help-block"><?php echo form_error('slug', '<small class="text-red">', '</small>'); ?></p>
			<p class="help-block"><small><i>"Slug" ialah versi ramah-URL dari nama. Biasanya seluruhnya merupakan huruf kecil dan hanya mengandung huruf, angka, dan tanda strip.</i></small></p>
		</div>
		<div class="form-group">
			<label for="">Kategori Induk</label>
			<select name="parent" id="input" class="form-control">
				<option value="0"> -- Tidak ada --</option>
			<?php foreach( $this->category->get_parent() as $row)    
			{
				$selected = (set_value('parent')== $row->category_id) ? 'selected' : '';
				echo '<option value="'.$row->category_id.'" '.$selected.'>'.$row->name.'</option>';
			}
			?>
			</select>
			<p class="help-block"><?php echo form_error('parent', '<small class="text-red">', '</small>'); ?></p>
			<p class="help-block"><small><i>Anda boleh saja mempuanya kategori Berita dan di bawahnya ada kategori Politik dan Kriminal.</i></small></p>
		</div>
		<div class="form-group">
			<label for="">Deskripsi</label>
			<textarea name="deskripsi" rows="5" class="form-control"><?php echo set_value('deskripsi'); ?></textarea>
			<p class="help-block"><?php echo form_error('deskripsi', '<small class="text-red">', '</small>'); ?></p>
			<p class="help-block"><small><i>Deskripsi ini akan tampil pada tema akan beserta nama.</i></small></p>
		</div>
		<button type="submit" class="btn btn-primary">Tambah Kategori Baru</button>
	</div>
	<?php echo form_close(); ?>
	<div class="col-md-8">
		<?php echo form_open(current_url(), array('method' => 'get')); ?>
		<div class="col-md-6 bottom2x pull-right">
            <div class="input-group input-group-sm">
            	<input type="text" name="query" class="form-control" value="<?php echo $this->input->get('query') ?>" placeholder="Pencarian ...">
            	<div class="input-group-btn">
                  	<button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Cari Kategori</button>
            	</div>
            </div>
		</div>
		<?php echo form_close(); ?>
		<div class="clearfix"></div>
		<div class="box box-default">
		<?php echo form_open(base_url("administrator/post_category/bulkaction")); ?>
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="30">
			                <div class="checkbox checkbox-inline">
			                    <input id="checkbox1" type="checkbox"> <label for="checkbox1"></label>
			                </div>
						</th>
						<th class="text-center" width="200">Nama</th>
						<th class="text-center">Deskripsi</th>
						<th class="text-center" width="200">Slug</th>
						<th class="text-center">Berita</th>
					</tr>
				</thead>
				<tbody>
				<?php  
				/**
				 * Loop Data Users
				 *
				 **/
				foreach( $category as $row) :
				?>
					<tr>
						<td>
			                 <div class="checkbox checkbox-inline">
			                     <input id="checkbox1" type="checkbox" name="categories[]" value="<?php echo $row->category_id ?>"> <label for="checkbox1"></label>
			                 </div>
						</td>
						<td class="td-action">
							<?php echo anchor(base_url("administrator/post_category/update/{$row->category_id}"), $row->name); ?>
							<div class="button-action">
								<a href="<?php echo base_url("administrator/post_category/update/{$row->category_id}") ?>">Edit</a>  |
								<a href="#"  data-action="delete" data-key="category" data-id="<?php echo $row->category_id ?>" class="red">Hapus</a> |
								<a href="<?php echo base_url("kategori/".$row->slug) ?>">Tampil</a>  
							</div>
						</td>
						<td><small><?php echo $row->description ?></small></td>
						<td><?php echo $row->slug ?></td>
						<td class="text-center">
							<?php echo anchor(base_url("administrator/post?category={$row->category_id}"), $this->category->count_postcategory($row->category_id)); ?>	
						</td>
					</tr>
				<?php endforeach; 
				if( $category == FALSE ) echo '<tr><td colspan="5">Tidak ada pengguna yang ditemukan.</td></tr>';
				?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5">
							<label>Yang terpilih :</label>
							<a class="btn btn-xs btn-round btn-danger" data-toggle="modal" data-target="#modal-delete-category-selected"><i class="fa fa-trash-o"></i> Hapus</a>
							<small class="pull-right"><?php echo count($category) ?> dari <?php echo $this->category->getallpg(null, null, 'num') ?> data.</small>
						</td>
					</tr>
				</tfoot>
			</table>
			<div class="modal" id="modal-delete-category-selected">
				<div class="modal-dialog modal-sm modal-danger">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title"><i class="fa fa-info-circle"></i> Hapus!</h4>
							<span>Hapus data kategori yang terpilih dari database?</span>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Batal</button>
							<button type="submit" name="action" value="delete" class="btn btn-outline">Hapus</button>
						</div>
					</div>
				</div>
			</div>
		<?php echo form_close(); ?>
		</div>
		<div class="col-md-12 text-center">
			<?php echo $this->pagination->create_links(); ?>
		</div>
	</div>
</div>

<div class="modal" id="modal-delete-category">
	<div class="modal-dialog modal-sm modal-danger">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-info-circle"></i> Hapus!</h4>
				<span>Hapus data kategori ini dari database?</span>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Batal</button>
				<a href="#" id="btn-delete" class="btn btn-outline">Hapus</a>
			</div>
		</div>
	</div>
</div>