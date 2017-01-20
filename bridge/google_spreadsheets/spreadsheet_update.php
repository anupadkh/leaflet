<?php $spreadsheetId = '123abc';
$requests = array();
// Change the name of sheet ID '0' (the default first sheet on every
// spreadsheet)
$requests[] = new Google_Service_Sheets_Request(array(
  'updateSheetProperties' => array(
    'properties' => array('sheetId' => 0, 'title' => 'New Sheet Name'),
    'fields' => 'title'
  )
));
//Insert the values 1, 2, 3 into the first row of the spreadsheet with a
//different background color in each.
$requests[] = new Google_Service_Sheets_Request(array(
  'updateCells' => array(
    'start' => array(
      'sheetId' => 0,
      'rowIndex' => 0,
      'columnIndex' => 0
    ),
    'rows' => array(array(
       'values' => array(
          array(
            'userEnteredValue' => array('numberValue' => 1),
            'userEnteredFormat' => array('backgroundColor' => array('red' => 1))
          ), array(
            'userEnteredValue' => array('numberValue' => 2),
            'userEnteredFormat' => array('backgroundColor' => array('blue' => 1))
          ), array(
            'userEnteredValue' => array('numberValue' => 3),
            'userEnteredFormat' => array('backgroundColor' => array('green' => 1))
          )
        )
      )
    ),
    'fields' => 'userEnteredValue,userEnteredFormat.backgroundColor'
  )
));
// Write "=A1+1" into A2 and fill the formula across A2:C5 (so B2 is
// "=B1+1", C2 is "=C1+1", A3 is "=A2+1", etc..)
$requests[] = new Google_Service_Sheets_Request(array(
  'repeatCell' => array(
    'range' => array(
      'sheetId' => 0,
      'startRowIndex' => 1,
      'startColumnIndex' => 0,
      'endRowIndex' => 6,
      'endColumnIndex' => 3
    ),
    'cell' => array('userEnteredValue' => array('formulaValue' => '=A1 + 1')),
    'fields' => 'userEnteredValue'
  )
));
// Copy the format from A1:C1 and paste it into A2:C5, so the data in each
// column has the same background.
$requests[] = new Google_Service_Sheets_Request(array(
  'copyPaste' => array(
    'source' => array(
      'sheetId' => 0,
      'startRowIndex' => 0,
      'startColumnIndex' => 0,
      'endRowIndex' => 1,
      'endColumnIndex' => 3
    ),
    'destination' =>  array(
      'sheetId' => 0,
      'startRowIndex' => 1,
      'startColumnIndex' => 0,
      'endRowIndex' => 6,
      'endColumnIndex' => 3
    ),
    'pasteType' => 'PASTE_FORMAT'
  )
));

$batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(array(
  'requests' => $requests
));

$service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);
?>