<?php session_start(); ?>
<div id="create">
	<form role="form" name="newSection">
		<div class="form-group">
			<label>Title:
				<input type="text" name="sectionname" class="form-control">
			</label>

		</div>
		<div class="form-group">
			<label id="linklabel">Link:
				<input type="text" name="link" class="form-control" disabled style="background-color:#dfdfdf">
			</label>
			<label>Type
				<select name="type" class="form-control" id="typeselect">
					<option value="-1">Select</option>
					<option value="0">Header</option>
					<option value="1">Section</option>
					<option value="2">Code Example</option>
					<option value="3">Test</option>
					<option value="4">Link</option>
				</select>
			</label>
			<label>Select visibility for entry</label>
				<select name="visib" class='form-control'>
					<option id="select-opt" value="0">Select</option>
					<option class="select-opt" value="1">Hidden</option>
					<option class="select-opt" value="2">Shown</option>
				</select>
				<sub style="font-size:.8em; font-style:itelic;">
					Shown is visible to anyone with access to the course. 
					Hidden is only visible to users with write access to the course
				</sub>
		</div>
		<button type="button" onclick="submitNewSection()">Create new entry</button>
	</form>
</div>
<script type="text/javascript" src="js/sectionhandler.js"></script>
