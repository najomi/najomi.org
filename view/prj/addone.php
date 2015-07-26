<fieldset>
	<legend>Добавление примера</legend>
	<form action='/insertone/<?php echo bu::args(0);?>' method='post'>
		<p>
			<label for='category'> Категория: </label><br>
			<input type='text' class='title' name='category' value='<?php echo bu::args(0);?>' id='category'><br>
		</p>
		<p>
			<label for='from'> Источник: </label><br>
			<input type='text' class='text' name='from' id='from'>
		</p>
		<p>
			<label for='example'> Кусок кода: </label><br>
			<textarea name='example' id='example'></textarea>
		</p>
		<p>
			<label for='description'>Описание:</label><br>
			<textarea name='description' id='description'></textarea><br>
		</p>
		<input type='submit' value='Добавить'>
	</form>
</fieldset>
