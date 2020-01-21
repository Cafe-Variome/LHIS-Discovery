<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url('Admin/Index');?>">Dashboard Home</a></li>
    <li class="breadcrumb-item"><a href="<?php echo base_url($controllerName);?>">Elastic Search</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
  </ol>
</nav>
<div class="row">
	<div class="col">
		<h2><?= $title ?></h2>	
	</div>	
</div>
<hr>
<div class="row">
  <div class="col">
  Elasticsearch Service Status: 
  <?php if ($isRunning): ?>
    <span class="text-success">Running</span>
  <?php else: ?>
    <span class="text-danger">Not Running</span>
  <?php endif; ?>
  </div>
</div>
<br/>
<table class="table table-bordered table-hover table-striped" id="index_table">
  <thead>
    <tr>
        <th>ElasticSearch Index Name</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
  </thead>
  <tbody id="index_grid">
    <?php foreach ($elastic_update as $row): ?> 
    <tr id="index_<?php echo $row['source_id']; ?>">
      <td><?php echo $host."_".$row['source_id']." (Source: ".$row['name'].")"; ?></td>
        <?php if ($row['elastic_index'] == true): ?>
          <td style="background-color: lightgreen;">
            <i class="fa fa-check"></i>
            Up to Date
          </td>                                  
        <?php else: ?>
          <td style="background-color: lightblue;">
              <i class="fa fa-plus"></i>
              Update Possible
            <!-- Update Possible -->
          </td>                                               
      <?php endif; ?>

      <td>                                    
        <a onclick="regenElastic('<?php echo $row['source_id']; ?>', false);" id="update_<?php echo $row['name']; ?>" data-toggle="tooltip" data-placement="top" title="Click to regenerate this ElasticSearch Index">
          <span class="fa fa-redo text-info"></span>
        </a>
        <a onclick="regenElastic('<?php echo $row['source_id']; ?>',true);" data-toggle="tooltip" data-placement="top" title="Click to append newly-uploaded data to ElasticSearch (This does not affect data already present)">
          <span class="fa fa-sync text-warning"></span>
        </a>
      </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?= $this->endSection() ?>