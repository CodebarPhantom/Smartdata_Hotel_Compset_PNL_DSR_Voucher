<script src="<?php echo base_url();?>assets/backend/global_assets/js/plugins/forms/selects/select2.min.js"></script>


<script type="text/javascript">
	    
		$(document).ready(function() {

			$('.daterange-single').daterangepicker({
			singleDatePicker: true,
			locale: {
				format: 'DD-MM-YYYY'
			}
			});
			$('.table-togglable').footable();
			$('.custom_category').select2();

			$(function(){
				$(".letternumber").keypress(function(event){
					var ew = event.which;
					if(ew == 32)
						return true;
					if(48 <= ew && ew <= 57)
						return true;
					if(65 <= ew && ew <= 90)
						return true;
					if(97 <= ew && ew <= 122)
						return true;
					return false;
				});
			});
	});
	</script>
	<?php
    //initialization
     
     //$url_city = '';
     $url_hotel = '';

     //get from function
     //$url_city = $city;
     $url_hotel = $listhotel;
    ?>  
		<!-- Page header -->
        <div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold"> <?php echo $lang_voucher_hotels; ?></span> - <?php echo $lang_data_vouchers; ?></h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>
		</div>
		<!-- /page header -->                
                <!-- Row toggler -->
				<div class="card">
					<div class="card-header header-elements-inline">
					<div class="col-md-12">
						<form action="<?php echo base_url()?>smartreportvoucher/voucher-hotels" method="get" accept-charset="utf-8">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">							
										<button type="button" class="btn bg-teal-400 btn-labeled btn-labeled-left" data-toggle="modal" data-target="#modal_add_voucher"><b><i class="icon-price-tags2"></i></b> <?php echo $lang_add_voucher; ?></button>
									</div>
								</div>	
							</div>
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<label><?php echo $lang_search_voucher; ?></label>
										<input type="text" name="idvoucher" class="form-control" placeholder="<?php echo $lang_idvoucher; ?>..." value="<?php echo $guest_name ?>" />
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label><?php echo $lang_guest_name; ?></label>
										<input type="text" name="guestname" class="form-control" placeholder="<?php echo $lang_guest_name; ?>..." value="<?php echo $guest_name ?>" />
									</div>
								</div>
								
								<div class="col-md-3">
									<div class="form-group">
										<label><?php echo $lang_hotel; ?></label>
											<select name="listhotel" class="form-control custom_category" required autocomplete="off">
												<option value="all"><?php echo $lang_all_hotels; ?></option>
											<?php
												$hotelData = $this->Smartreport_hotels_model->getDataParent('smartreport_hotels', 'idhotels','PARENT', 'ASC');
												for ($p = 0; $p < count($hotelData); ++$p) {
													$idhotel = $hotelData[$p]->idhotels;
													$hotelname = $hotelData[$p]->hotels_name;?>
													<option  value="<?php echo $idhotel; ?>" <?php if ($url_hotel == $idhotel) {
													echo 'selected="selected"';
													} ?>>
														<?php echo $hotelname; ?>
													</option>
											<?php											
												unset($idhotel);
												unset($hotelname);
												}
											?>
											</select>
									</div>
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<label>&nbsp;</label><br/>
										<button type="submit" class="btn bg-teal-400 "><?php echo $lang_search; ?></button>
									</div>
								</div>

								<div class="col-md-1">
									<div class="form-group">
										<?php if ($guest_name != '' || $listhotel != ''){?>
											<label>&nbsp;</label><br/>
											<a href="<?php echo site_url('smartreport/competitor-hotel'); ?>" class="btn btn-orange">Reset</a>
										<?php } ?>
									</div>
								</div>
								
							</div>
						</form>	
					</div>	
					
					</div>

					<table class="table table-bordered table-togglable table-hover table-xs  ">
						<thead>
							<tr>
								<th data-hide="phone">#</th>
								<th data-hide="phone"><?php echo $lang_idvoucher; ?></th>                                
								<th data-toogle="true"><?php echo $lang_guest_info; ?></th>								
								<th data-hide="phone"><?php echo $lang_voucher_info; ?></th>
								<th data-hide="phone"><?php echo $lang_stay_info; ?></th>							
								<th class="text-center" data-hide="phone"><?php echo $lang_action; ?></th>								
								<th class="text-center" style="width: 30px;"><i class="icon-menu-open2"></i></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($smartreport_vouchers_data as $smartreport_vouchers){?>
							<tr>
								<td><?php echo ++$start; ?></td>
								<td><?php echo $smartreport_vouchers->idvoucher; ?></td>
								<td><?php 
										$phone = $smartreport_vouchers->guest_phone;
										$phone_show = sprintf("%s-%s-%s",
															substr($phone, 0, 4),
															substr($phone, 4, 4),
															substr($phone, 8));
										echo "<strong>".ucwords($smartreport_vouchers->guest_name)."</strong><br/>".$phone_show."<br/>".$smartreport_vouchers->guest_email; ?></td>								
								<td>
									<?php 
										$created_date = strtotime($smartreport_vouchers->created_at);
										$last_lock_date = strtotime($smartreport_vouchers->lock_at);
										$redeem_date = strtotime($smartreport_vouchers->redeem_at);

										echo $lang_created_at.": ".date('d M Y',$created_date)."<br/>";
										echo $smartreport_vouchers->lock_at !== '0000-00-00 00:00:00' ? $lang_last_lock_at.": ".date('d M Y',$last_lock_date)."<br/>" : $lang_last_lock_at.": -"."<br/>";
										echo $smartreport_vouchers->redeem_at !== '0000-00-00 00:00:00' ? $lang_redeem_at.": ".date('d M Y',$redeem_date)."<br/>" : $lang_redeem_at.": -"."<br/>";
										?>
								</td>
								<td>
									<?php 
										$stay_date = strtotime($smartreport_vouchers->stay_date);
										echo $smartreport_vouchers->fk_idhotels !== ''? $lang_hotel.": ".$smartreport_vouchers->hotels_name."<br/>" : $lang_hotel.": - <br/>";
										echo $smartreport_vouchers->stay_date !== '0000-00-00 00:00:00' ? $lang_stay_date.": ".date('d M Y',$stay_date)."<br/>" : $lang_stay_date.": -"."<br/>";
										?>
										<?php if($smartreport_vouchers->status_voucher === '0') { ?>
											<span class="badge badge-danger d-block">Used</span> 
										<?php }else if($smartreport_vouchers->status_voucher === '1') { ?>
											<span class="badge badge-success d-block">Not Used</span> 
										<?php }else if ($smartreport_vouchers->status_voucher === '2'){ ?>
											<span class="badge bg-orange d-block">Lock</span>
										<?php } ?>
								</td>
								<td>
									<?php if($smartreport_vouchers->status_voucher === '0') { ?>
										<div class="text-center">	
											<button type="button" data-popup="tooltip" title="Voucher Used" class="btn btn-outline bg-danger border-danger text-danger-800 btn-icon border-2 ml-2"><i class="icon-cross2"></i></button>
										</div>
									<?php }else if($smartreport_vouchers->status_voucher === '1') { ?>
										<div class="text-center">	
											<button type="button" data-popup="tooltip" title="Lock" class="btn btn-outline bg-orange border-orange text-orange-800 btn-icon border-2 ml-2" data-toggle="modal" data-target="#modal_lock_voucher<?=$smartreport_vouchers->idvoucher;?>"><i class="icon-lock5"></i></button>
										</div>
									<?php }else if($smartreport_vouchers->status_voucher === '2') { ?>
										<div class="text-center">	

										<script>		
											jQuery(document).ready(function($){
												$('.unlock_voucher').on('click',function(){
												
													var url = $(this).attr('href');
													swal({
														title: '<?php echo $lang_unlock_voucher." ".$smartreport_vouchers->idvoucher; ?>',					
														type: 'question',
														showCancelButton: true,
														confirmButtonColor: '#ffa801',
														cancelButtonColor: ' #3085d6',
														confirmButtonText: '<?php echo $lang_unlock_voucher_confirm; ?>',
														confirmButtonClass: 'btn btn-success',
														cancelButtonClass: 'btn btn-danger',
														closeOnConfirm: false
														}).then(function(result) {
															if(result.value) {
																window.location.href = url
															}
															else if(result.dismiss === swal.DismissReason.cancel) {
																
															}
														});
													
													return false;
												});
											});
										</script>

											<a href="<?php echo base_url('smartreportvoucher/unlock_voucher/'.$smartreport_vouchers->idvoucher);?>"
											type="button" data-popup="tooltip" title="Unlock" class="btn btn-outline bg-danger border-danger text-danger-800 btn-icon border-2 ml-2 unlock_voucher"><i class="icon-unlocked2"></i></a>

											<button type="button" data-popup="tooltip" title="Redeem" class="btn btn-outline bg-success border-success text-success-800 btn-icon border-2 ml-2"><i class="icon-checkmark3"></i></button>
										</div>
									<?php } ?>
								</td>
																
								<td class="text-center">
									<div class="list-icons">
										<div class="dropdown">
											<a href="#" class="list-icons-item" data-toggle="dropdown">
												<i class="icon-menu9"></i>
											</a>

											<div class="dropdown-menu dropdown-menu-right">
												<a data-toggle="modal" data-target="#modal_edit_hotel<?=$smartreport_vouchers->idvoucher;?>" class="dropdown-item"><i class="icon-pencil"></i><?php echo $lang_edit_hotel; ?></a>
												
											</div>
										</div>
									</div>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
						
					<div >													
						<?php echo $pagination ?>									
					</div>
				</div>
				<!-- /row toggler -->

				<!-- Vertical form modal -->
				<div id="modal_add_voucher" class="modal fade" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?php echo $lang_add_voucher; ?></h5>
								<button type="button" class="close"  data-dismiss="modal" aria-hidden="true">&times;</button>
							</div>

							<form action="<?=base_url()?>smartreportvoucher/insert_voucher"  method="post">
								<div class="modal-body">	
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label><?php echo $lang_guest_name; ?></label>
												<input type="text" name="guest_name" placeholder="Guest Name..." class="form-control letternumber" required>											
											</div>	
											<div class="col-sm-6">
												<label><?php echo $lang_phone; ?></label>
												<input type="number" name="guest_phone" placeholder="Phone..." class="form-control" required>											
											</div>									
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label><?php echo $lang_email; ?></label>
												<input type="email" name="guest_email" placeholder="Email..." class="form-control" required>											
											</div>												
											<div class="col-sm-6">
												<label><?php echo $lang_voucher_amount; ?></label>
												<select name="voucher_amount" class="form-control" required autocomplete="off">													
													<option value="1"><?php echo "1"; ?></option>
													<option value="2"><?php echo "2"; ?></option>
													<option value="3"><?php echo "3"; ?></option>
													<option value="4"><?php echo "4"; ?></option>													
													<option value="5"><?php echo "5"; ?></option>													

												</select>
											</div>
										</div>
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link" aria-hidden="true" data-dismiss="modal"><?php echo $lang_close; ?></button>
									<button type="submit" class="btn bg-primary"><?php echo $lang_submit; ?></button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- /vertical form modal -->

				<!-- Vertical form modal -->
				<?php foreach ($smartreport_vouchers_data as $smartreport_vouchers){?>
				<div id="modal_lock_voucher<?=$smartreport_vouchers->idvoucher;?>" class="modal fade" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?php echo $lang_lock_voucher.' - '.$smartreport_vouchers->idvoucher; ?></h5>
								<button type="button" class="close"  data-dismiss="modal" aria-hidden="true">&times;</button>
							</div>

							<form action="<?=base_url()?>smartreportvoucher/lock_voucher"  method="post">
								<div class="modal-body">
								
									
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label><?php echo $lang_stay_date; ?></label>
												<input type="text" data-mask="99-99-9999" name="stay_date"	class="form-control daterange-single" value="<?php echo date("d-m-Y");?>" required />											
											</div>												
											<div class="col-sm-6">
												<label><?php echo $lang_hotel; ?></label>
												<select name="idhotels" class="form-control" required autocomplete="off">
													<option value=""><?php echo $lang_choose_hotels; ?></option>
												<?php
													$competitorData = $this->Smartreport_hotels_model->getDataParent('smartreport_hotels', 'idhotels','PARENT', 'ASC');
													for ($p = 0; $p < count($competitorData); ++$p) {
														$idcompetitor = $competitorData[$p]->idhotels;
														$competitorname = $competitorData[$p]->hotels_name;?>
														<option  value="<?php echo $idcompetitor; ?>">
															<?php echo $competitorname; ?>
														</option>
												<?php
														unset($idcompetitor);
														unset($competitorname);
													}
												?>
												</select>
											</div>
										</div>
									</div>
								
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link" aria-hidden="true" data-dismiss="modal"><?php echo $lang_close; ?></button>
									<input type="hidden" name="idvoucher" class="form-control" value="<?=$smartreport_vouchers->idvoucher;?>" required>
									<button type="submit" class="btn bg-primary"><?php echo $lang_submit; ?></button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<?php } ?>
				<!-- /vertical form modal -->