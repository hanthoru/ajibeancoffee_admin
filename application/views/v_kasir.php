<!DOCTYPE html>
<html>
<head>
	<title>Shopping cart dengan codeigniter dan AJAX</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'asset/css/bootstrap.css'?>">
</head>
<body>
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
                                        <label class="card-text harga">Stok <?php echo $p->stok ?></label><br>
                                    </div>
                                    <div class="col-md-7">
                                        <label class="card-text harga">Rp. <?php echo number_format($p->harga, 2, ",", ".");?></label><br>
                                    </div>
                                    <div class="col-md-5">
									    <input type="number" name="quantity" id="<?php echo $p->id_produk;?>" value="1" class="quantity form-control">
								    </div>
                                </div>
                                <br>
                                <button class="add_cart btn btn-success btn-block" data-idproduk="<?php echo $p->id_produk;?>" data-namaproduk="<?php echo $p->nama_produk;?>" data-harga="<?php echo $p->harga;?>">Add To Cart</button>
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
			var quantity     = $('#' + id_produk).val();

			$.ajax({
				url : "<?= base_url().'produk/add_cart' ?>",
				method : "POST",
				data : {id_produk: id_produk, nama_produk: nama_produk, harga: harga, quantity: quantity},
				success: function(data){
					$('#detail_cart').html(data);

				}
			});
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
	});
</script>
<br>
<br>
<br>
<br>	
</body>
</html>