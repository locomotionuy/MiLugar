<?php
//http://php-estudios.blogspot.com/search?q=PDO_Pagination
class PDO_Pagination
{
public $conn;
public $total;
public $page;
public $total_page;
public $start_row;
public $item;
public $max_pages;
public $max_rows;
public $step;
public $max;
public $param;
public $btn_first_page;
public $btn_last_page;
public $btn_next_page;
public $btn_back_page;
public $btn_page;
public $btn_active;

public function __construct($conn) {
	$this->btn_first_page = 'Primera';
	$this->btn_last_page = 'Último';
	$this->btn_next_page = 'Siguiente';
	$this->btn_back_page = 'Atrás';
	$this->btn_page = 'Pag.';
	$this->btn_active = 'active';
    return $this->connection = $conn;
}


public function rowCount($query)
{
$query = $this->connection->prepare($query);
$query->execute();
$this->total = $query->rowCount();
}

public function config($max_pages, $max_rows)
{
    
$this->start_row = 0;
$this->item = 0;
$this->max_pages = $max_pages;
$this->max_rows = $max_rows;
$this->total_page = $this->total / $this->max_rows;

if (isset($_GET["page"]))
{
$this->page = $_GET["page"];
if ($this->page < 0 || !preg_match("/^([0-9])+$/", $this->page))
{
return;
}

$this->start_row = $this->page * $this->max_rows;

$this->item = $_GET["item"];
if ($this->item < 0  || !preg_match("/^([0-9])+$/", $this->item))
{
return;
}

$this->max_pages = $this->max_pages + $this->max_rows;

$this->max = $_GET["max"];
if ($this->max < 0  || !preg_match("/^([0-9])+$/", $this->max))
{
return;
}
$this->max_pages = $this->max;
}


if(isset($_GET["next_page"]))
{
$this->page = $_GET["next_page"];
if ($this->page < 0  || !preg_match("/^([0-9])+$/", $this->page))
{
return;
}

$this->start_row = $this->page * $this->max_rows;

$this->item = $_GET["item"];
if ($this->item < 0  || !preg_match("/^([0-9])+$/", $this->item))
{
return;
}
if(isset($_GET["max"])){
	$this->max = $_GET["max"];
	if ($this->max < 0  || !preg_match("/^([0-9])+$/", $this->max))
	{
	return;
	}
	$this->max_pages = $this->max + 1;
	}
}

if(isset($_GET["back_page"]))
{
$this->page = $_GET["back_page"] - 1;
if ($this->page < 0  || !preg_match("/^([0-9])+$/", $this->page))
{
return;
}
$this->start_row = $this->page * $this->max_rows;

if(isset($_GET["item"])){
	$this->item = $_GET["item"] - 1;
	if ($this->item < 0  || !preg_match("/^([0-9])+$/", $this->item))
	{
	return;
	}
}
if(isset($_GET["max"])){
	$this->max = $_GET["max"];
	if ($this->max < 0  || !preg_match("/^([0-9])+$/", $this->max))
	{
	return;
	}
}

$this->max_pages = $this->max - 1;
}

if (isset($_GET["previous"]))
{
$this->max_pages = $this->max_pages;
$this->start_row=0;
$this->item = 0;
}
}

public function pages($class='')
{
  
if($this->item >= 1)
{
echo "<a class='$class'  href='?previous=1".$this->param."'>$this->btn_first_page</a>";
echo "<a class='$class'  href='?back_page=$this->page&item=$this->item&max=$this->max_pages&fix=1".$this->param."'>$this->btn_back_page</a>";
}
for($x = $this->item; $x < $this->max_pages; $x++)
{
while($x * $this->max_rows < $this->total)
{
$p = $x+1;
$this->page == $p-1 ? $active = ' ' . $this->btn_active : $active = null;
echo "<a class='$class$active' href='?page=$x&item=$this->item&max=$this->max_pages".$this->param;
//echo "'>$p</a>";
//echo '&fix=1';
	
//$inmobiliaria = $_GET['inmobiliaria'];

if(!isset($_GET['inmobiliaria']) && isset($_GET['operacion'])){
	$urlstring = $_SERVER['QUERY_STRING'];
	$urlexplode = explode("operacion", $urlstring);
	echo "&operacion".$urlexplode[1];
}else if(isset($_GET['inmobiliaria'])){
	echo "&inmobiliaria=".$_GET['inmobiliaria'];
}
/*$urlentera = http_build_query($_GET);
	unset($urlentera['page']);
	unset($urlentera['item']);
	unset($urlentera['max']);*/
	
/*foreach($_GET as $key => $value)
       if($key!=='page' && $key!=='item' && $key!=='max'){
		   if(is_array($_GET[$key])){
			   foreach($_GET[$key] as $key2 => $value2)
			   		echo "&".$_GET[$key][$key2] ."=" . $_GET[$key][$value2];
		   }
		   else{
			   echo "&".$key ."=" . $value;
		   } 
	   } */


//echo "&".$urlentera;
echo "'>$p</a>";
break;
}
}
$numbers = $this->page+1;
echo "<span class='$class'>$this->btn_page <b>$numbers</b></span>";

if ($this->max_pages * $this->max_rows < $this->total)
{
$this->page = $this->page+1;
$this->item = $this->item + 1;
echo "<a class='$class' href='?next_page=$this->page&item=$this->item&max=$this->max_pages".$this->param."'>$this->btn_next_page</a>";

$this->page = round($this->total_page - 1);
$this->item = round($this->total_page - $this->max_pages);
$this->max = round($this->total_page);
echo "<a class='$class'  href='?page=$this->page&item=$this->item&max=$this->max".$this->param."'>$this->btn_last_page</a>";
}
}
}
?>