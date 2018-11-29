// -- GLOBAL VARIABLES --
var myFuncCalls = 0;
var startRow  = -1;
var startCol  = -1;
var endRow    = -1;
var endCol    = -1;

// allow the click operation on the table
function clickable(){
  var table = document.getElementById("table");     // select the table
  var columns = table.getElementsByTagName('td');   // select al the `td` children of `table`
  for (i = 0; i < columns.length; i++) {            // for each column
      if(columns[i].className == "W"){              // for each row, if the class is W (white)
        columns[i].addEventListener('click', mark); // set the event `addEventListener`
        // if the are others class inside the cell
        // (if the cell is already filled)
        // the click is denied
      }
  }
}

// deny the click operation on the table
function nonClickable(){
  myFuncCalls = 0;
  startRow  = -1;
  startCol  = -1;
  endRow    = -1;
  endCol    = -1;
  var table = document.getElementById("table");   // select the table
  var columns = table.getElementsByTagName('td'); // select al the `td` children of `table`
  for (i = 0; i < columns.length; i++) {
    if(columns[i].className == "M"){              // if the cell was TEMPORARY marked
      columns[i].className = 'W';                 // restore the default class
    }
      columns[i].removeEventListener("click", mark); // remove the event `addEventListener`
  }
}


// mark a cell
function mark(e) {

    var td = e.target;  // cacth the clicked element
    if(myFuncCalls == 0){ // place the first block                --- 1ST ITERATION ---
      startRow = td.getAttribute("row");  // set `startRow`
      startCol = td.getAttribute("col");  // set `startCol`
      td.setAttribute("class","M");       // mark the first blockvariable ensure that
      myFuncCalls++;                      // increment the global counter
    }else if(myFuncCalls == 1){ // place the end block            --- 2ND ITERATION ---
      endRow = td.getAttribute("row");  // set `endRow`
      endCol = td.getAttribute("col");  // set `endCol`
      if((startRow != endRow) & (startCol != endCol)){  // check if we are trying to place it diagonnally
        // FORBIDDEN POSITION!
        // clear `endRow` and `endCol`
        // and do not increment the counter
        // since we are looking for another
        // block in a allowed position
        endRow = -1;  // reset `endRow`
        endCol = -1   // reset `endCol`
      }else{  // if we are trying to place them correctly

        if(startRow == endRow){ // if we are on the same row

          if(startCol > endCol){ // we hawe to swap the start block with the end block
            swapBlocks();
          }

          for (var i = 0; i < endCol-startCol; i++) { // fill the intermediate blocks
            var id = "";
            var index = parseInt(startCol)+i;
            var id    = startRow + "-" + index.toString();
            var elem  = document.getElementById(id);
            if (elem.className != "X"){
              elem.setAttribute("class","M");
            }
          }

        }else{  // otherwise we are on the same column

          if(startRow > endRow){ // we hawe to swap the start block with the end block
            swapBlocks();
          }

          for (var i = 0; i < endRow-startRow; i++) { // fill the intermediate blocks
            var id = "";
            var index = parseInt(startRow)+i;
            var id    = index.toString() + "-" + startCol;
            var elem  = document.getElementById(id);
            if (elem.className != "X"){
              elem.setAttribute("class","M");
            }
          }

      } // end of same column
      td.setAttribute("class","M");       // mark the last block
      myFuncCalls++;                      // this allow only
                                          // two click on the table

      // fill the `hidden form`
      document.getElementById('startRow').value = startRow;
      document.getElementById('startCol').value = startCol;
      document.getElementById('endRow').value = endRow;
      document.getElementById('endCol').value = endCol;

      // show the submit butto
      $("#submit").show();

    } // end of correct placing
  } // end of second block
} // end of function

// swap the end with the begin 
function swapBlocks(){
  var tmp = 0;
  tmp = startRow;
  startRow = endRow;
  endRow = tmp;

  tmp = startCol;
  startCol = endCol;
  endCol = tmp;
}
