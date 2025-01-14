<?php
class Pagination
{
	private $totalrows;
	private $rowsperpage;
	private $website;
	private $page;
	private $sql;
		
	public function __construct($sql, $rowsperpage, $website='', $dbconnect='')
	{
		$this->sql = $sql;
		$this->website = (($website)?$website:$_SERVER['PHP_SELF']."?");
		$this->rowsperpage = $rowsperpage;
		$this->dbconnect = $dbconnect;
	}
	
	public function setPage($page)
	{
		if (!$page) { $this->page=1; } else  { $this->page = $page; }
	}
	
	public function getLimit()
	{
		return ($this->page - 1) * $this->rowsperpage;
	}
	
	private function getTotalRows()
	{
		$result = q($this->sql,$this->dbconnect) or die ("Pagination query failed!");	
		$this->totalrows = nr($result);
	}
	
	private function getLastPage()
	{
		return ceil($this->totalrows / $this->rowsperpage);
	}
	
	public function showPage()
	{
		$this->getTotalRows();
		
		$pagination = "";
		$lpm1 = $this->getLastPage() - 1;
		$page = $this->page;
		$prev = $this->page - 1;
		$next = $this->page + 1;
		
		$pagination .= "<div class=\"pagination\"";
		if($margin || $padding)
		{
			$pagination .= " style=\"";
			if($margin)
				$pagination .= "margin: $margin;";
			if($padding)
				$pagination .= "padding: $padding;";
			$pagination .= "\"";
		}
		$pagination .= ">";
		
		
		
		if ($this->getLastPage() > 1)
		{
			if ($page > 1) 
				$pagination .= "<a href=$this->website&page1=$prev>&laquo; prev</a>";
			else
				$pagination .= "<span class=\"disabled\">&laquo; prev</span>";
			
			
			if ($this->getLastPage() < 9)
			{	
				for ($counter = 1; $counter <= $this->getLastPage(); $counter++)
				{
					if ($counter == $page)
						$pagination .= "<span class=\"current\">".$counter."</span>";
					else
						$pagination .= "<a href=$this->website&page1=$counter>".$counter."</a>";					
				}
			}
			
			elseif($this->getLastPage() >= 9)
			{
				if($page < 4)		
				{
					for ($counter = 1; $counter < 6; $counter++)
					{
						if ($counter == $page)
							$pagination .= "<span class=\"current\">".$counter."</span>";
						else
							$pagination .= "<a href=$this->website&page1=$counter/>".$counter."</a>";					
					}
					$pagination .= "...";
					$pagination .= "<a href=$this->website&page=$lpm1>".$lpm1."</a>";
					$pagination .= "<a href=$this->website&page1=".$this->getLastPage().">".$this->getLastPage()."</a>";		
				}
				elseif($this->getLastPage() - 3 > $page && $page > 1)
				{
					$pagination .= "<a href=$this->website&page1=1>1</a>";
					$pagination .= "<a href=$this->website&page1=2>2</a>";
					$pagination .= "...";
					for ($counter = $page - 1; $counter <= $page + 1; $counter++)
					{
						if ($counter == $page)
							$pagination .= "<span class=\"current\">".$counter."</span>";
						else
							$pagination .= "<a href=$this->website&page1=$counter>".$counter."</a>";					
					}
					$pagination .= "...";
					$pagination .= "<a href=$this->website&page1=$lpm1>$lpm1</a>";
					$pagination .= "<a href=$this->website&page1=".$this->getLastPage().">".$this->getLastPage()."</a>";		
				}
				else
				{
					$pagination .= "<a href=$this->website&page1=1>1</a>";
					$pagination .= "<a href=$this->website&page1=2>2</a>";
					$pagination .= "...";
					for ($counter = $this->getLastPage() - 4; $counter <= $this->getLastPage(); $counter++)
					{
						if ($counter == $page)
							$pagination .= "<span class=\"current\">".$counter."</span>";
						else
							$pagination .= "<a href=$this->website&page1=$counter>".$counter."</a>";					
					}
				}
			}
		
		if ($page < $counter - 1) 
			$pagination .= "<a href=$this->website&page1=$next>next &raquo;</a>";
		else
			$pagination .= "<span class=\"disabled\">next &raquo;</span>";
		$pagination .= "</div>\n";			
		}	
					
		return $pagination;
	}
}
?>