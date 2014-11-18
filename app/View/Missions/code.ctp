<?php
$this->set('title',"Code QR");
?>

<div id="cont" class="util">
    <h1 style="font-size: xx-large;color: #cb0000;"><?php echo $chaine; ?></h1>
    <div id="qrcode" onmouseover="scanit()">
        <img src="http://chart.googleapis.com/chart?cht=qr&chl=<?php echo $code; ?>&chs=500x500&choe=UTF-8&chld=L|4" id="mainImg" />
        <b class="scanner" style="top: -316px; transition: 20s; -webkit-transition: 20s; background-position: -290px 0px;"></b>
    </div>
    <div class="actionscdx">
        <ul>
            <li><input type="submit" value="Imprimer" onclick="printImg()"  /></li>
        </ul>
    </div>
</div>

<script type="text/javascript">
function printImg() { 
  var image = document.getElementById('mainImg');
  printImage(image);
}
function printImage(image)
{
        var printWindow = window.open('', 'Print Window','height=400,width=600');
        printWindow.document.write('<html><head><title></title>');
        printWindow.document.write('</head><body ><center><img src=\'');
        printWindow.document.write(image.src);
        printWindow.document.write('\'/></body></html>');
        printWindow.document.close();
        printWindow.print();
}


function scanit() {
    $(".scanner").css({"top":"-316px","transition":"20s","background-position":"-290px 0px"});
    setTimeout(function()
    {
        $(".scanner").css({"top":"0px","transition":"20s","background-position":"-16px 0px"});
    },30000);
}
</script>