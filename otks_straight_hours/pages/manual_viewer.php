<?php
  $file = '../../otks documents/OTKS Straight Request/OTKS_Straight_Module_Requestor User_Manual.pdf';
  $filename = 'filename.pdf';
  header('Content-type: application/pdf');
  header('Content-Disposition: inline; filename="' . $filename . '"');
  header('Content-Transfer-Encoding: binary');
  header('Accept-Ranges: bytes');
  @readfile($file);
?> - See more at: http://yogeshchaugule.com/blog/2013/how-display-pdf-browser-php#sthash.Vm1kQqxV.dpuf