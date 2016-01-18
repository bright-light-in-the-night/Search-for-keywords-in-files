<?php

/*
last modification date: 18.01.2016 14:40
*/

# main settings
error_reporting(E_ALL);
set_time_limit(0);
ini_set('memory_limit', '512M');
ini_set('display_errors', 'On');
define('FAST_SEARCH', true); // fast search might miss ocurrences, while slow search doesn't

# files path
$current_dir = dirname(__FILE__);
$current_file = basename(__FILE__);
$current_link = 'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];

# blacklisted files (which are not being included in search)
$blacklist_files = array(
	'.',
	'..',
	$current_file
);
# blacklisted folders (which are not being included in search)
$blacklist_folders = array(
	'html',
	'phpMyAdmin'
);
# blacklisted files extensions (which are not being included in search)
$blacklist_extensions = array(
	'htaccess',
	'jpeg',
	'png',
	'bmp',
	'gif',
	'pdf',
	'eot',
	'svg',
	'ttf',
	'woff',
	'html',
	'htm',
	'zip',
	'tar.gz',
);

# static content delivery
if (isset($_GET['file']) && is_string($_GET['file']))
{
	switch ($_GET['file'])
	{
		case 'favicon':
			$filetype = 'image/x-icon';
			$content = 'AAABAAEAEBAAAAEAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAYWFh/mFhYf5hYWH+YWFh/mFhYf5hYWH+YWFh/mFhYf5hYWH+YWFh/mFhYf5hYWH+YWFh/mFhYf4AAAAAYWFh/mFhYf5hYWH+YWFh/mFhYf5hYWH+YWFh/mFhYf5hYWH+YWFh/mFhYf5hYWH+YWFh/mFhYf5hYWH+YWFh/mFhYf5hYWH+YWFh/mFhYf5hYWH+YWFh/mFhYf5hYWH+YWFh/mFhYf5hYWH+YWFh/mFhYf5hYWH+YWFh/mFhYf5hYWH+YWFh/mFhYf5hYWH+YWFh/mFhYf5hYWH+YWFh/mFhYf5hYWH+YWFh/v7+/v7+/v7+YWFh/mFhYf5hYWH+YWFh/mlpaf5paWn+aWlp/mlpaf5paWn+aWlp/mlpaf5paWn+aWlp/v7+/v7+/v7+/v7+/mlpaf5paWn+YWFh/mFhYf5paWn+aWlp/mlpaf5paWn+aWlp/mlpaf5paWn+aWlp/v7+/v7+/v7+/v7+/mlpaf5paWn+aWlp/mFhYf5hYWH+aWlp/mlpaf5paWn+lpaW/v7+/v7+/v7+/v7+/v7+/v7+/v7+/v7+/mlpaf5paWn+aWlp/mlpaf5hYWH+YWFh/nV1df51dXX+lpaW/v7+/v6/v7/+dXV1/r+/v/7+/v7+/v7+/nV1df51dXX+dXV1/nV1df51dXX+YWFh/mFhYf51dXX+dXV1/v7+/v6/v7/+dXV1/nV1df51dXX+v7+//v7+/v51dXX+dXV1/nV1df51dXX+dXV1/mFhYf5hYWH+dXV1/nV1df7+/v7+dXV1/nV1df51dXX+dXV1/nV1df7+/v7+dXV1/nV1df51dXX+dXV1/nV1df5hYWH+YWFh/nV1df51dXX+/v7+/r+/v/51dXX+dXV1/nV1df6/v7/+/v7+/nV1df51dXX+dXV1/nV1df51dXX+YWFh/mFhYf51dXX+dXV1/paWlv7+/v7+v7+//nV1df6/v7/+/v7+/nV1df51dXX+dXV1/nV1df51dXX+dXV1/mFhYf5hYWH+h4eH/oeHh/6Hh4f+lpaW/v7+/v7+/v7+/v7+/paWlv6Hh4f+h4eH/oeHh/6Hh4f+h4eH/oeHh/5hYWH+YWFh/oeHh/6Hh4f+h4eH/oeHh/6Hh4f+h4eH/oeHh/6Hh4f+h4eH/oeHh/6Hh4f+h4eH/oeHh/6Hh4f+YWFh/mFhYf6Hh4f+h4eH/oeHh/6Hh4f+h4eH/oeHh/6Hh4f+h4eH/oeHh/6Hh4f+h4eH/oeHh/6Hh4f+h4eH/mFhYf4AAAAAYWFh/mFhYf5hYWH+YWFh/mFhYf5hYWH+YWFh/mFhYf5hYWH+YWFh/mFhYf5hYWH+YWFh/mFhYf4AAAAAgAEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgAEAAA==';
			break;
	}

	if (isset($filetype))
	{
		header('Content-Type: '. $filetype);
		echo base64_decode($content);
		exit;
	}
}

// functions declarations
function dir_to_array($dir)
{

	static $result = array();
	global $blacklist_files, $blacklist_folders, $blacklist_extensions;

	$cdir = scandir($dir);
	foreach ($cdir as $key => $value)
	{
		if (!in_array($value, $blacklist_files))
		{
			$ext = pathinfo($value, PATHINFO_EXTENSION);
			if (!$blacklist_extensions || !in_array($ext, $blacklist_extensions))
			{

					if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
						if (!$blacklist_folders || !in_array(basename($dir), $blacklist_folders))
						{
							if($dir != '.'){
								$result += dir_to_array($dir . DIRECTORY_SEPARATOR . $value);
							}
						}
					} else {
						$result[] = $dir . DIRECTORY_SEPARATOR . $value;
					}

			}
		}
	}
	return $result;
}

function search_in_file($file, $keyword)
{
	$handle = @fopen($file, "rb");

	$occurrences = 0;

	if (FALSE !== $handle)
	{
		if (FAST_SEARCH)
		{
			while (!feof($handle))
			{
				$lastPos = 0;
				$content = fread($handle, 8192);
				$k_len = strlen($keyword);	
				while (($lastPos = strpos($content, $keyword, $lastPos)) !== false)
				{
					$lastPos = $lastPos + $k_len;
					$occurrences++;
				}
			}
		}
		else{
			while (($content = fgets($handle)) !== false)
			{
				$lastPos = 0;
				$k_len = strlen($keyword);	
				while (($lastPos = strpos($content, $keyword, $lastPos)) !== false)
				{
					$lastPos = $lastPos + $k_len;
					$occurrences++;
				}
			}
		}
		fclose($handle);
	}
	else {
		// we don't have file permissions
	}
	
	return $occurrences;
}

function human_filesize($bytes, $decimals = 2)
{
    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f ", $bytes / pow(1024, $factor)) . @$size[$factor];
}

function get_first_level_directories_from_root()
{
	global $current_dir;

	$dirs = array();
	$cdir = scandir($current_dir);
	foreach ($cdir as $file) {
		if ($file != '.' && $file != '..' && is_dir($file)) {
			$dirs[] = $file;
		}
	}
	return $dirs;
}

function html_header($title = '')
{
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<title>Search in files for keyword - <?php echo $title;?></title>
		<link rel="shortcut icon" href="?file=favicon" />
		<style>
		* {
			margin: 0;
		}
		body {
			padding: 10px;
			font-size: 15px;
			line-height: 1;
			color: #444;
		}
		a, a:hover {
			color: #FF6000;
		}
		h2 {
			color: #444;
			display: block;
			margin-bottom: 10px;
		}
		p, form {
			margin-bottom: 20px;
		}
		hr {
			margin: 20px 0;
			color: #eee;
		}
		table {
			border-collapse: collapse;
			border-spacing: 0;
		}
		thead td {
			font-weight: bold;
			font-size: 16px;
			background-color: #fafafa;
		}
		table td {
			border: 1px #ccc solid;
			padding: 5px 12px;
		}
		tbody tr:hover td {
			background-color: #FCF3C9;
		}
		input[type="text"] {
			width: 220px;
			border: 1px #888 solid;
			padding: 10px 10px;
			color: #888;
			border-radius: 2px;
		}
		input[type="text"]:focus {
			border-color: #008EE8;
			box-shadow: inset 0 0 3px #eee;
		}
		input[type="submit"] {
			border: 1px #888 solid;
			padding: 9px 20px;
			cursor: pointer;
			background-color: #222;
			color: #fff;
			border-radius: 2px;
		}
		input[type="submit"]:hover {
			background-color: #008EE8;
			color: #fff;
		}
		.mb10 {
			margin-bottom: 10px;
		}
		.db {
			display: block;
		}
		.blue {
			color: #008EE8;
		}
		.orange {
			color: #FF6000;
		}
		.btn-warning {
			background-color: #F6BB42;
			color: #FFFFFF;
		}
		.btn-warning:hover {
			background-color: #F4AE1D;
			border-color: rgba(0, 0, 0, 0.05);
			color: #FFFFFF;
		}
		.btn {
			-moz-user-select: none;
			background-image: none;
			border: 1px solid rgba(0, 0, 0, 0);
			border-radius: 0;
			cursor: pointer;
			display: inline-block;
			font-size: 14px;
			font-weight: normal;
			line-height: 1.2;
			margin-bottom: 0;
			padding: 9px 12px;
			text-align: center;
			text-decoration: none;
			vertical-align: middle;
			white-space: nowrap;
		}
		.scrollbox {
			border: 1px solid #CCCCCC;
			width: 350px;
			height: 100px;
			background: #FFFFFF;
			overflow-y: scroll;
		}
		.scrollbox div {
			padding: 3px;
		}
		.scrollbox div input {
			margin: 0px;
			padding: 0px;
			margin-right: 3px;
		}
		.scrollbox div.even {
			background: #FFFFFF;
		}
		.scrollbox div.odd {
			background: #E4EEF7;
		}
		</style>
	</head>
	<body>
	<?php
}

function html_footer() {
	?>
	</body>
	</html>
	<?php
}

# application start
$found_in_files = array();
$keyword = '';
$directories = get_first_level_directories_from_root();

if (isset($_GET['keyword']) && is_string($_GET['keyword']) && !empty($_GET['keyword']))
{
	if (!isset($_GET['dirs']) || !is_array($_GET['dirs']))
	{
		$dirs = array();
	}
	else {
		$dirs = array_map('trim', $_GET['dirs']);
	}
	if ($dirs && (count($dirs) != count($directories)))
	{
		$files_array = array();
		foreach ($dirs as $dir){
			$files_array += dir_to_array($dir);
		}
	}
	else{
		$files_array = dir_to_array($current_dir);
	}
	$keyword = $_GET['keyword'];

	foreach ($files_array as $file)
	{
		$occurrences = search_in_file($file, $keyword);
		if (!$occurrences) continue;

		$found_in_files[] = array(
			'filename'    => basename($file),
			'dirname'     => str_replace($current_dir, '', dirname($file)),
			'occurrences' => $occurrences,
			'filesize'    => filesize($file)
		);
	}
}

# allowed sections
$sections = array(
	'home',
	'options',
	'download'
);

if (!isset($_GET['section']) || !in_array($_GET['section'], $sections) || $_GET['section'] == 'home')
{
	if (!isset($_GET['dirs']) || !is_array($_GET['dirs'])) {
		$dirs = array();
	}
	else {
		$dirs = array_map('trim', $_GET['dirs']);
	}
	$directories = array(-1 => '.') + $directories;

?>
	<?php html_header('Homepage'); ?>
	<h2>Search in files for keyword</h2>
	<div class="mb10">
		<a href="?section=options">Options</a>
	</div>
	<p>Current path is <b><?php echo $current_dir;?></b></p>
	<hr>
	<form method="get" action="<?php echo $current_link;?>">
		<label class="db mb10"><b>KEYWORD:</b> <input type="text" name="keyword" value="<?php echo htmlentities($keyword, ENT_QUOTES, 'UTF-8');?>" /></label>
		<h4 class="mb10">Search directories</h4>
		<div class="scrollbox mb10">
			<?php foreach ($directories as $i => $directory) { ?>
				<div class="<?php if ($i % 2 == 0) { ?>even<?php } else { ?>odd<?php } ?>"><label><input type="checkbox" value="<?php echo $directory;?>" name="dirs[]"<?php if (empty($dirs) || in_array($directory, $dirs)) { ?> checked<?php } ?>> <?php echo $directory;?></label></div>
			<?php } ?>
		</div>
		<input type="submit" name="sbm" value="Search" />
		<?php if (1 || $keyword) { ?>
			<a href="<?php echo $current_link;?>">Reset search</a>
		<?php } ?>
	</form>
	<?php if ($keyword) { ?>
		<?php if ($found_in_files) { ?>
			<table>
				<thead>
					<tr>
						<td>#</td>
						<td>Filename</td>
						<td>Path</td>
						<td>FullPath</td>
						<td>Occurrences</td>
						<td>Filesize</td>
					</tr>
				</thead>
				<tbody>
					<?php

					foreach ($found_in_files as $i => $file)
					{
						$first_lvl_dirname = ($file['dirname'] == '.') ? $file['dirname'] : ltrim(substr($file['dirname'], 0, strpos($file['dirname'], '/', 1)), '/');

						if (!$dirs || in_array($first_lvl_dirname, $dirs))
						{
							?><tr>
								<td><?php echo ++$i;?></td>
								<td class="blue"><?php echo $file['filename'];?></td>
								<td class="blue"><?php echo $file['dirname'];?></td>
								<td class="orange"><?php echo $file['dirname'].'/'.$file['filename'];?></td>
								<td class="orange"><?php echo $file['occurrences'];?></td>
								<td><?php echo str_replace('.00', '', human_filesize($file['filesize']));?></td>
							</tr><?php
						}
					}

					?>
				</tbody>
			</table>
		<?php } else { ?>
			<p class="orange">No files were found</p>
		<?php } ?>
	<?php } else { ?>
		<p class="orange">Please insert a keyword</p>
	<?php } ?>
	<?php html_footer(); ?>
<?php

}
elseif ($_GET['section'] == 'download') {

	$data = file_get_contents(__FILE__);
	header('Content-Type: application/x-httpd-php');
	header('Content-Disposition: attachment; filename="'.$current_file.'"');
	header("Content-Transfer-Encoding: binary");
	header('Expires: 0');
	header('Pragma: no-cache');
	header("Content-Length: ".strlen($data));
	echo $data;
	exit;

}
elseif ($_GET['section'] == 'options') {

	html_header('Options');
?>
	<h2>Search in files for keyword</h2>
	<div class="mb10">
		<a href="?section=home">&lt; Homepage</a>
	</div>
	<p>Current path is <b><?php echo $current_dir;?></b></p>
	<hr>
	<h3 class="mb10">Download this file</h3>
	<a href="?section=download" class="btn btn-warning">Download</a>

<?php } ?>