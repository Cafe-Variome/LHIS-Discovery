<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="<?php echo base_url() . (($session->get('admin_or_curate') == "curate") ? "curate" : "admin") ?>">
        <?php ($session->get('admin_or_curate') == "curate") ? print("Curators Home") : print ("Dashboard Home") ?>
    </a>
  </li>
  <li class="breadcrumb-item">
    <a href="<?php echo base_url() . (($session->get('admin_or_curate') == "curate") ? "curate" : "admin")."/variants";?>">
        Records
    </a>
   </li>
   <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
  </ol>
</nav>

<div class="row">
	<div class="col">
		<h2><?= $title ?></h2>	
	</div>	
</div>
<hr>
<div id="load"></div>
<div class="row">
    <div class="col">
        <h4>Import jsons into <?php echo $source; ?></h3>
        <p>This is built to only work with PhenoPackets. </p>
        <p>Up to 200 files can be uploaded in each batch. If you have more files to upload please break your upload into chunks.</p>

    </div>
</div>

<div id="json_errors"></div>
<form enctype="multipart/form-data" method="post" id="phenoinfo">
    <label>File/Files to submit:</label>
    <span class="btn btn-default btn-file" style="padding-top: 10px; line-height: normal;">
        <input type="file" name="userfile[]" id="jsonFile" multiple required/>
    </span>
    <input type="hidden" id="source_id" value="<?php echo $source ?>" />
    <br/><br/>
    <div class="pagination-centered">
        <button class="span3 btn btn-large btn-primary " type="submit">Upload File</button>
    </div>
</form> 
<hr>
<div class="row">
    <div class="col">
        <p>The Status table will refresh every 5 seconds. However as long as the search box is highlighted the refresh will not occur.</p>
    </div>
</div>
<input type="hidden" value="<?php echo $source ?>" name="source" id="source">
<table class="table table-hover table-striped" id="file_table">
    <thead>
        <tr>
        <th>File-name</th>
        <th>User</th>
        <th>Upload Start</th>
        <th>Upload End</th>
        <th>Errors</th>
        <th>Status</th>
        </tr>
    </thead>
    <tbody id="file_grid">
    </tbody>
</table>
<hr>
<div class="row">
    <div class="col">
    <a href="<?php
    if ($session->get('admin_or_curate') == "curate") {
        echo base_url() . "curate/variants";
    } else {
        echo base_url() . "source";
    }
    ?>" class="btn btn-secondary" ><i class="fa fa-backward"></i> Go back</a>
    </div>
</div>

<?= $this->endSection() ?>