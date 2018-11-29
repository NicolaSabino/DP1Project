<?php

	class Brick {

		public $owner;
		public $startRow;
		public $startColumn;
		public $endRow;
		public $endColumn;

		public function __construct(){
			if (0 === func_num_args()) { // costruttore senza parametri
	            // empty brick
	    } else{
				$this->owner				= func_get_arg(0);
				$this->startRow 		= func_get_arg(1);
				$this->startColumn	= func_get_arg(2);
				$this->endRow				= func_get_arg(3);
				$this->endColumn		= func_get_arg(4);
			}
		}

		// store a brick in the database
		public function store(){
			$conn = createConnection(); // create a new connection
			try {

				mysqli_autocommit ( $conn, false ); // disable autocommit
				// create the query
				$query = "INSERT INTO Bricks(owner,startRow,startColumn,endRow,endColumn)
				 VALUES ('" . $this->owner . "','"
								 . $this->startRow . "', '"
								 . $this->startColumn . "', '"
								 . $this->endRow . "', '"
								 . $this->endColumn . "')";



			 // try to execute the query
			 if (!mysqli_query ( $conn, $query )) {
					throw new Exception ( "Error while `INSERT`: " . mysqli_error($conn));
			 }

			 // commit
				if (!mysqli_commit ( $conn )) {
					throw Exception ( "Error while `COMMIT`" );
				}

			} catch (Exception $e) {
				mysqli_free_result($insert);
				errorRedirector($e->getMessage());
			}
			mysqli_close ( $conn );
		}

		public function checkConstraints(){

			global $brick_lenght;

			// - 1st CONSTRAINT - check the lenght
			// since the final shape cannot be placed diaggonally,
			// the sum of the lenghts on each direction
			// (vertical and horizontal) must be:
			// [0(v) + lenght(h)] or [lenght(v) + 0(h)].
			// At the end we add 1 since the starting brick
			// is not considered

			$lenght = $this->endRow - $this->startRow;
			$lenght += $this->endColumn - $this->startColumn;
			$lenght += 1;

			if($lenght != $brick_lenght){
				return false;
			}

			$bricks = retrieveBricks();	// select all bricks in the DB

			if($bricks == -1){
	      errorRedirector("can't retrive bricks");
	    }

				// - 2nd CONSTRAINT - check for intersection
				// - 3rd CONSTRAINT - check intersection in the neighborhood

				// calculate the equvalent matrix
				$firstMat = $this->seToMat($this->startRow,
													$this->startColumn,
													$this->endRow,
													$this->endColumn);

	    foreach ($bricks as $key => $brick) { // for each brick in the db
				// generate the corresponding array
				// for each brick stored in the DB
				$secondMat = $this->seToMat($brick->startRow,
													$brick->startColumn,
													$brick->endRow,
													$brick->endColumn);

				//check intersections
				for ($i=0; $i < $brick_lenght; $i++) { // scan `firstMat` moving through columns
					for ($j=0; $j < $brick_lenght ; $j++) { // scan `secondMat` moving through columns
						// for each couple of coordinates in `secondMat`
						// we generate the neighborhood
						$neighborhood = $this->getNeighborhood($secondMat[1][$j],$secondMat[0][$j]);
						for ($k=0; $k < 9; $k++) { // scan the `neighborhood`
							if (($firstMat[0][$i] == $neighborhood[0][$k])
									&& ($firstMat[1][$i] == $neighborhood[1][$k])) {
								return false; //intersection
							} // end if "intersection"
						}// end scan `neighborhood`
					} // end scan `secondMat`
				} // end scan `firstMat`
			} // end foreach
		return true;
		} // end `checkConstraints`



		//	Trasform the two ends of the brick
		//	in a matrix 2 * $brick_lenght
		//	-------------------------------
		// example: sR=1 sC=3 eR=1 eC=6
		//
		//					+---+---+---+---+
		//	COLUMNS	| 3 | 4 | 5 | 6 |	X axes
		//					+---+---+---+---+
		//	ROWS		| 1 | 1 | 1 | 1 | Y axes
		//					+---+---+---+---+

		private function seToMat($sR,$sC,$eR,$eC){
			global $brick_lenght;
			// empty matrix
			foreach (range(0,1) as $row) {
			 foreach (range(0,$brick_lenght-1) as $col) {
				$matrix[$row][$col] = 0;
			 }
			}

			$j = 0;
			if($sR == $eR){	// if startRow == endRow
				for ($i=0; $i < $brick_lenght; $i++){
					$matrix[0][$i] = $sC + $j;
					$matrix[1][$i] = $sR;
					$j++;
				}
			}else if($sC == $eC){ // otherwise
				for ($i=0; $i < $brick_lenght; $i++) {
					$matrix[0][$i] = $sC;
					$matrix[1][$i] = $sR + $j;
					$j++;
				}
			}

			return $matrix;
		}

		//	Generate a neighborhood matrix from
		//	------------------------------------
		//	a given coordinate couple ROW:COLUMN
		//	example: R=1 C=3
		//
		//		+-----+---------+-----+
		//		| 0:2 |   0:3   | 0:4 |
		//		+-----+---------+-----+
		//		| 1:2 |  [1:3]  | 1:4 |
		//		+-----+---------+-----+
		//		| 2:2 |   2:3   | 2:4 |
		//		+-----+---------+-----+
		//
		//	The result is a matrix 2*9
		//
		//					+---+---+---+---+---+---+---+---+---+
		//	COLUMN	| 2 | 3 | 4 | 2 | 3 | 4 | 2 | 3 | 4 |	X axes
		//					+---+---+---+---+---+---+---+---+---+
		//	ROWS		| 0 | 0 | 0 | 1 | 1 | 1 | 2 | 2 | 2 |	Y axes
		//					+---+---+---+---+---+---+---+---+---+
		//
		//	NB: in case we are at the border of the table
		// 	some values simply does not have realistic values
		//	but it doesnt affect the mechanism in the `checkConstraints`
		//	function
		//	example: R=0 C=0
		//		+-------+-------+-------+
		//		| -1:-1 | -1:0  | -1:1  |
		//		+-------+-------+-------+
		//		|  0:-1 | [0:0] |  0:1  |
		//		+-------+-------+-------+
		//		| 1:-1  |  1:0  | 1:1   |
		//		+-----+---------+-------+
		//
		private function getNeighborhood($row,$col){
			$matrix_index = 0;
			for ($i=$row-1; $i < $row+2 ; $i++) {	// all possible combination of row
				for ($j=$col-1; $j <$col+2 ; $j++) { // all possible combination of columns
					$matrix[1][$matrix_index] = $i;
					$matrix[0][$matrix_index] = $j;
					$matrix_index++; // increase the position in `matrix`
				} // end for j
			} // end for i
			return $matrix;
		} // end function

	}
 ?>
