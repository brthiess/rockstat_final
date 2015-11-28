<!DOCTYPE html>
<html lang='en-US'>
<?php
include_once "views/header.php";
print_header(array("<script src=\"/js/chart.min.js\"></script>", "<script src=\"/js/stats.js\"></script>" ));
echo "<body><div id=\"wrapper\">";

include_once "views/banner.php";
include_once "views/stats-views/player-view.php";

echo "<div id=\"push\"></div></div>";
include_once "views/footer.php";

?>
</body>
</html>