<?= $this->extend('layout/dashboard') ?>
<?= $this->section('content') ?>

<div class="row">
	<div class="col">
		<h2><?= $title ?></h2>
	</div>
</div>
<hr>
<input type="hidden" id="csrf_token" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
<table class="table table-bordered table-striped">
	<tr>
		<th>Elasticsearch Service Status</th>
		<td>
			<?php if ($isRunning): ?>
				<span class="text-success">Running</span>
			<?php else: ?>
				<span class="text-danger">Not Running</span>
			<?php endif; ?>
		</td>
		<td></td>
	</tr>
	<tr>
		<th>Index Name</th>
		<td><?= $indexName ?></td>
		<td id="status-<?= $sourceId ?>"></td>
	</tr>
	<tr>
		<th>Index Status</th>
		<td><?= $indexStatusText ?></td>
		<td>
		</td>
	</tr>
	<tr>
		<th>Data Status</th>
		<td><?= $dataStatusText ?></td>
		<td id="action-<?= $sourceId ?>">
			<?php if($dataStatus == ELASTICSEARCH_DATA_STATUS_FULLY_INDEXED || $dataStatus == ELASTICSEARCH_DATA_STATUS_NOT_INDEXED): ?>
				<button onclick="regenElastic('<?= $sourceId; ?>', false);" class="btn btn-primary">Re-index Data</button>
			<?php endif; ?>
			<?php if($dataStatus == ELASTICSEARCH_DATA_STATUS_PARTIALLY_INDEXED): ?>
				<button onclick="regenElastic('<?= $sourceId; ?>', true);" class="btn btn-success">Index Appended Data</button>
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<th>Index Details</th>
		<td>
			UUID: <?= $indexUUID ?></br>
			Size: <?= $indexSize ?></br>
			Number of Documents Indexed: <?= $indexDocIndexed ?></br>
			Number of Deleted Documents: <?= $indexDocDeleted ?></br>
		</td>
		<td></td>
	</tr>
</table>
<hr>
<div class="row mb-5">
	<div class="col">
		<a class="btn btn-secondary bg-gradient-secondary" href="<?= base_url('Source') ?>">
			<i class="fa fa-database"></i> View Sources
		</a>
	</div>
</div>
<?= $this->endSection() ?>