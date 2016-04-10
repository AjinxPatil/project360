<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
function Show_Popup(action, userid) {
$('#popup').fadeIn('fast');
$('#window').fadeIn('fast');
}
function Close_Popup() {
$('#popup').fadeOut('fast');
$('#window').fadeOut('fast');
}
</script>
<div id="popup" style="display: none;"><h5>gjerlgj</h5></div>
<div id="window" style="display: none;">
<div id="popup_content" ><a href="#" onclick="Close_Popup();">Close</a> </div>
</div>
<input name="showpopup" type="button" onClick="Show_Popup()">
<style type="text/css">
#popup {
height: 100%;
width: 100%;
background: #000000;
position: absolute;
top: 0;
-moz-opacity:0.75;
-khtml-opacity: 0.75;
opacity: 0.75;
filter:alpha(opacity=75);
}
#window {
width: 600px;
height: 300px;
margin: 0 auto;
border: 1px solid #000000;
background: #ffffff;
position: absolute;
top: 200px;
left: 25%;
}
