
<div class="modal-body" id="maincontent">
	<section class="content" id="maincontent">
		<form id="mainform" name="mainform" action="" method="post">
			<div class="row">
				<div class="col-md-12">
					<div id="chart"> </div>
					<div class="col-sm-12">
						<div class="table-responsive">
							<table class="table table-bordered dataTable table-hover nowrap">
								<thead>
									<tr>
										<th width='5%'>No</th>
										<th width='50%'>Jenis Kelompok</th>
										<?php if ($jenis_laporan == 'penduduk'): ?>
											<th width='15%' colspan="2">Laki-Laki</th>
											<th width='15%' colspan="2">Perempuan</th>
										<?php endif; ?>
										<th width='15%'colspan="2">Jumlah</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($main as $data): ?>
										<?php if ($lap>50) $tautan_jumlah = site_url("program_bantuan/detail/1/$lap/1"); ?>
										<tr>
											<td><?= $data['no']?></td>
											<td><?= strtoupper($data['nama']);?></td>
											<td>
												<?php if (in_array($lap, array(21, 22, 23, 24, 25, 26, 27, 'kelas_sosial', 'bantuan_keluarga'))): ?>
													<a href="<?= site_url("keluarga/statistik/$lap/$data[id]")?>/0" <?php if ($data['id']=='JUMLAH'): ?>class="disabled"<?php endif; ?>><?= $data['jumlah']?></a>
												<?php else: ?>
													<?php if ($lap<50) $tautan_jumlah = site_url("penduduk/statistik/$lap/$data[id]"); ?>
													<a href="<?= $tautan_jumlah ?>/0" <?php if ($data['id']=='JUMLAH'): ?> class="disabled"<?php endif; ?>><?= $data['jumlah']?></a>
												<?php endif; ?>
											</td>
											<td><?= $data['persen'];?></td>
											<?php if (in_array($lap, array(21, 22, 23, 24, 25, 26, 27, 'kelas_sosial', 'bantuan_keluarga'))): ?>
												<?php $tautan_jumlah = site_url("keluarga/statistik/$lap/$data[id]"); ?>
											<?php elseif ($lap<50): ?>
												<?php $tautan_jumlah = site_url("penduduk/statistik/$lap/$data[id]"); ?>
											<?php endif; ?>
											<?php if ($jenis_laporan == 'penduduk'): ?>
												<td><a href="<?= $tautan_jumlah?>/1" <?php if ($data['id']=='JUMLAH'): ?>class="disabled"<?php endif; ?>><?= $data['laki']?></a></td>
												<td><?= $data['persen1'];?></td>
												<td><a href="<?= $tautan_jumlah?>/2" <?php if ($data['id']=='JUMLAH'): ?>class="disabled"<?php endif; ?>><?= $data['perempuan']?></a></td>
												<td><?= $data['persen2'];?></td>
											<?php endif; ?>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>

<?php if ($jenis_chart == 'bar'): ?>
	<!-- Pengaturan Grafik (Graph) Data Statistik-->
	<script type="text/javascript">
		var chart;
		$(document).ready(function()
		{
			chart = new Highcharts.Chart(
			{
				chart:
				{
					renderTo: 'chart',
					defaultSeriesType: 'column'
				},
				title:
				{
					text: 'Data Statistik Kependudukan'
				},
				subtitle:
				{
					text: 'Berdasarkan <?= $stat?>'
				},
				xAxis:
				{
					title:
					{
						text: '<?= $stat?>'
					},
	        categories: [
						<?php $i=0; foreach ($main as $data): $i++;?>
						  <?php if ($data['jumlah'] != "-"): ?><?= "'$i',";?><?php endif; ?>
						<?php endforeach;?>
					]
				},
				yAxis:
				{
					title:
					{
						text: 'Jumlah Populasi'
					}
				},
				legend:
				{
					layout: 'vertical',
	        enabled:false
				},
				plotOptions:
				{
					series:
					{
	          colorByPoint: true
	        },
	      column:
				{
					pointPadding: 0,
					borderWidth: 0
				}
			},
			series: [
			{
				shadow:1,
				border:1,
				data: [
					<?php foreach ($main as $data): ?>
					  <?php if (!in_array($data['nama'], array("TOTAL", "JUMLAH", "PENERIMA"))): ?>
						  <?php if ($data['jumlah'] != "-"): ?>
								['<?= strtoupper($data['nama'])?>',<?= $data['jumlah']?>],
							<?php endif; ?>
						<?php endif; ?>
					<?php endforeach;?>]
				}]
			});
		});
	</script>
<?php else: ?>
	<!-- Pengaturan Grafik Chart Pie Data Statistik-->
	<script type="text/javascript">
		$(document).ready(function ()
		{
			chart = new Highcharts.Chart({
				chart:
				{
					renderTo: 'chart',
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false
				},
				title:
				{
					text: 'Data Statistik Kependudukan'
				},
				subtitle:
				{
					text: 'Berdasarkan <?= $stat?>'
				},
				plotOptions:
				{
					index:
					{
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels:
						{
							enabled: true
						},
						showInLegend: true
					}
				},
				legend:
				{
					layout: 'vertical',
					backgroundColor: '#FFFFFF',
					align: 'right',
					verticalAlign: 'top',
					x: -30,
					y: 0,
					floating: true,
					shadow: true,
	        enabled:true
				},
				series: [{
					type: 'pie',
					name: 'Populasi',
					data: [
						<?php foreach ($main as $data): ?>
							<?php if (!in_array($data['nama'], array("TOTAL", "JUMLAH", "PENERIMA"))): ?>
								<?php if ($data['jumlah'] != "-"): ?>
									['<?= strtoupper($data['nama'])?>',<?= $data['jumlah']?>],
								<?php endif; ?>
							<?php endif; ?>
						<?php endforeach;?>
					]
				}]
			});
		});
	</script>
<?php endif; ?>

<!-- Highcharts -->
<script src="<?= base_url()?>assets/js/highcharts/exporting.js"></script>
<script src="<?= base_url()?>assets/js/highcharts/highcharts-more.js"></script>
