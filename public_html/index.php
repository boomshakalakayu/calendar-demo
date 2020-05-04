<?php include 'header.php' ?>
<?php include 'data.php' ?>
 <?php include 'template.php' ?>


<div id="calendar"  data-year="<?= date('Y') ?>" data-month="<?= date('m') ?>">
	<div id="header">
		<?= date('Y') ?>/<?= date('m') ?>
	</div>

	<div id="days" class="clearfix">
		<?php foreach ($days as $key => $day): ?>
			<div class="day float-left"><?= $day ?></div>
		<?php endforeach ?>
	</div>

	<div id="dates" class="clearfix">
		<?php foreach ($dates as $key => $date): ?>
			<div class="date-block float-left <?= (is_null($date)) ? 'empty' : ''?>"  data-date="<?= $date ?>">
				<div class="date"><?= $date ?></div>
				<div class="events">
				</div>
			</div>
		<?php endforeach ?>
		
	</div>
</div>

<div id="info-panel">
	<div class="close">x</div>
	<form>
		<input type="hidden" name="id">
		<div class="title">
			<label>event</label><br>
			<input type="text" name="title">
		</div>
		<div class="error-msg">
			<div class="alert alert-danger"></div>
		</div>
		<div class="time-picker">
			<div class="selected-date text-center">
				<span class="month"></span>/<span class="date"></span>
				<input type="hidden" name="year">
				<input type="hidden" name="month">
				<input type="hidden" name="date">
			</div>
			<div class="from">
				<label for="from">from</label><br>
				<input id="from" type="time" name="start_time">
			</div>
			<div class="to">
				<label for="to">to</label><br>
				<input id="to" type="time" name="end_time">
			</div>
		</div>
		<div class="description">
			<label>description</label><br>
			<textarea name="description" id="description"></textarea>
		</div>
	</form>
	
	<div class="button clearfix">
		<button class="create btn btn-success">create</button>
		<button class="update btn btn-success">update</button>
		<button class="cancel btn btn-secondary">cancel</button>
		<button class="delete btn btn-danger">delete</button>
	</div>
</div>
<?php include 'footer.php' ?>