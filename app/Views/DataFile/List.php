<?= $this->extend('layout/dashboard') ?>
<?= $this->section('content') ?>
<div class="row">
	<div class="col">
		<h2><?= $title ?> of '<?= $source->name ?>'</h2>
	</div>
</div>
<hr>
<?php if ($statusMessage): ?>
	<div class="row">
		<div class="col">
			<div class="alert alert-<?= $statusMessageType ?>">
				<?= $statusMessage ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<table class="table table-bordered table-striped table-hover" id="datafilestable">
	<thead>
	<tr>
		<th>Name</th>
		<th>Size</th>
		<th>Upload Date</th>
		<th>Records</th>
		<th>User</th>
		<th>Status</th>
		<th>Action</th>
	</tr>
	</thead>
	<tbody>
	<?php for($c = 0; $c < count($dataFiles); $c++): ?>
	<tr>
		<td><?= $dataFiles[$c]->name ?></td>
		<td><?= \App\Libraries\CafeVariome\Helpers\UI\SourceHelper::formatSize($dataFiles[$c]->size) ?></td>
		<td><?= date("H:i:s d-m-Y T", $dataFiles[$c]->upload_date) ?></td>
		<td><?= $dataFiles[$c]->record_count ?></td>
		<td>
			<?= $dataFiles[$c]->user->username ?>
			<br>
			(<?= $dataFiles[$c]->user->first_name ?> <?= $dataFiles[$c]->user->last_name ?>)
		</td>
		<td><?= \App\Libraries\CafeVariome\Helpers\UI\DataFileHelper::GetDataFileStatus($dataFiles[$c]->status) ?></td>
		<td id="action-<?= $dataFiles[$c]->getID() ?>">
			<?php if($dataFiles[$c]->status != DATA_FILE_STATUS_PROCESSING): ?>
				<div id="actionBtns-<?= $dataFiles[$c]->getID() ?>">
					<a data-placement="top" title="Process Data File" data-toggle="modal" data-target="#taskModal" data-fileid="<?= $dataFiles[$c]->getID() ?>" data-filename="<?= $dataFiles[$c]->name ?>">
						<i class="fa fa-play text-success"></i>
					</a>
					<?php if($dataFiles[$c]->status == DATA_FILE_STATUS_PROCESSED): ?>
					<a href="<?php echo base_url($controllerName.'/DeleteRecords'). "/" . $dataFiles[$c]->getID() ?>" data-toggle="tooltip" data-placement="top" title="Delete Records">
						<i class="fa fa-trash-alt text-warning"></i>
					</a>
					<?php endif; ?>
					<a href="<?php echo base_url($controllerName.'/Delete'). "/" . $dataFiles[$c]->getID() ?>" data-toggle="tooltip" data-placement="top" title="Delete Data File">
						<i class="fa fa-trash text-danger"></i>
					</a>
				</div>
			<?php endif; ?>
		</td>
	</tr>
	<?php endfor; ?>
	</tbody>
</table>

<div class="row">
	<div class="col">
		<a href="<?= base_url($controllerName.'/Upload/' . $source->getID()) ?>" class="btn btn-success bg-gradient-success">
			<i class="fa fa-upload"></i>  Upload Data File(s)
		</a>
		<a href="<?= base_url($controllerName.'/Import/' . $source->getID()) ?>" class="btn btn-primary bg-gradient-primary">
			<i class="fas fa-file-import"></i> Import Data File(s)
		</a>
		<a class="btn btn-secondary bg-gradient-secondary" href="<?= base_url('Source') ?>">
			<i class="fa fa-database"></i> View Sources
		</a>
	</div>
</div>

<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="taskModalLabel">Process Data File</h5>
			</div>
			<?= form_open('AjaxApi/processFile', ['method' => 'post']) ?>
			<input type="hidden" name="fileId" id="fileId" value="-1">
			<div class="modal-body">
				<div class="form-group row">
					<div class="col-3">File Name</div>
					<div class="col-9" id="fileName"></div>
				</div>
				<div class="form-group row">
					<div class="col-3">Pipeline</div>
					<div class="col-5">
						<?= form_dropdown($pipeline); ?>
					</div>
					<div class="col-4">
						<a href="<?= base_url('Pipeline') ?>" target="_blank">View Pipelines</a>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-3"></div>
					<div class="col-9">
						<span id="statusMessage"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<span id="spinner" class="spinner-border spinner-border-sm text-warning" role="status" aria-hidden="true" style="display:none"></span>
				<button type="button" id="processBtn" class="btn bg-gradient-primary btn-primary">
					<i class="fa fa-play"></i> Start Processing
				</button>
				<button type="button"  id="cancelBtn" class="btn bg-gradient-secondary btn-secondary" data-dismiss="modal">
					<i class="fa fa-times"></i> Cancel
				</button>
			</div>
			<?= form_close(); ?>
		</div>
	</div>
</div>

<?= $this->endSection() ?>