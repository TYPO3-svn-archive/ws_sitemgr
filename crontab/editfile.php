<?
class editFile {
	function editFile($filedir, $filename) {
			
			$this->replaceI = 1;
			$this->lineI = 1;
			
			exec('mv ' . $filedir . $filename . ' ' . $filedir . $filename . '.temp');
			$handle = fopen($filedir . $filename . '.temp', "r");
			$this->content = fread($handle, filesize($filedir . $filename . '.temp'));
			fclose($handle);
			
			$this->content = explode("\n",$this->content);
			$this->content_write = fopen($filedir . $filename, 'w');
	}
	function add_replace($search, $replace) {
			$this->replace[$this->i]['search'] = $search;
			$this->replace[$this->i]['replace'] = $replace;
			$this->replaceI++;
	}
	function search_replace ($search) {
			foreach ($this->replace as $replace) {
				if (strstr($search, $replace['search'])) { return $replace['replace']; }
			}
			return 0;
	
	}	
	function add_markers ($markers) {
			$this->markers = explode(",",$markers);
	}
	function add_line($line) {
		$this->add[$this->lineI] = $line;
		$this->lineI++;
	}				
	function do_actions() {
 		
 		foreach ($this->content as $line) {
				//echo $line , " = "; 
				// ### Replace ###
				$line = (@$this->search_replace($line)) ? @$this->search_replace($line) : $line;
				
				
				// ### Add between markers ###
				if ($line == $this->markers[0]) { $marker = 1; }
				if ($line == $this->markers[1]) { $marker = 0; $nowrite = 0; }
				
				if ($marker == 1 && $markerdataadded == 1) { $nowrite = 1; }
				if (($marker == 1 && $markerdataadded != 1) && ($line != $this->markers[0])) { $line = @implode("\n",$this->add); $markerdataadded = 1; }
				
				if ($nowrite != 1) { fwrite($this->content_write, $line . "\n"); }
		}		
	}
	
	
	function close (){
			fclose($this->content_write);
			unlink($filedir . $filename . '.temp');
	}
	

}
?>