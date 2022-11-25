<body>
<div class="notif_stok" data-flashdata="<?= $this->session->flashdata('notif_stok');?>"></div>
<div class="flashdata_transaksi" data-flashdata="<?= $this->session->flashdata('transaksi');?>"></div>
<div class="container"><br/>
	<h2>Shopping Cart Dengan Ajax dan Codeigniter</h2>
	<hr/>
	<div class="row">
		<div class="col-md-8">
			<h4>Produk</h4>

			<div class="row">
                <?php foreach($produk as $p){ ?>
                    <div class="col-md-4">
                        <div class="card border-dark">
                            <img class="card-img-top" src="<?php echo base_url().'upload/images/'.$p->gambar;?>">
                            <div class="card-body">
                                <h5 class="card-title font-weight-bold"><?php echo $p->nama_produk ?></h5>
                                <div class="row">
                                    <div class="col-md-7">
                                        <label class="card-text nomer">Stok <?php echo $p->stok ?></label><br>
                                    </div>
                                    <div class="col-md-7">
                                        <label class="card-text harga">Rp. <?php echo number_format($p->harga, 2, ",", ".");?></label><br>
                                    </div>
                                    <div class="col-md-5">
									    <input type="number" name="quantity_produk" id="<?php echo $p->id_produk;?>" value="1" min="1" max="<?=
										$p->stok ;?>" class="quantity_input form-control">
								    </div>
                                </div>
                                <br>
                                <button class="add_cart btn btn-success btn-block" data-stok="<?= $p->stok; ?>" data-idproduk="<?php echo $p->id_produk;?>" data-namaproduk="<?php echo $p->nama_produk;?>" data-harga="<?php echo $p->harga;?>">Add To Cart</button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
		    </div>
		</div>

		<div class="col-md-4">
			<h4>Shopping Cart</h4>
			<?php echo form_open_multipart(base_url().'produk/checkout'); ?>
				<div class="form-group">
					<label for="customer">Nama Customer</label>
					<input name="nama_cust" type="text" class="form-control" id="nama_cust">
				</div>  
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Produk</th>
							<th>Harga</th>
							<th>Qty</th>
							<th>Subtotal</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody id="detail_cart">
						
					</tbody>
					</table>
					<input class="btn btn-primary btn-outline-light" type="submit" value="Beli">
			<?php echo form_close() ?>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url().'asset/js/jquery.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'asset/js/bootstrap.js'?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.add_cart').click(function(){
			var id_produk    = $(this).data("idproduk");
			var nama_produk  = $(this).data("namaproduk");
			var harga 		 = $(this).data("harga");
			var quantity     = parseInt($('#' + id_produk).val());
			var stok_db      = parseInt($(this).data("stok"));
			var stok_cart 	 = parseInt($('.quantity.'+id_produk).val());

			var stok_cart_total = parseInt(stok_cart + quantity);

			function ajax_addCart()
			{
				$.ajax({
						url : "<?= base_url().'produk/add_cart' ?>",
						method : "POST",
						data : {id_produk: id_produk, nama_produk: nama_produk, harga: harga, quantity: quantity},
						success: function(data){
							$('#detail_cart').html(data);
						}
					});
			}

			function swal_warning()
			{
				Swal.fire({
						icon: 'warning',
						title: 'Maaf',
						text: "Stok tidak mencukupi",
					});
			}
			
			if(isNaN(stok_cart_total)){
				if(quantity <= stok_db)
				{
					ajax_addCart();
				} 
				else if (quantity > stok_db)
				{
					$('#' + id_produk).val(stok_db);
					swal_warning();
				}
			} 	
			else if (stok_cart_total <= stok_db)
			{
				ajax_addCart();
			} 
			else if(stok_cart_total > stok_db) 
			{
				$('#' + id_produk).val(stok_db - stok_cart);
				swal_warning();
			} 
		});

		// Load shopping cart
		$('#detail_cart').load("<?php echo base_url();?>/produk/load_cart");

		//Hapus Item Cart
		$(document).on('click','.hapus_cart',function(){
			var row_id=$(this).attr("id"); //mengambil row_id dari artibut id

			$.ajax({
				url : "<?php echo base_url();?>produk/delete_cart",
				method : "POST",
				data : {row_id : row_id},
				success :function(data){
					$('#detail_cart').html(data);
				}
			});
		});

		// Update stok cart
		$(document).on('change','.quantity',function(){
			var row_id = $(this).attr("id"); //mengambil row_id dari artibut id
			var stok = $(this).val();
			var stok_int = parseInt(stok);
			var stok_db  = $(this).attr("max");
			var stok_db_int = parseInt(stok_db);

			function ajax_updateCart(){
				$.ajax({
					url : "<?php echo base_url();?>produk/update_cart",
					method : "POST",
					data : {row_id : row_id, stok : stok} ,
					success :function(data){
						$('#detail_cart').html(data);
					}
				});
			}

			if(stok_int > stok_db_int){
				stok = stok_db
				ajax_updateCart();
			} 
			else if(stok_int < stok_db_int)
			{
				ajax_updateCart();
			}	
		});
	});
</script>
</body>
<br>
<br>
<br>
<br>	
